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
        $loginResponse->assertDontSee('#3B82F6');
        $loginResponse->assertDontSee('#2563EB');
        $loginResponse->assertDontSee('#1D4ED8');
        $loginResponse->assertDontSee('#DBEAFE');
        $loginResponse->assertSee('#0F172A');

        $demoResponse = $this->get('/preview-theme/nordic-clean/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Nordic Clean');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-nordic.svg');
        $demoResponse->assertSee('image/favicon-nordic.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('background-color: #0F172A; color: #ffffff;', false);
        $demoResponse->assertSee('fill="rgba(15, 23, 42, 0.06)"', false);
        $demoResponse->assertSee('stroke="#0F172A"', false);
    }

    /**
     * Test Sunset Horizon preview routes.
     */
    public function test_sunset_horizon_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/sunset-horizon/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('SUNSET HORIZON');
        $loginResponse->assertDontSee('Artisan Artisan');

        $demoResponse = $this->get('/preview-theme/sunset-horizon/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Sunset Horizon');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-sunset.svg');
        $demoResponse->assertSee('image/favicon-sunset.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('background-color: #EA580C; color: #ffffff;', false);
    }

    /**
     * Test Rose Quartz & Velvet preview routes.
     */
    public function test_rose_quartz_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/rose-quartz/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('ROSE QUARTZ & VELVET');
        $loginResponse->assertDontSee('Artisan Artisan');

        $demoResponse = $this->get('/preview-theme/rose-quartz/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Rose Quartz & Velvet');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-rose-quartz.svg');
        $demoResponse->assertSee('image/favicon-rose-quartz.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('background-color: #BE123C !important;', false);

        // Alias check
        $aliasResponse = $this->get('/preview-theme/rose-quartz-velvet/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Rose Quartz & Velvet');
    }

    /**
     * Test Forest Moss & Sage preview routes.
     */
    public function test_forest_moss_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/forest-moss/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('FOREST MOSS & SAGE');
        $loginResponse->assertDontSee('Artisan Artisan');

        $demoResponse = $this->get('/preview-theme/forest-moss/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Forest Moss & Sage');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-forest-moss.svg');
        $demoResponse->assertSee('image/favicon-forest-moss.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('background-color: #15803D !important;', false);

        // Alias check
        $aliasResponse = $this->get('/preview-theme/forest-moss-sage/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Forest Moss & Sage');
    }

    /**
     * Test Solar Amber & Coffee preview routes.
     */
    public function test_solar_amber_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/solar-amber/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('SOLAR AMBER & COFFEE');
        $loginResponse->assertDontSee('Artisan Artisan');

        $demoResponse = $this->get('/preview-theme/solar-amber/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Solar Amber & Coffee');
        $demoResponse->assertDontSee('Artisan Artisan');
        $demoResponse->assertSee('image/favicon-solar-amber.svg');
        $demoResponse->assertSee('image/favicon-solar-amber.ico');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('#D97706');

        // Alias check
        $aliasResponse = $this->get('/preview-theme/solar-amber-coffee/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Solar Amber & Coffee');
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
