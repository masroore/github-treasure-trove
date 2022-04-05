<nav class="main_nav" style="background-color:black">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="main_nav_content d-flex flex-row" style="background-color:black">

                    <!-- Categories Menu -->

                    <div class="cat_menu_container" style="background-color:black">
                        <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                            <div class="cat_burger text-white" style="color: white !important">
                                <span></span><span></span><span></span>
                            </div>
                            <div class="cat_menu_text m-3">
                                <img class="d-none d-md-block d-sm-block"
                                    src="{{ asset('assets/images/55.png') }}" height="50px" alt="">
                                <img class="d-md-none d-sm-none d-block" style="margin-top:5px" 
                                    src="{{ asset('assets/images/55.png') }}"  height="40px" alt="">
                            </div>
                        </div>

                        <ul class="cat_menu">
                            <li><a href="{{ config('app.url') }}" class="@if (Route::currentRouteName()==='welcome' ) active @endif">Home<i class="fas fa-chevron-right"></i></a></li>
                            <li><a href="{{ config('app.url') }}/groups" class="@if (Route::currentRouteName()==='group' ) active @endif">Nominations<i class="fas fa-chevron-right"></i></a></li>
                            <li><a href="{{ config('app.url') }}/profile" class="@if (Route::currentRouteName()==='profile' ) active @endif">Profile<i class="fas fa-chevron-right"></i></a></li>
                            <li><a href="{{ config('app.url') }}/dashboard" class="@if (Route::currentRouteName()==='dashboard' ) active @endif">Results<i class="fas fa-chevron-right"></i></a></li>
                            {{-- <li><a href="https://revoltdaily.com/contact/">Contact<i
                                        class="fas fa-chevron-right"></i></a></li> --}}
                            <li><a href="https://revoltdaily.com/about-us/">About<i
                                        class="fas fa-chevron-right"></i></a></li>
                            @if (Route::has('login'))
                                @auth
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        <li>
                                            @csrf
                                            <a style="cursor:pointer"
                                                onclick="event.preventDefault(); document.forms['logout-form'].submit()">Logout<i
                                                    class="fa fa-chevron-right"></i></a>
                                        </li>
                                    </form>

                                @else
                                    {{-- <li><a href="{{ config('app.url') }}/auth/google">Register<i class="fa fa-chevron-right"></i></a>
                                    </li> --}}
                                    <li><a href="{{ config('app.url') }}/auth/google">Sign In<i class="fa fa-chevron-right"></i></a>
                                    </li>

                                @endauth
                            @endif
                        </ul>
                    </div>

                    <!-- Main Nav Menu -->

                    <style>
                        a.active {
                            color: #F8A11C !important;
                        }

                    </style>
                    <div class="main_nav_menu ml-auto">
                        <ul class="standard_dropdown main_nav_dropdown">
                            <li><a href="{{ config('app.url') }}" class="@if (Route::currentRouteName()==='welcome' ) active @endif">Home<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="{{ config('app.url') }}/groups" class="@if (Route::currentRouteName()==='group' ) active @endif">Nominations<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="{{ config('app.url') }}/profile" class="@if (Route::currentRouteName()==='profile' ) active @endif">Profile<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="{{ config('app.url') }}/dashboard" class="@if (Route::currentRouteName()==='dashboard' ) active @endif">Results<i class="fas fa-chevron-down"></i></a></li>

                            {{-- <li><a href="https://revoltmusicgroup.com/contact/">Contact<i
                                        class="fas fa-chevron-down"></i></a></li> --}}
                            <li><a href="https://revoltmusicgroup.com/about/">About<i
                                        class="fas fa-chevron-down"></i></a></li>
                            @if (Route::has('login'))
                                @auth
                                <li>
                                    @csrf
                                    <a href="#"
                                        onclick="event.preventDefault(); document.forms['logout-form'].submit()">Logout<i
                                            class="fas fa-chevron-down"></i></a>
                                </li>
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        
                                    </form>

                                @else
                                    {{-- <li><a href="{{ config('app.url') }}/auth/google">Register<i class="fa fa-angle-down"></i></a>
                                    </li> --}}
                                    <li><a href="{{ config('app.url') }}/auth/google">Sign In<i class="fa fa-angle-down"></i></a>
                                    </li>

                                @endauth
                            @endif
                        </ul>
                    </div>

                    <!-- Menu Trigger -->

                    {{-- <div class="menu_trigger_container ml-auto">
                        <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                            <div class="menu_burger">
                                <div class="menu_trigger_text">menu</div>
                                <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Menu -->

{{-- <div class="page_menu">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="page_menu_content">
                    
                    <div class="page_menu_search">
                        <form action="#">
                            <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
                        </form>
                    </div>
                    <ul class="page_menu_nav">
                        <li class="page_menu_item">
                            <a href="{{ config('app.url') }}" class="@if (Route::currentRouteName() === 'welcome') active @endif">Home<i class="fa fa-angle-down"></i></a>
                        </li>
                        <li class="page_menu_item"><a href="{{ config('app.url') }}/groups">Nominations<i class="fa fa-angle-down"></i></a></li>
                        <li class="page_menu_item"><a href="https://revoltmusicgroup.com/contact/">Contact<i class="fa fa-angle-down"></i></a></li>
                        <li class="page_menu_item"><a href="https://revoltmusicgroup.com/about/">About<i class="fa fa-angle-down"></i></a></li>

                       </ul>
                    
                    <div class="menu_contact">
                        <div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/phone_white.png" alt=""></div>+16143792522</div>
                        <div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/mail_white.png" alt=""></div><a href="mailto:sales@paydaily.online">info.revoltmusicgroup@gmail.com</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
