<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users with search and filter capabilities.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $roleFilter = trim((string) $request->input('role', ''));
        $statusFilter = trim((string) $request->input('status', ''));

        $query = User::query()->withCount('webauthnCredentials');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter !== '') {
            $query->where('role', $roleFilter);
        }

        if ($statusFilter !== '') {
            $query->where('active', $statusFilter);
        }

        $users = $query->orderBy('user_id', 'desc')->paginate(15)->withQueryString();

        // Calculate metrics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $devCount = User::where('role', 'developer')->count();
        $inactiveCount = User::where('active', 'N')->count();

        return view('admin.users.index', [
            'users'         => $users,
            'totalUsers'    => $totalUsers,
            'adminCount'    => $adminCount,
            'devCount'      => $devCount,
            'inactiveCount' => $inactiveCount,
            'search'        => $search,
            'roleFilter'    => $roleFilter,
            'statusFilter'  => $statusFilter,
        ]);
    }

    /**
     * Update the user role and active status.
     */
    public function update(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $request->validate([
            'role'   => 'required|in:admin,developer',
            'active' => 'required|in:Y,N',
        ]);

        $currentAdminId = Auth::id();

        // Self-protection: Admin cannot demote themselves or deactivate themselves
        if ((int) $user->user_id === (int) $currentAdminId) {
            if ($request->input('role') !== 'admin') {
                return $this->respondError($request, 'คุณไม่สามารถลดระดับสิทธิ์ของบัญชีตนเองได้');
            }
            if ($request->input('active') !== 'Y') {
                return $this->respondError($request, 'คุณไม่สามารถปิดบัญชีการใช้งานของตนเองได้');
            }
        }

        $oldActive = $user->active;
        $newActive = $request->input('active');
        $newRole = $request->input('role');

        $user->role = $newRole;
        $user->active = $newActive;
        $user->updated_by = Auth::user()->username ?? 'admin';
        $user->save();

        // If deactivated, purge all active sessions for this user
        if ($oldActive === 'Y' && $newActive === 'N') {
            DB::table('sessions')->where('user_id', $user->user_id)->delete();
        }

        return $this->respondSuccess($request, "อัปเดตสิทธิ์และสถานะของบัญชี [{$user->username}] สำเร็จเรียบร้อยแล้ว");
    }

    /**
     * Toggle user active status between Y and N.
     */
    public function toggleActive(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $currentAdminId = Auth::id();

        // Self-protection: Admin cannot deactivate themselves
        if ((int) $user->user_id === (int) $currentAdminId) {
            return $this->respondError($request, 'คุณไม่สามารถปิดหรือระงับบัญชีการใช้งานของตนเองได้');
        }

        $newActive = ($user->active === 'Y') ? 'N' : 'Y';
        $user->active = $newActive;
        $user->updated_by = Auth::user()->username ?? 'admin';
        $user->save();

        // If deactivated, purge active sessions immediately
        if ($newActive === 'N') {
            DB::table('sessions')->where('user_id', $user->user_id)->delete();
        }

        $actionText = ($newActive === 'Y') ? 'เปิดใช้งานบัญชี' : 'ปิด/ระงับบัญชี';
        return $this->respondSuccess($request, "{$actionText} [{$user->username}] สำเร็จเรียบร้อยแล้ว", [
            'active' => $newActive,
        ]);
    }

    /**
     * Delete the specified user account.
     */
    public function destroy(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $currentAdminId = Auth::id();

        // Self-protection: Admin cannot delete themselves
        if ((int) $user->user_id === (int) $currentAdminId) {
            return $this->respondError($request, 'คุณไม่สามารถลบบัญชีของตนเองออกจากระบบได้');
        }

        $username = $user->username;

        DB::transaction(function () use ($user) {
            // Delete associated sessions
            DB::table('sessions')->where('user_id', $user->user_id)->delete();

            // WebAuthn credentials cascade automatically, but clean explicitly
            DB::table('webauthn_credentials')->where('user_id', $user->user_id)->delete();

            // Preserve login logs by detaching user_id (optional audit compliance)
            DB::table('log_login')->where('user_id', $user->user_id)->update(['user_id' => null]);

            // Delete user row
            $user->delete();
        });

        return $this->respondSuccess($request, "ลบบัญชีผู้ใช้งาน [{$username}] ออกจากระบบเรียบร้อยแล้ว");
    }

    /**
     * Helper to return standard JSON or redirect with flash message.
     */
    protected function respondSuccess(Request $request, string $message, array $extra = []): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(array_merge([
                'success' => true,
                'message' => $message,
            ], $extra));
        }

        return back()->with('success', $message);
    }

    /**
     * Helper to return error response.
     */
    protected function respondError(Request $request, string $message, int $status = 400): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $status);
        }

        return back()->with('error', $message);
    }
}
