<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_or_update_profile(): void
    {
        $getRes = $this->get(route('profile'));
        $getRes->assertRedirect(route('login'));

        $postRes = $this->postJson(route('profile.update'), [
            'name' => 'Hacker Try',
            'email' => 'hacker@buu.ac.th',
        ]);
        $postRes->assertStatus(403);
    }

    public function test_authenticated_user_can_view_profile_with_real_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'อาจารย์สมชาย ชัยชนะ',
            'username' => 'somchai.chai',
            'email' => 'somchai@buu.ac.th',
            'timezone' => 'Asia/Bangkok',
            'git_signature' => 'Somchai <somchai@buu.ac.th>',
            'preferences' => [
                'pint_format' => true,
                'pest_test' => true,
                'docker_compose' => false,
            ],
        ]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200)
            ->assertSee('อาจารย์สมชาย ชัยชนะ')
            ->assertSee('somchai.chai')
            ->assertSee('somchai@buu.ac.th');
    }

    public function test_authenticated_user_can_update_profile_and_preferences_successfully(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'username' => 'orig.user',
            'email' => 'orig@buu.ac.th',
        ]);

        $payload = [
            'name' => 'สมศักดิ์ ภักดี',
            'email' => 'somsak.p@buu.ac.th',
            'timezone' => 'Asia/Tokyo',
            'git_signature' => 'Somsak <somsak.p@buu.ac.th>',
            'pint_format' => 1,
            'pest_test' => 0,
            'docker_compose' => 1,
        ];

        $response = $this->actingAs($user)->postJson(route('profile.update'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'บันทึกข้อมูลส่วนตัวและการตั้งค่าโปรไฟล์เรียบร้อยแล้ว',
                'user' => [
                    'name' => 'สมศักดิ์ ภักดี',
                    'email' => 'somsak.p@buu.ac.th',
                    'timezone' => 'Asia/Tokyo',
                    'git_signature' => 'Somsak <somsak.p@buu.ac.th>',
                    'preferences' => [
                        'pint_format' => true,
                        'pest_test' => false,
                        'docker_compose' => true,
                    ],
                ],
            ]);

        $user->refresh();
        $this->assertEquals('สมศักดิ์ ภักดี', $user->name);
        $this->assertEquals('somsak.p@buu.ac.th', $user->email);
        $this->assertEquals('Asia/Tokyo', $user->timezone);
        $this->assertEquals('Somsak <somsak.p@buu.ac.th>', $user->git_signature);
        $this->assertTrue($user->preferences['pint_format']);
        $this->assertFalse($user->preferences['pest_test']);
        $this->assertTrue($user->preferences['docker_compose']);
    }

    public function test_profile_update_validation_fails_when_email_belongs_to_another_user(): void
    {
        $otherUser = User::factory()->create([
            'email' => 'existing@buu.ac.th',
        ]);

        $currentUser = User::factory()->create([
            'email' => 'current@buu.ac.th',
        ]);

        $response = $this->actingAs($currentUser)->postJson(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'existing@buu.ac.th', // Duplicate!
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_deactivate_own_account(): void
    {
        $user = User::factory()->create([
            'username' => 'self.deactivator',
            'active' => 'Y',
        ]);

        $response = $this->actingAs($user)->postJson(route('profile.deactivate'));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'redirect' => route('login'),
            ]);

        $this->assertGuest();

        $user->refresh();
        $this->assertEquals('N', $user->active);

        // Verify recorded into log_login
        $this->assertDatabaseHas('log_login', [
            'username' => 'self.deactivator',
            'user_id' => $user->user_id,
            'lg_action' => 'ปิดบัญชีและระงับการใช้งานตนเอง (Account Deactivated)',
        ]);
    }
}
