<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        RateLimiter::clear('127.0.0.1|unknown.user@company.local');
        RateLimiter::clear('127.0.0.1|lead.architect@artisan.io');
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('เข้าสู่ระบบ ArtisanCraft Engine');
        $response->assertSee('PHP 8.4.1');
        $response->assertSee('ยินดีต้อนรับ');
    }

    public function test_users_can_authenticate_using_fallback_developer_mode(): void
    {
        $response = $this->post('/login', [
            'username' => 'lead.architect@artisan.io',
            'password' => 'SuperSecretPassword123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('generator.step1'));

        // Verify user was inserted into users table
        $this->assertDatabaseHas('users', [
            'email' => 'lead.architect@artisan.io',
            'username' => 'lead.architect',
        ]);
    }

    public function test_users_can_authenticate_using_username(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.p',
            'password' => Hash::make('secret-pass-123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'somchai.p',
            'password' => 'secret-pass-123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('generator.step1'));
    }

    public function test_users_cannot_authenticate_using_citizen_id_directly(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.ad',
            'citizen_id' => '1234567890123',
            'password' => Hash::make('password123'),
        ]);

        // Attempting to login using citizen_id should fail because only AD username is allowed
        $response = $this->post('/login', [
            'username' => '1234567890123',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error', LoginController::LOGIN_FAILED_MESSAGE);
    }

    public function test_users_cannot_authenticate_with_invalid_credentials_and_get_uniform_error(): void
    {
        $response = $this->post('/login', [
            'username' => 'unknown.user@company.local',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error', LoginController::LOGIN_FAILED_MESSAGE);
    }

    public function test_progressive_stepped_rate_limiting_triggers_at_five_attempts(): void
    {
        $username = 'unknown.user@company.local';

        // Attempts 1-4 should get uniform error
        for ($i = 1; $i <= 4; $i++) {
            $response = $this->post('/login', [
                'username' => $username,
                'password' => 'wrong-password',
            ]);
            $response->assertSessionHas('error', LoginController::LOGIN_FAILED_MESSAGE);
        }

        // 5th attempt triggers Step 1 lockout (5 minutes)
        $response5 = $this->post('/login', [
            'username' => $username,
            'password' => 'wrong-password',
        ]);
        $response5->assertSessionHas('error', 'พยายามเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง กรุณารออีก 5 นาทีก่อนลองใหม่อีกครั้ง');

        // Immediate next attempt while locked out
        $responseBlocked = $this->post('/login', [
            'username' => $username,
            'password' => 'wrong-password',
        ]);
        $responseBlocked->assertSessionHas('error', 'พยายามเข้าสู่ระบบผิดพลาดเกินกำหนด กรุณารออีก 5 นาทีก่อนลองใหม่อีกครั้ง');

        // Fast-forward: clear lockout expire timestamp to simulate waiting 5 minutes
        Cache::forget('login_lockout_until:127.0.0.1|' . $username);

        // Second cycle: 5 failed attempts again to trigger Step 2 lockout (10 minutes)
        for ($i = 1; $i <= 4; $i++) {
            $this->post('/login', [
                'username' => $username,
                'password' => 'wrong-password',
            ]);
        }
        $responseStep2 = $this->post('/login', [
            'username' => $username,
            'password' => 'wrong-password',
        ]);
        $responseStep2->assertSessionHas('error', 'พยายามเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง กรุณารออีก 10 นาทีก่อนลองใหม่อีกครั้ง');

        // Fast-forward: clear lockout expire timestamp to simulate waiting 10 minutes
        Cache::forget('login_lockout_until:127.0.0.1|' . $username);

        // Third cycle: 5 failed attempts again to trigger Step 3 lockout (30 minutes)
        for ($i = 1; $i <= 4; $i++) {
            $this->post('/login', [
                'username' => $username,
                'password' => 'wrong-password',
            ]);
        }
        $responseStep3 = $this->post('/login', [
            'username' => $username,
            'password' => 'wrong-password',
        ]);
        $responseStep3->assertSessionHas('error', 'พยายามเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง กรุณารออีก 30 นาทีก่อนลองใหม่อีกครั้ง');
    }

    public function test_successful_login_resets_rate_limit_and_steps(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.p',
            'password' => Hash::make('correct-password'),
        ]);

        // Fail 3 times
        for ($i = 1; $i <= 3; $i++) {
            $this->post('/login', [
                'username' => 'somchai.p',
                'password' => 'wrong-password',
            ]);
        }

        // Now login with correct password
        $response = $this->post('/login', [
            'username' => 'somchai.p',
            'password' => 'correct-password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('generator.step1'));

        // Cache for failed attempts should be cleared
        $this->assertNull(Cache::get('login_failed_attempts:127.0.0.1|somchai.p'));
        $this->assertNull(Cache::get('login_lockout_step:127.0.0.1|somchai.p'));
    }

    public function test_ad_login_inserts_user_when_not_in_users_table(): void
    {
        $service = app(\App\Services\Auth\LdapAuthService::class);

        $ldapUserAttributes = [
            'samaccountname' => ['anond.k'],
            'displayname' => ['อนันต์ กิจเจริญ (Anond K.)'],
            'mail' => ['anond.k@company.local'],
            'description' => ['1100223344556'],
        ];

        // Ensure user does not exist in DB yet
        $this->assertDatabaseMissing('users', ['username' => 'anond.k']);

        // Sync and login
        $user = $service->syncAndLoginUser($ldapUserAttributes, 'anond.k', 'ad-secure-pwd', false);

        // Verify inserted into users table
        $this->assertDatabaseHas('users', [
            'username' => 'anond.k',
            'name' => 'อนันต์ กิจเจริญ (Anond K.)',
            'email' => 'anond.k@company.local',
            'citizen_id' => '1100223344556',
            'created_by' => 'anond.k',
            'updated_by' => 'anond.k',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_ad_login_updates_and_passes_when_user_exists_in_users_table(): void
    {
        $service = app(\App\Services\Auth\LdapAuthService::class);

        // Pre-create user in database
        $existingUser = User::factory()->create([
            'username' => 'somkiat.m',
            'name' => 'Old Name',
            'email' => 'somkiat.m@company.local',
        ]);

        $ldapUserAttributes = [
            'samaccountname' => ['somkiat.m'],
            'displayname' => ['สมเกียรติ มั่นคง (Somkiat M.)'],
            'mail' => ['somkiat.m@company.local'],
            'description' => ['3100554433221'],
        ];

        // Sync and login
        $user = $service->syncAndLoginUser($ldapUserAttributes, 'somkiat.m', 'new-ad-pwd', false);

        // Verify user was updated and not duplicated
        $this->assertEquals($existingUser->user_id, $user->user_id);
        $this->assertEquals('สมเกียรติ มั่นคง (Somkiat M.)', $user->fresh()->name);
        $this->assertEquals('3100554433221', $user->fresh()->citizen_id);
        $this->assertDatabaseCount('users', 1);

        $this->assertAuthenticatedAs($user);
    }

    public function test_buu_ldap_response_syncs_and_creates_user(): void
    {
        $service = app(\App\Services\Auth\LdapAuthService::class);

        $buuLdapResponse = [
            'username' => 'pantakarn',
            'EMAIL'    => 'pantakarn@buu.ac.th',
            'IDCARD'   => '1200334455667',
            'NAMETH'   => 'พันธการต์ สมมุติ',
            'NAMEEN'   => 'Pantakarn Sommut',
        ];

        // Ensure user does not exist in DB yet
        $this->assertDatabaseMissing('users', ['username' => 'pantakarn']);

        // Sync and login
        $user = $service->syncAndLoginLdapResponse($buuLdapResponse, 'mypassword', false);

        // Verify inserted into users table
        $this->assertDatabaseHas('users', [
            'username' => 'pantakarn',
            'name' => 'พันธการต์ สมมุติ',
            'email' => 'pantakarn@buu.ac.th',
            'citizen_id' => '1200334455667',
            'created_by' => 'pantakarn',
            'updated_by' => 'pantakarn',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_check_ldap_returns_empty_when_disabled(): void
    {
        config(['constants.configLdap.AD_ENABLED' => false, 'ldap.enabled' => false]);
        $service = app(\App\Services\Auth\LdapAuthService::class);

        $result = $service->checkLdap('pantakarn', 'password');
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_check_ldap_returns_empty_when_ldap_config_enabled_is_false(): void
    {
        config(['ldap.enabled' => false, 'constants.configLdap.AD_ENABLED' => false]);
        $service = app(\App\Services\Auth\LdapAuthService::class);

        $result = $service->checkLdap('somchai', 'secret');
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_login_screen_renders_with_empty_inputs_on_first_visit(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        // Ensure hardcoded developer email and password are NOT prefilled in the inputs
        $response->assertDontSee('value="lead.architect@artisan.io"', false);
        $response->assertDontSee('value="SuperSecretPassword123!"', false);
    }

    public function test_remember_me_30_days_sets_token_and_cookie(): void
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'password123',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('generator.step1'));

        // Check user has remember token set in database
        $this->assertNotNull($user->fresh()->remember_token);

        // Check remembered_username cookie is queued for 30 days (43200 minutes)
        $response->assertCookie('remembered_username', 'testuser');
    }

    public function test_login_screen_prefills_username_when_remember_cookie_is_present(): void
    {
        $response = $this->withCookie('remembered_username', 'saved.user@buu.ac.th')
                         ->get('/login');

        $response->assertStatus(200);
        $response->assertSee('value="saved.user@buu.ac.th"', false);
        // Password must always be empty
        $response->assertSee('value=""', false);
    }

    public function test_successful_login_writes_to_log_login_table(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.log',
            'name' => 'สมชาย มั่นใจ',
            'citizen_id' => '1100223344556',
            'password' => Hash::make('pass-1234'),
        ]);

        $response = $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36'])
                         ->post('/login', [
                             'username' => 'somchai.log',
                             'password' => 'pass-1234',
                         ]);

        $this->assertAuthenticatedAs($user);

        // Verify log_login row
        $this->assertDatabaseHas('log_login', [
            'fac_id' => null,
            'dep_id' => null,
            'username' => 'somchai.log',
            'user_id' => $user->user_id,
            'lg_user_name' => 'สมชาย มั่นใจ',
            'psn_id' => (string) $user->user_id,
            'lg_browser' => 'Google Chrome',
            'lg_os' => 'Windows',
            'lg_device' => 'Desktop',
            'lg_authority' => 'User',
            'created_by' => 'somchai.log',
            'updated_by' => 'somchai.log',
        ]);
    }

    public function test_failed_login_writes_to_log_login_table(): void
    {
        $response = $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15'])
                         ->post('/login', [
                             'username' => 'bad.actor',
                             'password' => 'wrong-pass',
                         ]);

        $this->assertGuest();

        // Verify log_login row recorded failed attempt
        $this->assertDatabaseHas('log_login', [
            'username' => 'bad.actor',
            'lg_device' => 'Mobile',
            'lg_os' => 'iOS',
            'lg_action' => LoginController::LOGIN_FAILED_MESSAGE,
        ]);
    }

    public function test_authenticated_users_can_logout(): void
    {
        $user = User::factory()->create([
            'username' => 'logged.user',
            'name' => 'ผู้ใช้ที่ออกจากระบบ',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)
                         ->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        // Verify log_login row recorded logout event
        $this->assertDatabaseHas('log_login', [
            'username' => 'logged.user',
            'user_id' => $user->user_id,
            'psn_id' => (string) $user->user_id,
            'lg_user_name' => 'ผู้ใช้ที่ออกจากระบบ',
            'lg_action' => 'ออกจากระบบสำเร็จ (Logout)',
        ]);
    }

    public function test_deactivated_user_cannot_login_and_ad_does_not_insert_or_overwrite(): void
    {
        // 1. User exists in users table with active = 'N' (Deactivated)
        $deactivatedUser = User::factory()->create([
            'username' => 'deactivated.emp',
            'email' => 'deactivated.emp@buu.ac.th',
            'active' => 'N',
            'password' => Hash::make('secret123'),
        ]);

        $service = app(\App\Services\Auth\LdapAuthService::class);

        // 2. Local login attempt should fail
        $loginRes = $this->post('/login', [
            'username' => 'deactivated.emp',
            'password' => 'secret123',
        ]);
        $this->assertGuest();
        $loginRes->assertSessionHas('error', LoginController::LOGIN_FAILED_MESSAGE);

        // 3. AD sync attempt for deactivated account should be rejected (returns null and does not login)
        $ldapInfo = [
            'username' => 'deactivated.emp',
            'NAMETH' => 'พนักงานที่ถูกปิดบัญชี',
            'EMAIL' => 'deactivated.emp@buu.ac.th',
            'IDCARD' => '1234567890123',
        ];

        $syncUser = $service->syncAndLoginLdapResponse($ldapInfo, 'ad-password', false);

        $this->assertNull($syncUser);
        $this->assertGuest();

        // 4. Verify users table did not insert duplicate or overwrite active back to Y
        $deactivatedUser->refresh();
        $this->assertEquals('N', $deactivatedUser->active);
        $this->assertEquals(1, User::where('username', 'deactivated.emp')->count());
    }
}
