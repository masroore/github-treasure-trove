<!-- Header -->
<header class="header">
    <div class="header_inside d_flex">
        <div class="navigation-container">
            <!-- Mobile burger menu icon -->
            <div class="menuBar"><i class="fas fa-bars"></i></div>
            <div class="main-nav">
                <!-- navigation bar -->
                <nav>
                    <!-- mobile menu close btn -->
                    <div class="close"><i class="fas fa-times"></i></div>
                    <!-- menu start -->
                    <ul class="menu">
                        <li><a href="{{ URL::to('/') }}">home</a></li>
                        <li class="multi-nav"><a href="#">categories</a>
                            <ul class="sub-menu">
                                @foreach ($categories as $category)
                                    <li class="menu-item"><a
                                            href="{{url('/categories/'.$category->slug)}}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('contact.index') }}">contact</a></li>

                        @if (Route::has('login'))
                            @auth

                            @else
                                <li>
                                    <a href="{{ route('login') }}">Login</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">register</a>
                                </li>
                            @endauth
                        @endif

                    </ul>
                    <!-- menu end -->
                </nav>
            </div>
        </div>

    @if (auth()->check())
        <!-- if login, then show profile menus -->
            <div class="profile_menu">
                <div class="dropdown">
                    <span class="dropdown-toggle" type="button" id="dropdownMenuButton"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hey! {{ auth()->user()->name }}
                    </span>
                    <div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">

                        @can('update', auth()->user())
                            <a class="dropdown-item" href="{{ route('users.edit',auth()->id()) }}"><i
                                    class="far fa-user-circle"></i> profile</a>
                        @endcan

                        <a class="dropdown-item" href="{{ route('post.create') }}"><i class="fas fa-pen-nib"></i> write
                            post</a>

                        <a class="dropdown-item" href="{{ route('category.index') }}"><i class="far fa-list-alt"></i>
                            categories</a>

                        <a class="dropdown-item" href="{{ route('tag.index') }}"><i class="fas fa-tags"></i> Tags</a>

                        @can('viewAny', auth()->user())
                            <a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-users"></i>
                                registered users</a>
                        @endcan


                        <a class="dropdown-item" href="{{ route('post.index') }}"><i class="far fa-newspaper"></i> all
                            posts</a>

                        <a class="dropdown-item" href="{{ route('roles.index') }}"><i class="fas fa-user-shield"></i>
                            Roles & permissions</a>

                        <a class="dropdown-item" href="{{ route('users.setting') }}"><i class="fas fa-cog"></i>
                            Settings</a>
                            
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
    @else
        <!-- if not logged then show social icons -->
            <div class="social_btns">
                <div class="social_btn">
                    <i class="fas fa-share-alt"></i>
                </div>

                <div class="social">
                    <a href="https://twitter.com/MDRiaz53949149"><i class="fab fa-twitter"></i></a>
                    <a href="http://www.facebook.com/mdriaz.wd"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/md_riaz___/"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-google-plus-g"></i></a>
                </div>
            </div>
        @endif


    </div>
    <!-- Main Logo -->
    <div class="logo-container bottom_bar">
        <a href="{{ URL::to('/') }}">Lara Blog</a>
    </div>
</header>
<!--   Header Section End -->
