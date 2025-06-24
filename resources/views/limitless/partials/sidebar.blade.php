<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Main navigation -->
        @persist('sidebar-navigation')
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                            title="Main"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.berita.index') }}"
                            class="nav-link {{ request()->routeIs('admin.berita.index') ? 'active' : '' }}">
                            <i class="icon-copy"></i>
                            <span>Berita</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pengumuman.index') }}"
                            class="nav-link {{ request()->routeIs('admin.pengumuman.index') ? 'active' : '' }}">
                            <i class="icon-copy"></i>
                            <span>Pengumuman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.download.index') }}"
                            class="nav-link {{ request()->routeIs('admin.download.index') ? 'active' : '' }}">
                            <i class="icon-copy"></i>
                            <span>Download</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.program-unggulan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.program-unggulan.index') ? 'active' : '' }}">
                            <i class="icon-stack"></i> <!-- Contoh ikon limitless -->
                            <span>Program Unggulan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                            <i class="icon-stack"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.menu.index') }}"
                            class="nav-link {{ request()->routeIs('admin.menu.index') ? 'active' : '' }}">
                            <i class="icon-copy"></i>
                            <span>Menu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sliders') }}"
                            class="nav-link {{ request()->routeIs('admin.sliders') ? 'active' : '' }}">
                            <i class="icon-copy"></i>
                            <span>Sliders</span>
                        </a>
                    </li>
                    @foreach ($sidebarMenus as $menu)
                        @if ($menu->children->count())
                            <li
                                class="nav-item nav-item-submenu {{ request()->is("admin/{$menu->slug}*") ? 'nav-item-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="icon-copy"></i>
                                    <span>{{ $menu->title }}</span>
                                </a>
                                <ul class="nav nav-group-sub"
                                    style="{{ request()->is("admin/{$menu->slug}*") ? 'display: block;' : '' }}">
                                    @foreach ($menu->children as $child)
                                        <li class="nav-item">
                                            <a href="{{ route('admin.profil.halaman-dinamis', ['slug' => $child->slug]) }}"
                                                class="nav-link {{ request()->is("admin/profil/{$child->slug}") ? 'active' : '' }}">
                                                {{ $child->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                    <!-- /main -->
                </ul>
            </div>
        @endpersist
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>

{{-- @script
    <script>
        // Accordion menu
        var $sidebarNav = window.$('.sidebar-main .nav-sidebar');
        if ($sidebarNav.length > 0) {
            $sidebarNav.find('.nav-item-submenu').has('ul').on('click', function(e) {
                e.preventDefault();
                if (window.$(this).hasClass('nav-item-open')) {
                    window.$(this).removeClass('nav-item-open').children('ul').slideUp(150);
                } else {
                    window.$(this).addClass('nav-item-open').children('ul').slideDown(150);
                }
            });
        }
    </script>
@endscript --}}
