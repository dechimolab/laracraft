@if(!empty($isPreviewMode))
<div id="artisanCraftPreviewBar" class="w-100 bg-dark text-white py-1 px-3 d-flex align-items-center justify-content-between border-bottom shadow-sm" style="font-family: 'Inter', system-ui, sans-serif; font-size: 0.8125rem; z-index: 99999; position: sticky; top: 0;">
    <div class="d-flex align-items-center gap-2">
        <span class="badge px-2 py-1 text-uppercase fw-bold" style="background-color: {{ $supportedThemes[$theme]['color'] ?? '#047857' }}; letter-spacing: 0.05em;">
            Live Preview
        </span>
        <span class="fw-semibold text-white d-none d-sm-inline">{{ $supportedThemes[$theme]['name'] ?? 'Theme' }}</span>
        <span class="text-white-50 small d-none d-md-inline">({{ $supportedThemes[$theme]['badge'] ?? '' }})</span>
    </div>

    <!-- Page Switcher -->
    <div class="d-flex align-items-center gap-1 bg-black bg-opacity-25 p-1 rounded">
        <span class="text-white-50 small px-1 d-none d-lg-inline">Page:</span>
        <a href="{{ route('theme.preview', ['theme' => $theme, 'page' => 'demo']) }}" class="btn btn-sm py-0 px-2 {{ $page === 'demo' ? 'btn-light fw-bold text-dark' : 'text-white-50 text-decoration-none' }}">
            Demo Hub
        </a>
        <a href="{{ route('theme.preview', ['theme' => $theme, 'page' => 'login']) }}" class="btn btn-sm py-0 px-2 {{ $page === 'login' ? 'btn-light fw-bold text-dark' : 'text-white-50 text-decoration-none' }}">
            Login Portal
        </a>
    </div>

    <!-- Theme Switcher & Actions -->
    <div class="d-flex align-items-center gap-2">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-sm btn-outline-light dropdown-toggle py-0 px-2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-palette me-1"></i>Switch Theme
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 0.8125rem;">
                <li><h6 class="dropdown-header">Available Themes</h6></li>
                @foreach($supportedThemes as $key => $meta)
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 {{ $theme === $key ? 'active fw-bold' : '' }}" 
                       href="{{ route('theme.preview', ['theme' => $key, 'page' => $page]) }}"
                       @if($theme === $key) style="background-color: {{ $meta['color'] }}; color: #ffffff;" @endif>
                        <span class="rounded-circle d-inline-block border border-white" style="width: 10px; height: 10px; background-color: {{ $meta['color'] }};"></span>
                        <span>{{ $meta['name'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn btn-sm btn-link text-white-50 p-0 text-decoration-none" onclick="document.getElementById('artisanCraftPreviewBar').remove()" title="Close Toolbar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>
@endif
