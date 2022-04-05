<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-dark navbar-shadow text-white">

    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>
                    </ul>
                </div>
               
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item mr-auto">
                        
                            {{-- <i class="ficon feather icon-maximize"></i> --}}
                            
                    </li>
                    {{-- Notificaciones --}}
                    {{-- @include('layouts.componenteDashboard.notificaciones') --}}
                    {{-- Fin Notificaciones --}}
                    {{-- <li class="dropdown dropdown-user nav-item pt-2">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-status headerBalance">Saldo Disponible: {{Auth::user()->balance}} $</span>
                        </div>
                    </li> --}}
                        <li class="dropdown dropdown-user nav-item" >
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                @if (Auth()->user()->admin == '1')
                                <span class="user-name text-bold-600 text-white">{{Auth::user()->fullname}} <span class="text-primary">ADMIN</span></span>
                                {{-- <span class="user-name text-bold-600 text-primary p">Administrador</span> --}}
                                <span class="user-name headerBalance">Saldo Disponible: {{Auth::user()->wallet}} $</span>

                                @else
                                <span class="user-name text-bold-600 text-white">
                                    {{Auth::user()->fullname}} -
                                    <span class="text-primary">{{Auth::user()->getStatus()}}</span>
                                </span>
                                <span class="user-name text-white">Saldo Disponible: {{Auth::user()->saldoDisponible()}} $</span>
                                @endif
                            </div>

                            @if (Auth::user()->photoDB != NULL)
                            <span>
                                <img class="round" src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                                    alt="{{ Auth::user()->fullname }}" height="50" width="50">
                            </span>
                            @else
                            <span>
                                <img class="round" src="{{asset('assets/img/royal_green/logos/logo.svg')}}"
                                    alt="{{ Auth::user()->fullname }}" height="50" width="50">
                            </span>
                            @endif
                    

                        </a>
                        <div class="dropdown-menu dropdown-menu-right" style="background: #11262C;">
                            <a class="dropdown-item text-white" href="{{ route('profile') }}" >
                                <i class="feather icon-user"></i> Editar Perfil
                            </a>
                            @if (session('impersonated_by'))
                            <a class="dropdown-item text-white" href="{{ route('impersonate.stop') }}">
                                <i class="feather icon-log-in"></i> Volver a mi Usuario
                            </a>    
                            @endif
                            {{-- <a class="dropdown-item" href="app-email.html">
                                <i class="feather icon-mail"></i> My Inbox
                            </a>
                            <a class="dropdown-item" href="app-todo.html">
                                <i class="feather icon-check-square"></i> Task
                            </a>
                            <a class="dropdown-item" href="app-chat.html">
                                <i class="feather icon-message-square"></i> Chats
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-white" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="feather icon-log-out"></i> Logout
                            </a>            
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->