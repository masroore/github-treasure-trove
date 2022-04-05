<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}">
      <img class="logo-light logo-img" src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo">
    </a>
  </div>
  <!-- Maintenance Alert -->
  @include('layouts.partials._maintenance_notice')
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{ route('dashboard') }}"><img width="60px" src="{{ asset('assets/img/'.setting()->get('app_favicon')) }}" alt="icon"></i></a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">{{ __('nav.dashboard') }}</li>
    <li class="nav-item {{ (request()->routeIs('dashboard')) ? 'active' : '' }} {{ (request()->routeIs('dashboard.*')) ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>{{ __('nav.dashboard') }}</span></a>
    </li>
    <li class="menu-header">{{ __('nav.my_vaults') }}</li>
    <li class="nav-item {{ (request()->routeIs('vaults')) ? 'active' : '' }}"><a class="nav-link" href="{{ route('vaults') }}">
        <i class="fas fa-piggy-bank"></i> <span>{{ __('nav.all_vaults') }}</span></a>
    </li>
    @if(Auth::user()->vaults()->count() > 0)
    @endif
    @foreach(Auth::user()->vaults()->orderBy('created_at', 'asc')->get() as $vault)
    <li class="nav-item {{ (request()->is('vaults/'.$vault->id)) ? 'active' : '' }} {{ (request()->is('vaults/'.$vault->id.'/*')) ? 'active' : '' }}">
      <a class=" nav-link" href="{{ route('vaults.select', $vault->id) }}">
        <i class="fas fa-{{ $vault->icon }}"></i>
        <span>{{ $vault->name }}
          @if($vault->password)
          @if(session()->has($vault->id.'-pass'))
          <i class="fas fa-lock text-success"></i>
          @else
          <i class="fas fa-lock text-danger"></i>
          @endif
          @endif
        </span>
      </a>
    </li>
    @endforeach
    <li class="menu-header">{{ __('nav.personal') }}</li>
    <li class="nav-item {{ (request()->routeIs('profile.*')) ? 'active' : '' }}">
      <a href="{{ route('profile.index') }}" class="nav-link"><i class="fas fa-user"></i><span>{{ __('nav.my_profile') }}</span></a>
    </li>
    <li class="nav-item {{ (request()->routeIs('security.*')) ? 'active' : '' }}">
      <a href="{{ route('security.index') }}" class="nav-link"><i class="fas fa-lock"></i><span>{{ __('nav.security_settings') }}</span></a>
    </li>
    @if(auth()->user()->isAdmin())
    <li class="menu-header">{{ __('nav.administration') }}</li>
    <li class="nav-item">
      <a href="{{ route('admin.dashboard.index') }}" class="nav-link"><i class="fas fa-brain"></i><span>{{ __('nav.admin_dashboard') }}</span></a>
    </li>
    @endif
    <li class="menu-header">{{ __('nav.support') }}</li>
    <li class="nav-item">
      <a href="{{ route('signOut') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i><span>{{ __('nav.logout') }}</span></a>
    </li>
  </ul>
</aside>
