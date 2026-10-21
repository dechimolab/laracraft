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
            'color' => '#0284c7',
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

        $viewName = $page === 'login'
            ? "themes.{$theme}.auth.login"
            : "themes.{$theme}.demo.index";

        if (!View::exists($viewName)) {
            abort(404, "Theme preview view [{$viewName}] not found.");
        }

        return response()->view($viewName, [
            'theme' => $theme,
            'page' => $page,
            'supportedThemes' => $this->supportedThemes,
            'isPreviewMode' => true,
        ]);
    }
}
