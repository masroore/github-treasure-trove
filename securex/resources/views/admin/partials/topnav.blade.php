<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">
    @include('main.partials.notifications')
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('img/users/avatar/'.auth()->user()->avatar) }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{ __('nav.hi_user', ['user' => Auth::user()->first_name ]) }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            @if(auth()->user()->previousLoginAt())
            <div class="dropdown-title"><small><b>{{ __('nav.last_login', ['login' => auth()->user()->previousLoginAt()->diffForHumans() ] )}}</b></small></div>
            @endif
            <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{ __('nav.my_profile') }}
            </a>
            <a href="{{ route('security.index') }}" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> {{ __('nav.security_settings') }}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('signOut') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> {{ __('nav.logout') }}
            </a>
        </div>
    </li>
</ul>