@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    @include('_partials.macros', ['height' => 20])
                </span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData['verticalMenuData']->menu as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();

                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        } else {
                            if (
                                str_contains($currentRouteName, $menu->slug) and
                                strpos($currentRouteName, $menu->slug) === 0
                            ) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                {{-- main menu --}}
                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        @isset($menu->badge)
                            <div class="badge bg-label-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}
                            </div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif

            {{-- displaying modules at user side --}}
            @if (!isset($navbarFull) && $menu->url === '/userside')
                <ul class="menu-item list-unstyled">
                    @foreach ($user->modules as $module)
                        @php
                            $hasSubmodulesWithView = false;
                            if (count($module->submodules) > 0) {
                                foreach ($module->submodules as $submenu) {
                                    foreach ($submenu->permissions as $permission) {
                                        if ($permission->pivot->view_access) {
                                            $hasSubmodulesWithView = true;
                                            break 2; // Break both foreach loops
                                        }
                                    }
                                }
                            }
                        @endphp

                        @if ($hasSubmodulesWithView)
                            @if (!isset($module['parent_code']))
                                <li class="menu-item">
                                    <div class="row align-items-center">
                                        <div class="col-10">
                                            <a href="{{ isset($module->url) ? url($module->url) : 'javascript:void(0);' }}"
                                                class="menu-link toggle-menu">
                                                @isset($module->icon)
                                                    <i class="{{ $module->icon }}"></i>
                                                @endisset
                                                <span>{{ isset($module->name) ? __($module->name) : '' }}</span>
                                            </a>
                                        </div>
                                        <div class="col-2 text-right">
                                            <span class="toggle-btn">&#9660;</span>
                                            <!-- Down arrow Unicode character -->
                                        </div>
                                    </div>
                                    @if (count($module->submodules) > 0)
                                        <ul class="submenu" style="display: none;">
                                            @foreach ($module->submodules as $submenu)
                                                @php
                                                    $hasViewAccess = false;
                                                    foreach ($submenu->permissions as $permission) {
                                                        if ($permission->pivot->view_access) {
                                                            $hasViewAccess = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                @if ($hasViewAccess)
                                                    @if (in_array($submenu->code, $user->modules->pluck('code')->toArray()) && $submenu->parent_code === $module->code)
                                                        <li class="menu-item">
                                                            <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                                                                class="menu-link submenu-link pl-3">
                                                                <img src="https://cdn-icons-png.flaticon.com/128/8265/8265301.png"
                                                                    width="19px" alt="">
                                                                <span
                                                                    class="active">{{ isset($submenu->name) ? __($submenu->name) : '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.toggle-menu, .toggle-btn').click(function(e) {
                            e.preventDefault();
                            var $parentItem = $(this).closest('.menu-item');
                            var $submenu = $parentItem.find('.submenu');
                            var $toggleBtn = $parentItem.find('.toggle-btn');

                            if (!$submenu.is(':visible')) {
                                $('.submenu').slideUp();
                                $('.toggle-btn').html('&#9660;');
                                $toggleBtn.html('&#9650;');
                                $submenu.slideToggle();
                            } else {
                                $toggleBtn.html('&#9660;');
                                $submenu.slideUp();
                            }
                        });

                        $('.submenu-link').click(function(e) {
                            e.stopPropagation(); // Prevent parent toggle event
                            return true; // Allow default link behavior
                        });
                    });
                </script>
            @endif

        @endforeach
    </ul>
</aside>
