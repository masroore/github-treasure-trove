@php
$users = \Auth::user();
$currantLang = $users->currentLanguage();
$languages = Utility::languages();
// $profile = asset(Storage::url('uploads/avatar/'));
@endphp
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- <a href="index.html">Stisla</a> --}}
            <img src="{{ Storage::url('logo/app-logo.png') }}" class="app-logo w-50">

        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{ Storage::url('logo/app-small-logo.png') }}" class="app-logo w-50">

            {{-- <a href="index.html">St</a> --}}

            <img src="" class="app-logo w-50">

        </div>
        <ul class="sidebar-menu">

            <li>
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            @can('manage-user')
                <li>
                    <a class="nav-link" href="{{ route('users.index') }}"><i class="far fa-user"></i>
                        <span>Users</span></a>
                </li>
            @endcan

            @can('manage-role')
                <li>
                    <a class="nav-link" href="{{ route('roles.index') }}"><i class="far fa-user"></i>
                        <span>Roles</span></a>
                </li>
            @endcan

            @can('manage-module')
                <li>
                    <a class="nav-link" href="{{ route('modules.index') }}"><i class="fas fa-plug"></i>
                        <span>Modules</span></a>
                </li>
            @endcan
            @can('manage-setting')
                <li>
                    <a class="nav-link" href="{{ route('settings') }}"><i class="fas fa-pencil-ruler   "></i>
                        <span>Settings</span></a>
                </li>
            @endcan

            @can('manage-langauge')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('manage.language', [$currantLang]) }}">
                        <i class="fas fa-globe text-primary"></i>
                        <span class="nav-link-text">{{ __('Manage Language') }}</span>
                    </a>
                </li>
            @endcan
        </ul>


    </aside>
</div>
