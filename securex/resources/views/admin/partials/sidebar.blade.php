<div class="main-sidebar" style="background-color: #ffffff">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}">
                <img class="logo-light logo-img" src="{{ asset('assets/img/'.setting()->get('app_logo_white')) }}" alt="logo">
            </a>
        </div>
        @include('admin.partials._maintenance_notice')
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}"><img width="60px" src="{{ asset('assets/img/'.setting()->get('app_favicon')) }}" alt="icon"></i></a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item mt-3">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-hand-point-left"></i><span><b>{{ __('nav.admin.go_back') }}</b></span></a>
            </li>
            <hr class="my-3">
            @if(auth()->user()->isAdmin())
            <li class="menu-header">{{ __('nav.administration') }}</li>
            <li class="nav-item {{ (request()->routeIs('admin.dashboard.index')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.index') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i><span><b>{{ __('nav.dashboard') }}</b></span></a>
            </li>
            <li class="nav-item {{ (request()->routeIs('admin.pages.*')) ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-file-alt"></i> <span><b>{{ __('nav.admin.pages') }}</b></span></a>
            </li>
            <li class="menu-header">{{ __('nav.admin.user_mgmt') }}</li>
            <li class="nav-item {{ (request()->routeIs('admin.users.*')) ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> <span><b>{{ __('nav.admin.all_users') }}</b></span></a>
            </li>
            <li class="menu-header">{{ __('nav.admin.manage') }}</li>
            <li class="nav-item {{ (request()->routeIs('admin.settings.*')) ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cogs"></i> <span><b>{{ __('nav.admin.settings') }}</b></span></a>
            </li>
            <li class="nav-item {{ (request()->routeIs('admin.modules.*')) ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.modules.index') }}">
                    <i class="far fa-window-restore"></i> <span><b>{{ __('nav.admin.modules') }}</b></span></a>
            </li>
            <hr>
            @endif
        </ul>
    </aside>
</div>
