
<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-dark navbar-shadow text-white">
    <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" class="pl-5 margen-h" alt="">

    <div class="collapse navbar-collapse justify-content-end" id="">
      <ul class="navbar-nav ">
        <li class="nav-item active">
          <a class="nav-link ml-3 h5 text-white side" href="{{route('inicio')}}" style="font-size: 18px; ">inicio <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link ml-3 h5 text-white  side" href="{{route('shop.backofice')}}" style="font-size: 18px;">Tienda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  ml-3 h5 text-white side" href="{{route('about')}}" style="font-size: 18px;">Nosotros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ml-3 h5 text-white side" href="{{route('contact_us')}}" style="font-size: 18px;">Contacto</a>
          </li>
      </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end  pr-5" style="margin-right: 130px;">
        @if (!!!Auth()->user())
        <img src="{{asset('assets/img/iconnew/Vector.png')}}" alt="">
        <a class="text-white ml-1 side" style="font-size: 18px;" href="{{route('login')}}">Ingresar</a>
        @else
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
                    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" style="margin-right: -30px;margin-top: -20px;">
                        <div class="user-nav d-flex justify-content-end ml-2">
                          <div class="col-3">
                          @if (Auth::user()->photoDB != NULL)
                          <span>
                              <img class="round mt-2" src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                                  alt="{{ Auth::user()->fullname }}" height="50" width="50">
                          </span>
                          @else
                          <span>

                          </span>
                          @endif
                        </div>
                          <div class="col-9 mr-1">
                            @if (Auth()->user()->admin == '1')
                            <div style="margin-top: 30px; left: ">
                            <span class="ml-3 user-name text-bold-600 text-white mt-2">{{Auth::user()->fullname}} <span class="text-primary">ADMIN</span></span>
                          </div>
                          <div  class="ml-1" style="margin-top: 15px;">
                            <span class="user-name headerBalance">Saldo Disponible: {{Auth::user()->wallet}} $</span>
                          </div>
                            @else
                            <div class="ml-1" style="margin-top: 35px; ">
                            <span class="user-name text-bold-600 text-white mr-1 mt-2" >
                                {{Auth::user()->fullname}} - <span class="text-primary">{{Auth::user()->getStatus()}}</span>
                            </span>
                            </div>
                              {{--    <div style="margin-top: 10px;">
                      <span class="user-name headerBalance">Saldo Disponible: {{Auth::user()->saldoDisponible()}} $</span>
                            </div>  --}}
                            @endif
                          </div>
                        </div>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="background: #11262C;">
                        <a class="dropdown-item text-white" href="{{ route('profile') }}" >
                            <i class="feather icon-user"></i> Editar Perfil
                        </a>
                        <a class="dropdown-item text-white" href="{{ route('home') }}" >
                          <i class="feather icon-home"></i>Inversiones</a>
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
            @endif
          <a class="text-white pl-1 pr-1"style="font-size: 25px;" href="">|</a>
        <a href="{{route('cart')}}"><img src="{{asset('assets/img/iconnew/Group.png')}}" alt=""></a>
</div>

</nav>
<!-- END: Header-->
