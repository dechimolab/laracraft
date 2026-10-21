<?php

namespace Tests\Feature;

use Tests\TestCase;

class ThemePreviewControllerTest extends TestCase
{
    /**
     * Test Emerald Enterprise login portal preview route.
     */
    public function test_emerald_enterprise_login_preview_renders_successfully(): void
    {
        $response = $this->get('/preview-theme/emerald-enterprise/login');

        $response->assertStatus(200);
        $response->assertSee('btn-emerald');
        $response->assertSee('btn-outline-emerald');
        $response->assertSee('EMERALD ENTERPRISE');
        $response->assertDontSee('Artisan Artisan');
        $response->assertDontSee('กลับสู่หน้าหลักแอปพลิเคชัน');
        $response->assertSee('artisanCraftPreviewBar');
        $this->assertSame(1, substr_count($response->getContent(), 'id="artisanCraftPreviewBar"'));
    }

    /**
     * Test Emerald Enterprise demo hub preview route.
     */
    public function test_emerald_enterprise_demo_preview_renders_successfully(): void
    {
        $response = $this->get('/preview-theme/emerald-enterprise/demo');

        $response->assertStatus(200);
        $response->assertSee('EMERALD ENTERPRISE');
        $response->assertSee('text-emerald-primary');
        $response->assertDontSee('Artisan Artisan');
        $response->assertSee('image/favicon-emerald.svg');
        $response->assertSee('image/favicon-emerald.ico');
        $response->assertSee('user-executive-capsule');
        $response->assertSee('btn-capsule-logout');
        $response->assertSee('artisanCraftPreviewBar');
        $this->assertSame(1, substr_count($response->getContent(), 'id="artisanCraftPreviewBar"'));
    }

    /**
     * Test Nordic Clean preview routes.
     */
    public function test_nordic_clean_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/nordic-clean/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('NORDIC CLEAN');
        $loginResponse->assertDontSee('Artisan Artisan');
        $loginResponse->assertDontSee('กลับสู่หน้าหลักแอปพลิเคชัน');

        $demoResponse = $this->get('/preview-theme/nordic-clean/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Nordic Clean');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-nordic.svg');
        $demoResponse->assertSee('image/favicon-nordic.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
    }

    /**
     * Test ArtisanCraft master layout brand favicon.
     */
    public function test_artisancraft_master_layout_renders_brand_favicon(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('image/favicon.svg');
        $response->assertSee('image/favicon.ico');
    }

    /**
     * Test invalid theme fallback to emerald-enterprise demo.
     */
    public function test_invalid_theme_falls_back_to_emerald_enterprise(): void
    {
        $response = $this->get('/preview-theme/non-existent-theme/unknown-page');

        $response->assertStatus(200);
        $response->assertSee('EMERALD ENTERPRISE');
    }
}
