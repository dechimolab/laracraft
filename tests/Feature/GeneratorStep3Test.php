<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorStep3Test extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_step3_without_step1(): void
    {
        $response = $this->get('/generator/step3');

        $response->assertRedirect(route('generator.step1'));
        $response->assertSessionHas('step_warning');
    }

    public function test_cannot_access_step3_without_step2(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'demo-app',
        ])->get('/generator/step3');

        $response->assertRedirect(route('generator.step2'));
        $response->assertSessionHas('step_warning');
    }

    public function test_generator_step3_screen_renders_successfully(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'demo-app',
        ])->get('/generator/step3');

        $response->assertStatus(200);
        $response->assertSee('Pre-built Enterprise Modules', false);
        $response->assertSee('BUU LDAP &amp; Active Directory', false);
        $response->assertDontSee('User &amp; Role Management', false);
        $response->assertDontSee('modules[user_role]');
        $response->assertSee('Audit Trail &amp; Activity Log', false);
        $response->assertSee('Notification Engine');
        $response->assertDontSee('System Settings &amp; Config', false);
        $response->assertDontSee('Media &amp; Attachment Vault', false);
        $response->assertDontSee('modules[system_settings]');
        $response->assertDontSee('modules[media_storage]');
        $response->assertDontSee('นำเข้าโมดูลสำเร็จรูปเพิ่มเติม');
        $response->assertDontSee('สร้าง Schema &amp; CRUD', false);
        $response->assertDontSee('Entities (Models)');
        $response->assertSee('1 Active');
        $response->assertSee('ENABLED');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_generator_step3_reflects_saved_modules_from_session(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'demo-app',
            'project.modules' => [
                'user_role' => '1',
                'notifications' => '1',
            ],
        ])->get('/generator/step3');

        $response->assertStatus(200);
        $response->assertSee('2 Active');
        $response->assertSee('ENABLED');
    }

    public function test_user_can_save_step3_modules_and_schemas_and_redirect_to_step4(): void
    {
        $modules = [
            'user_role' => '1',
            'audit_trail' => '1',
            'system_settings' => '1',
        ];

        $artifacts = [
            'model' => '1',
            'migration' => '1',
            'controller' => '1',
        ];

        $schemasJson = json_encode([
            'tables' => [
                [
                    'name' => 'products',
                    'model' => 'Product',
                    'columns' => [
                        ['name' => 'id', 'type' => 'bigIncrements'],
                        ['name' => 'name', 'type' => 'string'],
                        ['name' => 'price', 'type' => 'decimal'],
                    ],
                ],
            ],
        ]);

        $response = $this->post('/generator/step3', [
            'modules' => $modules,
            'artifacts' => $artifacts,
            'schemas_json' => $schemasJson,
        ]);

        $response->assertRedirect(route('generator.step4'));
        $this->assertEquals($modules, session('project.modules'));
        $this->assertEquals($artifacts, session('project.artifacts'));
        $this->assertArrayHasKey('tables', session('project.schemas'));
        $this->assertEquals(3, session('project.step_completed'));
    }

    public function test_step3_locks_ums_buu_and_disables_buu_ldap_when_enabled_in_step1(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'ums-test-app',
            'project.use_ums_buu' => true,
        ])->get('/generator/step3');

        $response->assertStatus(200);
        $response->assertSee('LOCKED BY STEP 1', false);
        $response->assertSee('DISABLED (UMS ACTIVE)', false);
        $response->assertSee('name="modules[ums_buu]"', false);
        $response->assertSee('disabled', false);
        $this->assertEquals('1', session('project.modules.ums_buu'));
        $this->assertArrayNotHasKey('buu_ldap', session('project.modules', []));
    }

    public function test_step3_enforces_mutual_exclusivity_on_save_when_ums_buu_is_active_from_step1(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'ums-test-app',
            'project.use_ums_buu' => true,
        ])->post('/generator/step3', [
            'modules' => [
                'buu_ldap' => '1',
                'ums_buu' => '1',
                'audit_trail' => '1',
            ],
        ]);

        $response->assertRedirect(route('generator.step4'));
        $savedModules = session('project.modules');
        $this->assertEquals('1', $savedModules['ums_buu']);
        $this->assertArrayNotHasKey('buu_ldap', $savedModules);
        $this->assertEquals('1', $savedModules['audit_trail']);
    }

    public function test_step3_enforces_mutual_exclusivity_on_save_when_ums_selected_in_step3(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'ums-test-app',
            'project.use_ums_buu' => false,
        ])->post('/generator/step3', [
            'modules' => [
                'buu_ldap' => '1',
                'ums_buu' => '1',
            ],
        ]);

        $response->assertRedirect(route('generator.step4'));
        $savedModules = session('project.modules');
        $this->assertEquals('1', $savedModules['ums_buu']);
        $this->assertArrayNotHasKey('buu_ldap', $savedModules);
    }
}
