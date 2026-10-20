<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebauthnCredential;
use App\Services\WebauthnService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebauthnController extends Controller
{
    public function __construct(
        protected WebauthnService $webauthnService,
        protected LoginController $loginController
    ) {}

    /**
     * Phase 2: Registration Challenge Options for Current User.
     */
    public function registerOptions(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'กรุณาเข้าสู่ระบบก่อนลงทะเบียนลายนิ้วมือ'], 401);
        }

        try {
            $options = $this->webauthnService->generateRegisterOptions($user);
            return response()->json($options);
        } catch (\Throwable $e) {
            Log::error('Webauthn registerOptions error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Phase 2: Verify Registration Response and Save Credential.
     */
    public function registerVerify(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'กรุณาเข้าสู่ระบบก่อนลงทะเบียนลายนิ้วมือ'], 401);
        }

        try {
            $credential = $this->webauthnService->verifyRegistration($user, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'ลงทะเบียนลายนิ้วมือสำเร็จเรียบร้อยแล้ว',
                'credential' => [
                    'cred_id'     => $credential->cred_id,
                    'device_name' => $credential->device_name,
                    'created_at'  => $credential->created_at?->format('d/m/Y H:i'),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Webauthn registerVerify error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Phase 2: List Registered Credentials for Current User.
     */
    public function listCredentials(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'กรุณาเข้าสู่ระบบก่อน'], 401);
        }

        $credentials = $user->webauthnCredentials()
            ->orderByDesc('created_at')
            ->get(['cred_id', 'device_name', 'counter', 'last_used_at', 'created_at']);

        return response()->json([
            'success' => true,
            'credentials' => $credentials,
        ]);
    }

    /**
     * Phase 2: Delete/Revoke a Registered Credential.
     */
    public function deleteCredential(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'กรุณาเข้าสู่ระบบก่อน'], 401);
        }

        $credential = $user->webauthnCredentials()->where('cred_id', $id)->first();
        if (!$credential) {
            return response()->json(['error' => 'ไม่พบข้อมูลอุปกรณ์นี้ หรือไม่มีสิทธิ์ลบ'], 404);
        }

        $credential->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลอุปกรณ์ลายนิ้วมือเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Phase 3: Login Challenge Options (Public).
     */
    public function loginOptions(Request $request): JsonResponse
    {
        try {
            $username = $request->input('username');
            $user = $username ? User::where('username', $username)->first() : null;

            $options = $this->webauthnService->generateLoginOptions($user);
            $options['total_credentials'] = WebauthnCredential::count();
            $options['user_has_credentials'] = $user ? $user->webauthnCredentials()->count() > 0 : null;

            return response()->json($options);
        } catch (\Throwable $e) {
            Log::error('Webauthn loginOptions error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Phase 3: Verify Login and Authenticate (Public).
     */
    public function loginVerify(Request $request): JsonResponse
    {
        try {
            $credential = $this->webauthnService->verifyLogin($request->all());
            $user = $credential->user;

            if (!$user) {
                return response()->json(['error' => 'ไม่พบข้อมูลผู้ใช้งานที่ผูกกับลายนิ้วมือนี้'], 404);
            }

            if (!$user->isActive()) {
                Log::warning("WebAuthn login attempted for inactive user: {$user->username}");
                return response()->json(['error' => 'บัญชีผู้ใช้นี้ถูกปิดการใช้งาน กรุณาติดต่อผู้ดูแลระบบ'], 403);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            // Record into log_login
            $this->loginController->recordLoginLog(
                $request,
                $user,
                $user->username ?: $user->email,
                true,
                'เข้าสู่ระบบสำเร็จด้วยลายนิ้วมือ (WebAuthn / Passkey)'
            );

            return response()->json([
                'success' => true,
                'message' => 'ยืนยันตัวตนสำเร็จ',
                'redirect' => route('generator.step1'),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Webauthn loginVerify failed: ' . $e->getMessage());

            // Record failed attempt in log_login
            $this->loginController->recordLoginLog(
                $request,
                null,
                'webauthn_user',
                false,
                'เข้าสู่ระบบด้วยลายนิ้วมือไม่สำเร็จ: ' . $e->getMessage()
            );

            $isNotRegistered = str_contains($e->getMessage(), 'ไม่พบลายนิ้วมือ') || str_contains($e->getMessage(), 'ไม่พบข้อมูล');

            return response()->json([
                'error' => $isNotRegistered ? 'ไม่พบข้อมูลลายนิ้วมือนี้ในระบบ กรุณาเข้าสู่ระบบด้วยรหัสผ่านแล้วไปลงทะเบียนที่หน้าโปรไฟล์ก่อน' : 'การยืนยันตัวตนด้วยลายนิ้วมือไม่ถูกต้องหรือไม่สำเร็จ',
                'not_registered' => $isNotRegistered,
            ], 422);
        }
    }
}
