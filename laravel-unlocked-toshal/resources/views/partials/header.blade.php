<!-- ======= Header ======= -->
<header class="header">
    <div class="container d-flex align-items-center">
        <div class="logo mr-auto">
            <a href="{{route('home')}}"><img src="assets/image/logo.svg" alt="" class="img-fluid"></a>
        </div>
        <ul class="mob-menu-link list-inline">
            <li class="list-inline-item">
                <div class="search-container ">
                    <form class="searchbar"> <input type="text" placeholder="Search here" name="search" class="searchbar-input" onkeyup="buttonUp();" required> <input type="submit" class="searchbar-submit" value="GO">
                        <span class="searchbar-icon">
                            <img src="{{asset('assets/image/search-icon.svg')}}" alt="search" class="search-icon">
                            <img src="{{asset('assets/image/cancel.svg')}}" alt="search" class="cross-icon">
                        </span>
                    </form>
                </div>
            </li>
            <li class="list-inline-item"><a href="#"><i class="fas fa-user"></i></a></li>
        </ul>
        <nav class="nav-menu d-none d-lg-flex">
            <ul class="nav-link-items">
                <li class="active"><a href="{{route('home')}}" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#services" class="nav-link">For Venues</a></li>
                <li><a href="#portfolio" class="nav-link">How it works</a></li>
                <li><a href="#team" class="nav-link">List your</a></li>
                <li><a href="#contact" class="nav-link">Venue</a></li>
            </ul>
            <ul class="nav-link-btns">
                <li>
                    <div class="nav-search">
                        <div class="search-container">
                            <form class="searchbar"> <input type="text" placeholder="Search here" name="search" class="searchbar-input" onkeyup="buttonUp();" required> <input type="submit" class="searchbar-submit" value="GO">
                                <span class="searchbar-icon">
                                    <img src="{{asset('assets/image/search-icon.svg')}}" alt="search" class="search-icon">
                                    <img src="{{asset('assets/image/cancel.svg')}}" alt="search" class="cross-icon">
                                </span>
                            </form>
                        </div>
                    </div>
                </li>
                <li class="navbtn"><a href="#" class="get-started signin-btn btn">SIGN IN</a></li>
                <li class="px-0">
                    <a href="#" class="get-started signup-btn btn">SIGN UP</a>
                </li>
            </ul>
        </nav>
        <!-- .nav-menu -->
    </div>
</header>
<!-- End Header -->