<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" charset="utf-8">
    
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{url('tmart/css/bootstrap.min.css') }}">
    <!-- Owl Carousel main css -->
    <link rel="stylesheet" href="{{url('tmart/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{url('tmart/css/owl.theme.default.min.css') }}">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="{{url('tmart/css/core.css') }}">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="{{url('tmart/css/shortcode/shortcodes.css') }}">
    <!-- Theme main style -->
    <link rel="stylesheet" href="{{ url('tmart/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{url('tmart/css/responsive.css') }}">
    <!-- User style -->
    <link rel="stylesheet" href="{{url('tmart/css/custom.css') }}">


    <!-- Modernizr JS -->
    <script src="{{url('tmart/js/vendor/modernizr-3.11.7.min.js') }}"></script>
</head>
<body>
    <div id="app" class="wrapper fixed__footer">

        <!-- Start Header Style -->
        <header id="header" class="htc-header header--3 bg__white clearfix">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-2 col-5">
                            <div class="logo">
                              
                            </div>
                        </div>
                        <!-- Start MAinmenu Ares -->
                        <div class="col-md-8 col-lg-8 d-none d-lg-block">
                            <nav class="mainmenu__nav d-none d-lg-block">
                                <ul class="main__menu">
                                    <li class="drop"><a href="{{route('home')}}">Home</a></li>
                                   
                                   @php
                                        $php_session_id = session()->getId();
                                        $cart_counts = App\Models\TempCart::where('php_session_id', $php_session_id)->count();
                                   @endphp
                                    <li><a href="{{route('cart')}}">View Cart {{($cart_counts > 0) ? '('.$cart_counts.')' : ''}}</a></li>
                                </ul>
                            </nav>
                                              
                        </div>
                        <!-- End MAinmenu Ares -->
                        <div class="col-md-6 col-lg-2 col-7">  
                         
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Style -->


        <div class="body__overlay"></div>

        <main class="py-4">
            @yield('content')
        </main>


         <!-- Start Footer Area -->
        <footer class="htc__foooter__area gray-bg">
            <div class="container">
                <!-- Start Copyright Area -->
                <div class="htc__copyright__area">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-12">
                            <div class="copyright__inner">
                                <div class="copyright">
                                    <p>© 2021 <a href="#">your website name</a>
                                    All Right Reserved.</p>
                                </div>
                                <ul class="footer__menu">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop.html">Product</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Copyright Area -->
            </div>
        </footer>
        <!-- End Footer Area -->

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>


     <!-- jquery latest version -->
    <script src="{{url('tmart/js/vendor/jquery-v1.12.4.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="{{url('tmart/js/popper.js')}}"></script>
    <script src="{{url('tmart/js/bootstrap.min.js')}}"></script>
    <!-- All js plugins included in this file. -->
    <script src="{{url('tmart/js/plugins.js')}}"></script>
    <script src="{{url('tmart/js/slick.min.js')}}"></script>
    <script src="{{url('tmart/js/owl.carousel.min.js')}}"></script>
    <!-- Waypoints.min.js. -->
    <script src="{{url('tmart/js/waypoints.min.js')}}"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="{{url('tmart/js/main.js')}}"></script>


</body>
</html>
