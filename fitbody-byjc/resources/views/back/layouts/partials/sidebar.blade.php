<!-- Sidebar -->
<!--
    Helper classes

    Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

    Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
    Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
        - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
-->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">F</span><span class="text-primary">B</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="{{ route('dashboard') }}">
                        <i class="si si-pointer text-dual-primary-dark"></i>
                        <span class="font-size-xl text-primary">{{ substr($appinfo->admin_name, 0, strpos($appinfo->admin_name, ' ')) }}</span><span class="font-size-xl text-dual-primary-dark">{{ substr($appinfo->admin_name, strpos($appinfo->admin_name, ' ') + 1) }}</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32" src="{{ isset(auth()->user()->details->avatar) ? asset(auth()->user()->details->avatar) : '' }}" alt="">
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="javascript:void(0)">
                    <img class="img-avatar" src="{{ isset(auth()->user()->details->avatar) ? asset(auth()->user()->details->avatar) : '' }}" alt="">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="javascript:void(0)">{{ auth()->user()->name }}</a>
                    </li>
                    <li class="list-inline-item">
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)" id="sidebar-inverse-toggle">
                            <i class="si si-drop"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="si si-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a class="{{ request()->is('admin/dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="si si-grid"></i><span class="sidebar-mini-hide">Nadzorna ploča</span>
                    </a>
                </li>
                <li>
                    <a class="{{ (request()->is('admin/categories') or request()->is('admin/category/*')) ? 'active' : '' }}" href="{{ route('categories') }}">
                        <i class="si si-layers"></i><span class="sidebar-mini-hide">Kategorije</span>
                    </a>
                </li>
                <li>
                    <a class="{{ (request()->is('admin/settings/pages') or request()->is('admin/settings/page/*')) ? ' active' : '' }}" href="{{ route('pages') }}">
                        <i class="si si-layers"></i><span class="sidebar-mini-hide">Stranice</span>
                    </a>
                </li>

                <li class="{{ (request()->is('admin/marketing') or request()->is('admin/marketing/*')) ? 'open' : '' }}">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-diamond"></i><span class="sidebar-mini-hide">Marketing</span></a>
                    <ul>
                        <li>
                            <a class="{{ (request()->is('admin/marketing/sliders') or request()->is('admin/marketing/slider/*')) ? ' active' : '' }}" href="{{ route('sliders') }}">Slideri</a>
                        </li>
                        <li>
                            <a class="{{ (request()->is('admin/marketing/prices') or request()->is('admin/marketing/price/*')) ? ' active' : '' }}" href="{{ route('prices') }}">Cjenik</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ (request()->is('admin/users') or request()->is('admin/users/*')) ? 'open' : '' }}">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-users"></i><span class="sidebar-mini-hide">Korisnici</span></a>
                    <ul>
                        <li>
                            <a class="{{ (request()->is('admin/users/users') or request()->is('admin/users/user/*')) ? ' active' : '' }}" href="{{ route('users') }}">Korisnici</a>
                        </li>
                        <li>
                            <a class="{{ (request()->is('admin/users/messages') or request()->is('admin/users/message/*')) ? ' active' : '' }}" href="{{ route('messages') }}">Poruke</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-heading">
                    <span class="sidebar-mini-visible">AS</span><span class="sidebar-mini-hidden">Postavke Aplikacije</span>
                </li>

                <li class="{{ (request()->is('admin/design') or request()->is('admin/design/*')) ? 'open' : '' }}">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Dizajn</span></a>
                    <ul>
                        <li>
                            <a class="{{ (request()->is('admin/design/theme') or request()->is('admin/design/theme/*')) ? ' active' : '' }}" href="{{ route('theme') }}">Tema</a>
                        </li>
                        <li>
                            <a class="{{ (request()->is('admin/design/widgets') or request()->is('admin/design/widgets/*')) ? ' active' : '' }}" href="{{ route('widgets') }}">Widgets</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ (request()->is('admin/settings') or request()->is('admin/settings/*')) ? 'open' : '' }}">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Postavke</span></a>
                    <ul>
                        <li>
                            <a class="{{ (request()->is('admin/settings/profile') or request()->is('admin/settings/profile/*')) ? ' active' : '' }}" href="{{ route('profile') }}">Moj Profil</a>
                        </li>
                        <li class="{{ request()->is('admin/settings/application/*') ? 'open' : '' }}">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><span class="sidebar-mini-hide">Aplikacija</span></a>
                            <ul>
                                <li class="{{ request()->is('admin/settings/application/theme') ? 'open' : '' }}">
                                    <a class="{{ request()->is('admin/settings/application/theme') ? ' active' : '' }}" href="{{ route('theme') }}"><span class="sidebar-mini-hide">Tema</span></a>
                                </li>
                                <li class="{{ request()->is('admin/settings/application/info') ? 'open' : '' }}">
                                    <a class="{{ request()->is('admin/settings/application/info') ? ' active' : '' }}" href="{{ route('info') }}"><span class="sidebar-mini-hide">Info Podaci</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->
