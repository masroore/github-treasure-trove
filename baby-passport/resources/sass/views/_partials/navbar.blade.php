<header class="fixed-top shadow" id="main-header">


    <nav class="navbar navbar-expand-lg navbar-light py-4 py-lg-0">

        <!-- MOBILE MENU -->
        <div class="d-flex d-lg-none w-100 justify-content-around ">


            <a class="navbar-brand" href="#">
                <img src="{{asset('img/logos/icono-78ded4.png')}}" alt="Logo Baby Passport" height="30" class="mr-2">
                <img src="{{asset('img/logos/logo-78ded4.png')}}" alt="Logo Baby Passport" height="30">
            </a>
            <div class="spacer"></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
        <!-- END MOBILE MENU -->

        <!-- LARGE DEVICES MENU -->

        <div class="d-none d-lg-block ml-5">
            <a class="navbar-brand" href="{{route('web.index')}}">
                <img src="{{asset('img/logos/icono-78ded4.png')}}" alt="Logo Baby Passport" height="30" class="mr-2">
                <img src="{{asset('img/logos/logo-78ded4.png')}}" alt="Logo Baby Passport" height="30">
            </a>
            <div class="spacer"></div>
        </div>
        <!-- END LARGE DEVICES  MENU -->


        <!-- NAVBAR LINKS -->
        <div class="collapse navbar-collapse ml-auto" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{Request::routeIs('web.index') ? 'active':''}} mt-3 mt-lg-0">
                    <a class="nav-link text-mandys-pink"
                       href="{{route('web.index')}}">INICIO</a>
                </li>

                <li class="nav-item {{Request::routeIs('web.getAtentionCenter') ? 'active':''}} mt-3 mt-lg-0">
                    <a class="nav-link text-mandys-pink"
                       href="{{route('web.getAtentionCenter')}}">CENTROS DE ATENCIÓN</a>
                </li>
                <li class="nav-item {{Request::routeIs('web.getBlog') ? 'active':''}} mt-3 mt-lg-0">
                    <a class="nav-link text-mandys-pink"
                       href="{{route('web.getBlog')}}">BLOGS</a>
                </li>
              <!--  <li class="nav-item {{Request::routeIs('web.getHowToWin') ? 'active':''}} mt-3 mt-lg-0">
                    <a class="nav-link"
                       href="{{route('web.getHowToWin')}}">COMO GANAR</a>
                </li>-->
                <li class="nav-item {{Request::routeIs('web.getFaqs') ? 'active':''}} mt-3 mt-lg-0">
                    <a class="nav-link text-mandys-pink"
                       href="{{route('web.getFaqs')}}">PREGUNTAS FRECUENTES</a>
                </li>

                <li class="nav-item mt-3 mt-lg-0">
                    <a class=" text-white nav-link waves-effect waves-light bg-ce-soir mt-3 mr-5 button-border py-2 px-3" href="{{route('web.getAboutUs')}}"> ¿ERES DOCTOR?</a>
                </li>

       
            </ul>
        </div>
        <!-- END NAVBAR LINKS -->
    </nav>


</header>
