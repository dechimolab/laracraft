<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     * Complies with sec-permission-from-database: loads user role from database on every request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        if (!$userId) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Direct database query to enforce sec-permission-from-database standard
        $user = User::query()->where('user_id', $userId)->first(['user_id', 'role', 'active']);

        if (!$user || !$user->isActive() || strtolower((string) ($user->role ?? 'developer')) !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized. Administrative privilege required.',
                ], 403);
            }
            abort(403, 'Unauthorized. Administrative privilege required.');
        }

        return $next($request);
    }
}
