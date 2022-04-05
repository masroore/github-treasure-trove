

<nav class="navbar1  mx-auto navbar navbar-expand-lg navbar-light bg-light" style="font-size: 18px; ">
    <div class="container">
    <a class="navbar-brand " href="{{route('inicio.index')}}">
        <img src="{{ asset('assets/img/royal_green/logos/logoRoyal-liefe.png') }}" class="" style="width: 80px;">
     </a>
    <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=" navbar-toggler-icon"></span>
    </button>

    <div class=" collapse navbar-collapse" id="navbarSupportedContent">
        @if (Auth::user() == false)
      <ul class="navbar-nav mx-auto ">
        <li class="nav-item active ">
          <a class="nav-link ml-5  mt-1 text-white side " href="{{route('inicio.index')}}">INICIO<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link ml-5 mt-1 text-white side" href="{{route('shop.backofice')}}">TIENDA</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ml-5 mt-1 text-white side" href="{{route('about')}}">NOSOTROS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-5 mt-1 text-white side" href="{{route('contact_us')}}">CONTACTO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-5 mt-1 text-white side1  btn-primario1" href="{{route('login')}}">Backoffice</a>
          </li>
          <li class="nav-item mt-1 ml-2" >
            <a class="ml-2 nav-link text-white " style="font-size: 25px; position: relative; top: -5px;"
            href="{{route('cart')}}"><i class="side ml-1 feather icon-shopping-cart"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-3 mt-1 text-white side" href="#"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-3 mt-1 text-white side" href="#"></a>
          </li>
          @else

          <ul class="navbar-nav mx-auto">
            <li class="nav-item active ">
              <a class="nav-link mt-1 ml-5 text-white side" href="{{route('inicio.index')}}">INICIO<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link mt-1 ml-5 text-white side" href="{{route('shop.backofice')}}">TIENDA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mt-1 ml-5 text-white side" href="{{route('about')}}">NOSOTROS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mt-1 ml-5 text-white side" href="{{route('contact_us')}}">CONTACTO</a>
              </li>


          @endif

          <li class="nav-item">
            <a class="nav-link ml-3" href="#">

                    @if (Auth::user() == true)
                <span>
                    @if(Auth::user()->photoDB == null)

                    @else
                        <img class="round " style="" src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                        alt="" height="50" width="50">
                    @endif
                </span>
                @else
                <span>

                </span>
                @endif


            </a>
          </li>
          @if (Auth::user() == true)
        <li class="nav-item dropdown text-white" >
          <a class="mt-1 ml-3 nav-link dropdown-toggle text-white side"
          href="#" id="navbarDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false">

           {{Auth::user()->fullname}}
          </a>
          <div class="ml-3 dropdown-menu" aria-labelledby="navbarDropdown" style="background: #11262C; top: 40px;">
            <a class="dropdown-item text-white side" href="{{ route('profile') }}">
                <i class="feather icon-user"></i>Editar Perfil</a>

            <a class="dropdown-item text-white side" href="{{ route('home') }}">
                <i class="feather icon-home "></i>Backoffice</a>

                <a class="dropdown-item text-white side" href="{{ route('MisCompras') }}">
                    <i class="feather icon-shopping-cart"></i>Mis Compras</a>

            <div class="dropdown-divider"  href="#"></div>

            <a class="dropdown-item text-white side" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="feather icon-log-out"></i>Logout</a>
          </div>
        </li>

        <li class="nav-item mt-1 mr-5" >
            <a class="ml-2 nav-link text-white " style="font-size: 25px; position: relative; top: -5px;"
            href="{{route('cart')}}"><i class="side ml-1 feather icon-shopping-cart"></i></a>
          </li>

           @else

           @endif
      </ul>

    </div>
</div>

  </nav>
