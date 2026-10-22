<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ThemePreviewController extends Controller
{
    /**
     * Supported modular themes for live preview.
     */
    protected array $supportedThemes = [
        'emerald-enterprise' => [
            'name' => 'Emerald Enterprise',
            'badge' => 'Corporate Precision',
            'color' => '#047857',
        ],
        'nordic-clean' => [
            'name' => 'Nordic Clean',
            'badge' => 'Minimalist Scandinavian',
            'color' => '#0F172A',
        ],
        'sunset-horizon' => [
            'name' => 'Sunset Horizon',
            'badge' => 'Tactile Warm Retail Precision',
            'color' => '#EA580C',
        ],
        'rose-quartz' => [
            'name' => 'Rose Quartz & Velvet',
            'badge' => 'Boutique Luxury POS & Velvet Atelier',
            'color' => '#BE123C',
        ],
        'forest-moss' => [
            'name' => 'Forest Moss & Sage',
            'badge' => 'Deep Botanical Evergreen & Sage Precision',
            'color' => '#15803D',
        ],
        'solar-amber' => [
            'name' => 'Solar Amber & Coffee',
            'badge' => 'Solar Amber & Roasted Coffee Precision',
            'color' => '#D97706',
        ],
    ];

    /**
     * Display live theme preview without needing generator session steps.
     *
     * @param string $theme
     * @param string $page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function preview(string $theme = 'emerald-enterprise', string $page = 'demo')
    {
        $theme = strtolower(trim($theme));
        $page = strtolower(trim($page));

        if ($theme === 'rose-quartz-velvet') {
            $theme = 'rose-quartz';
        }
        if ($theme === 'forest-moss-sage') {
            $theme = 'forest-moss';
        }
        if ($theme === 'solar-amber-coffee') {
            $theme = 'solar-amber';
        }

        if (!array_key_exists($theme, $this->supportedThemes)) {
            $theme = 'emerald-enterprise';
        }

        if (!in_array($page, ['demo', 'login'])) {
            $page = 'demo';
        }

        // Setup mock session data for authenticated preview rendering
        if (!session()->has('userFullNameTH')) {
            session([
                'userFullNameTH' => 'นายพันธกานต์ มั่นจันทร์ (ผู้ดูแลตำแหน่ง)',
                'userPermitName' => 'เข้าสู่ระบบ (UMS BUU)',
                'userGroup' => ['POS_MANAGER', 'UMS_ADMIN'],
            ]);
        }

        $viewTheme = ($theme === 'rose-quartz-velvet') ? 'rose-quartz' : $theme;
        $viewName = $page === 'login'
            ? "themes.{$viewTheme}.auth.login"
            : "themes.{$viewTheme}.demo.index";

        if (!View::exists($viewName)) {
            abort(404, "Theme preview view [{$viewName}] not found.");
        }

        return response()->view($viewName, [
            'theme' => $theme,
            'page' => $page,
            'appName' => 'Artisan POS & Inventory Hub',
            'supportedThemes' => $this->supportedThemes,
            'isPreviewMode' => true,
            'selectedModules' => [
                'ums_buu' => '1',
                'buu_ldap' => '1',
                'audit_trail' => '1',
                'user_role' => '1',
            ],
        ]);
    }
}
