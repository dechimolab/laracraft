<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_screen_renders_successfully(): void
    {
        $user = \App\Models\User::factory()->create([
            'username' => 'testdeveloper',
            'name' => 'Test Developer',
            'email' => 'dev@example.buu.ac.th',
            'active' => 'Y',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('PROFILE CONFIG');
        $response->assertSee('ข้อมูลบัญชีนักพัฒนา (Account Details)', false);
        $response->assertSee('สแกนลายนิ้วมือ &amp; Passkey', false);
        $response->assertSee('โซนอันตราย (Danger Zone)', false);
        $response->assertSee('---เลือก---');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_profile_security_tab_renders_password_status_and_login_audit_trail(): void
    {
        $user = \App\Models\User::factory()->create([
            'username' => 'somchai.sec',
            'name' => 'Somchai Security',
            'email' => 'somchai.sec@buu.ac.th',
            'active' => 'Y',
        ]);

        \App\Models\LogLogin::create([
            'username' => 'somchai.sec',
            'user_id' => $user->user_id,
            'lg_date' => now(),
            'lg_ip' => '10.20.30.40',
            'lg_action' => 'เข้าสู่ระบบสำเร็จ (Active Directory)',
            'lg_browser' => 'Chrome 124',
            'lg_os' => 'Windows 11',
            'created_by' => 'somchai.sec',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('รหัสผ่านและความปลอดภัย');
        $response->assertSee('การจัดการรหัสผ่าน (Password Management)', false);
        $response->assertSee('BUU AD CENTRAL AUTH');
        $response->assertSee('เปลี่ยนรหัสผ่านผ่าน BUU Portal');
        $response->assertSee('เซสชันที่ใช้งานอยู่ (Active Sessions)', false);
        $response->assertSee('ประวัติการเข้าสู่ระบบล่าสุด (Login Audit Trail)', false);
        $response->assertSee('10.20.30.40');
        $response->assertSee('เข้าสู่ระบบสำเร็จ (Active Directory)');
    }
}
