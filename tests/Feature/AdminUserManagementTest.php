<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdminUser(array $overrides = []): User
    {
        $username = $overrides['username'] ?? 'system.admin';
        return User::factory()->create(array_merge([
            'username' => $username,
            'name' => 'System Admin',
            'email' => $username . '@buu.ac.th',
            'role' => 'admin',
            'active' => 'Y',
        ], $overrides));
    }

    protected function createDevUser(array $overrides = []): User
    {
        $username = $overrides['username'] ?? 'somchai.dev';
        return User::factory()->create(array_merge([
            'username' => $username,
            'name' => 'Somchai Developer',
            'email' => $username . '@buu.ac.th',
            'role' => 'developer',
            'active' => 'Y',
        ], $overrides));
    }

    public function test_guest_is_redirected_to_login_when_accessing_users(): void
    {
        $response = $this->get('/admin/users');

        $response->assertRedirect('/login');
    }

    public function test_developer_gets_403_forbidden_on_users(): void
    {
        $dev = $this->createDevUser();

        $response = $this->actingAs($dev)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_users_dashboard_and_see_metrics(): void
    {
        $admin = $this->createAdminUser();
        $this->createDevUser(['username' => 'dev1']);
        $this->createDevUser(['username' => 'dev2', 'active' => 'N']);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('User Management &amp; Role Permissions', false);
        $response->assertSee('Total Users');
        $response->assertSee('Administrators');
        $response->assertSee('Developers');
        $response->assertSee('Deactivated');
        $response->assertSee('dev1');
        $response->assertSee('dev2');
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }

    public function test_admin_can_update_user_role_and_status(): void
    {
        $admin = $this->createAdminUser();
        $dev = $this->createDevUser(['username' => 'promoted.dev', 'role' => 'developer']);

        $response = $this->actingAs($admin)->putJson("/admin/users/{$dev->user_id}", [
            'role'   => 'admin',
            'active' => 'Y',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $dev->user_id,
            'role'    => 'admin',
            'active'  => 'Y',
        ]);
    }

    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = $this->createAdminUser(['username' => 'main.admin']);

        $response = $this->actingAs($admin)->putJson("/admin/users/{$admin->user_id}", [
            'role'   => 'developer',
            'active' => 'Y',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'คุณไม่สามารถลดระดับสิทธิ์ของบัญชีตนเองได้',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $admin->user_id,
            'role'    => 'admin',
        ]);
    }

    public function test_admin_cannot_deactivate_themselves(): void
    {
        $admin = $this->createAdminUser(['username' => 'main.admin']);

        $response = $this->actingAs($admin)->putJson("/admin/users/{$admin->user_id}", [
            'role'   => 'admin',
            'active' => 'N',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'คุณไม่สามารถปิดบัญชีการใช้งานของตนเองได้',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $admin->user_id,
            'active'  => 'Y',
        ]);
    }

    public function test_admin_can_toggle_user_active_and_purge_sessions(): void
    {
        $admin = $this->createAdminUser();
        $dev = $this->createDevUser(['username' => 'toggle.dev', 'active' => 'Y']);

        // Insert fake session for this user
        DB::table('sessions')->insert([
            'sess_id'       => 'test-session-token-123',
            'user_id'       => $dev->user_id,
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'Pest Browser',
            'payload'       => base64_encode('dummy-session-data'),
            'last_activity' => time(),
        ]);

        $this->assertDatabaseHas('sessions', ['user_id' => $dev->user_id]);

        // Toggle to inactive (N)
        $response = $this->actingAs($admin)->patchJson("/admin/users/{$dev->user_id}/toggle-active");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'active'  => 'N',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $dev->user_id,
            'active'  => 'N',
        ]);

        // Verify session was purged
        $this->assertDatabaseMissing('sessions', ['user_id' => $dev->user_id]);

        // Toggle back to active (Y)
        $response2 = $this->actingAs($admin)->patchJson("/admin/users/{$dev->user_id}/toggle-active");
        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'active'  => 'Y',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $dev->user_id,
            'active'  => 'Y',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = $this->createAdminUser();
        $dev = $this->createDevUser(['username' => 'tobedeleted.dev']);

        $response = $this->actingAs($admin)->deleteJson("/admin/users/{$dev->user_id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('users', [
            'user_id' => $dev->user_id,
        ]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->deleteJson("/admin/users/{$admin->user_id}");

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'คุณไม่สามารถลบบัญชีของตนเองออกจากระบบได้',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $admin->user_id,
        ]);
    }

    public function test_admin_can_filter_users_by_search_role_and_status(): void
    {
        $admin = $this->createAdminUser();
        $dev1 = $this->createDevUser(['username' => 'searchable.target', 'name' => 'Target Person']);
        $dev2 = $this->createDevUser(['username' => 'other.person', 'name' => 'Other Dev']);

        $response = $this->actingAs($admin)->get('/admin/users?search=Target&role=developer&status=Y');

        $response->assertStatus(200);
        $response->assertSee('searchable.target');
        $response->assertDontSee('other.person');
    }
}
