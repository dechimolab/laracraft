<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorStep4Test extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_step4_without_completing_steps(): void
    {
        // 1. Without any session
        $response1 = $this->get('/generator/step4');
        $response1->assertRedirect(route('generator.step1'));
        $response1->assertSessionHas('step_warning');

        // 2. Only step 1 completed
        $response2 = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'test-app',
        ])->get('/generator/step4');
        $response2->assertRedirect(route('generator.step2'));
        $response2->assertSessionHas('step_warning');

        // 3. Step 2 completed but step 3 not completed
        $response3 = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'test-app',
        ])->get('/generator/step4');
        $response3->assertRedirect(route('generator.step3'));
        $response3->assertSessionHas('step_warning');
    }

    public function test_can_access_step4_theme_studio_when_step3_completed(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'theme-app',
            'project.name' => 'Theme Studio App',
            'project.theme_key' => 'nordic-clean',
            'project.theme_mode' => 'light',
        ])->get('/generator/step4');

        $response->assertStatus(200);
        $response->assertSee('UI Design System &amp; Theme Studio', false);
        $response->assertSee('Light Mode (10)');
        $response->assertSee('Dark Mode (10)');
        $response->assertSee('Nordic Clean');
        $response->assertSee('AAA 16.2:1');
        $response->assertSee('name="theme_key"', false);
        $response->assertSee('name="theme_mode"', false);
        $response->assertSee('System Velocity');
        $response->assertSee('px-6 md:px-8 lg:px-10', false);
        $response->assertDontSee('px-gutter-desktop', false);
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_step4_renders_all_20_curated_themes(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'theme-app',
        ])->get('/generator/step4');

        $response->assertStatus(200);

        // 10 Light themes
        $lightThemes = [
            'Nordic Clean',
            'Emerald Enterprise',
            'Sunset Horizon',
            'Rose Quartz &amp; Velvet',
            'Forest Moss &amp; Sage',
            'Solar Amber &amp; Coffee',
            'Horizon Sky',
            'Lavande Provence',
            'Swiss Monolith',
            'Sand &amp; Terracotta',
        ];
        foreach ($lightThemes as $name) {
            $response->assertSee($name, false);
        }

        // 10 Dark themes
        $darkThemes = [
            'Midnight Cyberpunk',
            'Deep Oceanic',
            'Monolith Obsidian',
            'Royal Amethyst',
            'Emerald Matrix',
            'Crimson Voltage',
            'Nord Twilight',
            'Solar Eclipse',
            'Vapor Synthwave',
            'Slate Executive',
        ];
        foreach ($darkThemes as $name) {
            $response->assertSee($name, false);
        }
    }

    public function test_user_can_save_step4_theme_and_advance_to_step5(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'theme-app',
            'project.name' => 'Theme Studio App',
        ])->post('/generator/step4', [
            'theme_key' => 'emerald-matrix',
            'theme_mode' => 'dark',
        ]);

        $response->assertRedirect(route('generator.step5'));
        $response->assertSessionHas('project.theme_key', 'emerald-matrix');
        $response->assertSessionHas('project.theme_mode', 'dark');
        $this->assertGreaterThanOrEqual(4, session('project.step_completed'));
    }

    public function test_step4_validation_rejects_invalid_theme(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'theme-app',
        ])->post('/generator/step4', [
            'theme_key' => 'invalid-theme-key-xxx',
            'theme_mode' => 'ultra-violet',
        ]);

        $response->assertSessionHasErrors(['theme_key', 'theme_mode']);
    }
}
