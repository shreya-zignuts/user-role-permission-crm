{{-- @php
// Decode the JSON data
$menuData = json_decode($menuJson);
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- Sidebar content -->
    <ul class="menu-inner py-1">
        @foreach ($menuData->menu as $menu)
            <li class="menu-item">
                <a href="{{ route('users-modules') }}" class="menu-link">
                    <i class="{{ $menu->icon }}"></i>
                    <div>{{ $menu->name }}</div>
                </a>
            </li>
        @endforeach
    </ul>
</aside> --}}
