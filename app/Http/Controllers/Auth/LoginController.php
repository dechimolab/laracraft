<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LogLogin;
use App\Models\User;
use App\Services\Auth\LdapAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public const LOGIN_FAILED_MESSAGE = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    public const THROTTLE_WAIT_MESSAGE = 'พยายามเข้าสู่ระบบมากเกินไป กรุณารอสักครู่แล้วลองใหม่';

    protected LdapAuthService $ldapAuth;

    public function __construct(LdapAuthService $ldapAuth)
    {
        $this->ldapAuth = $ldapAuth;
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('generator.step1');
        }

        $rememberedUsername = (string) $request->cookie('remembered_username', '');
        $rememberChecked = !empty($rememberedUsername);

        return view('auth.login', compact('rememberedUsername', 'rememberChecked'));
    }

    /**
     * Authenticate user with LDAP using config in constants.configLdap.
     */
    public function checkLdap($username = '', $password = '')
    {
        return $this->ldapAuth->checkLdap($username, $password);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = Str::lower(trim((string) $request->input('username')));
        $throttleKey = $request->ip() . '|' . $username;

        $attemptsKey = 'login_failed_attempts:' . $throttleKey;
        $lockoutUntilKey = 'login_lockout_until:' . $throttleKey;
        $stepKey = 'login_lockout_step:' . $throttleKey;

        // 1. Check if user is currently locked out
        $lockoutUntil = Cache::get($lockoutUntilKey);
        if ($lockoutUntil && now()->timestamp < $lockoutUntil) {
            $remainingSeconds = $lockoutUntil - now()->timestamp;
            $remainingMinutes = (int) ceil($remainingSeconds / 60);

            Log::warning("Login blocked by rate limit for {$throttleKey}. Remaining: {$remainingSeconds}s");

            $this->recordLoginLog($request, null, $username, false, 'พยายามเข้าสู่ระบบมากเกินกำหนด (Rate Limit Blocked)');

            return back()->with('error', "พยายามเข้าสู่ระบบผิดพลาดเกินกำหนด กรุณารออีก {$remainingMinutes} นาทีก่อนลองใหม่อีกครั้ง")
                         ->withInput($request->only('username'));
        }

        $remember = $request->boolean('remember');

        // Set Remember Me duration for SessionGuard to 30 days (43,200 minutes)
        if (method_exists(Auth::guard('web'), 'setRememberDuration')) {
            Auth::guard('web')->setRememberDuration(30 * 24 * 60);
        }

        // 2. Attempt authentication (AD / DB)
        if ($this->ldapAuth->authenticate($request->username, $request->password, $remember)) {
            // Authentication succeeded! Reset all rate limit counters & step
            Cache::forget($attemptsKey);
            Cache::forget($lockoutUntilKey);
            Cache::forget($stepKey);
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            // Manage Remember Me cookie for 30 days (43,200 minutes)
            if ($remember) {
                Cookie::queue('remembered_username', (string) $request->input('username'), 30 * 24 * 60);
            } else {
                Cookie::queue(Cookie::forget('remembered_username'));
            }

            // Record successful login in log_login table
            $this->recordLoginLog($request, Auth::user(), (string) $request->input('username'), true, 'เข้าสู่ระบบสำเร็จ (Login Successful)');

            return redirect()->intended(route('generator.step1'));
        }

        // 3. Authentication failed (ไม่ผ่าน AD / รหัสผ่านไม่ถูกต้อง)
        // Increment failed attempts
        if (!Cache::has($attemptsKey)) {
            Cache::put($attemptsKey, 1, now()->addHours(24));
            $attempts = 1;
        } else {
            $attempts = (int) Cache::increment($attemptsKey);
        }

        Log::info("Failed login attempt #{$attempts} for {$throttleKey}");

        // Validate rate limit 5 attempts: Lockout 5, 10, 30 minutes by step
        if ($attempts >= 5) {
            $currentStep = (int) Cache::get($stepKey, 0) + 1;
            Cache::put($stepKey, $currentStep, now()->addHours(24));

            // Step 1 => 5 mins, Step 2 => 10 mins, Step 3+ => 30 mins
            $lockoutMinutes = match ($currentStep) {
                1 => 5,
                2 => 10,
                default => 30,
            };

            $lockoutSeconds = $lockoutMinutes * 60;
            Cache::put($lockoutUntilKey, now()->addSeconds($lockoutSeconds)->timestamp, now()->addSeconds($lockoutSeconds));

            // Reset attempts counter for the next round after lockout expires
            Cache::forget($attemptsKey);

            Log::warning("Login rate limit lockout triggered for {$throttleKey}: Step {$currentStep}, locked for {$lockoutMinutes} minutes");

            // Record lockout trigger in log_login table
            $this->recordLoginLog($request, null, $username, false, "พยายามเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง ติด Lockout {$lockoutMinutes} นาที");

            return back()->with('error', "พยายามเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง กรุณารออีก {$lockoutMinutes} นาทีก่อนลองใหม่อีกครั้ง")
                         ->withInput($request->only('username'));
        }

        // Record failed attempt in log_login table
        $this->recordLoginLog($request, null, $username, false, self::LOGIN_FAILED_MESSAGE);

        // Uniform error message for attempts < 5 to prevent user enumeration
        return back()->with('error', self::LOGIN_FAILED_MESSAGE)
                     ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->recordLoginLog(
                $request,
                $user,
                $user->username ?: $user->email,
                true,
                'ออกจากระบบสำเร็จ (Logout)'
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Record login attempt log into log_login table.
     */
    public function recordLoginLog(Request $request, ?User $user, string $username, bool $isSuccess, string $actionMessage = ''): void
    {
        try {
            $userAgent = $request->userAgent() ?? '';

            // Detect OS
            $os = 'Unknown OS';
            if (preg_match('/windows|win32/i', $userAgent)) $os = 'Windows';
            elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) $os = 'iOS';
            elseif (preg_match('/android/i', $userAgent)) $os = 'Android';
            elseif (preg_match('/macintosh|mac os x/i', $userAgent)) $os = 'macOS';
            elseif (preg_match('/linux/i', $userAgent)) $os = 'Linux';

            // Detect Browser
            $browser = 'Unknown Browser';
            if (preg_match('/edg/i', $userAgent)) $browser = 'Microsoft Edge';
            elseif (preg_match('/chrome/i', $userAgent)) $browser = 'Google Chrome';
            elseif (preg_match('/firefox/i', $userAgent)) $browser = 'Mozilla Firefox';
            elseif (preg_match('/safari/i', $userAgent)) $browser = 'Apple Safari';
            elseif (preg_match('/opera|opr/i', $userAgent)) $browser = 'Opera';

            // Detect Device
            $device = 'Desktop';
            if (preg_match('/mobile|android|iphone|ipod/i', $userAgent)) $device = 'Mobile';
            elseif (preg_match('/tablet|ipad/i', $userAgent)) $device = 'Tablet';

            $cleanUsername = $user?->username ?: $username;

            LogLogin::create([
                'fac_id'       => null,
                'dep_id'       => null,
                'lg_date'      => now(),
                'lg_ip'        => $request->ip(),
                'lg_url'       => $request->fullUrl(),
                'username'     => $cleanUsername,
                'user_id'      => $user?->user_id,
                'psn_id'       => $user ? (string) $user->user_id : null,
                'lg_user_name' => $user?->name ?: $cleanUsername,
                'lg_authority' => $isSuccess ? 'User' : null,
                'lg_action'    => $actionMessage ?: ($isSuccess ? 'เข้าสู่ระบบสำเร็จ (Login Successful)' : 'เข้าสู่ระบบไม่สำเร็จ (Failed Login)'),
                'lg_browser'   => $browser,
                'lg_device'    => $device,
                'lg_os'        => $os,
                'created_by'   => $cleanUsername,
                'updated_by'   => $cleanUsername,
                'request_uri'  => $request->getRequestUri(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to write log_login: ' . $e->getMessage());
        }
    }
}
