<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        {{ trans('panel.site_title') }}
    </title>
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-5-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <!-- Slider Revolution CSS Files -->
    <link rel="stylesheet" href="{{ asset('revolution/css/settings.css')}}">
    <link rel="stylesheet" href="{{ asset('revolution/css/layers.css')}}">
    <link rel="stylesheet" href="{{ asset('revolution/css/navigation.css')}}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/search.css')}}">
    <link rel="stylesheet" href="{{ asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('css/aos.css')}}">
    <link rel="stylesheet" href="{{ asset('css/aos2.css')}}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('css/lightcase.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/menu.css')}}">
    <link rel="stylesheet" href="{{ asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/video.css')}}">
    <link rel="stylesheet" id="color" href="{{ asset('css/colors/pink.css')}}">
</head>

<body class="homepage-9 hp-6 hd-white">
    <!-- Wrapper -->
    <div id="wrapper">

        @include('partials.navigation-bar')

        @yield('content')



          <!-- START FOOTER -->
          <footer class="first-footer">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="netabout">
                                <a href="/" class="logo">
                                    <img src="{{ asset('images/logo-footer.svg')}}" alt="netcom">
                                </a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum incidunt architecto
                                    soluta laboriosam, perspiciatis, aspernatur officiis esse.</p>
                            </div>
                            <div class="contactus">
                                <ul>
                                    <li>
                                        <div class="info">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <p class="in-p">95 South Park Avenue, USA</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <p class="in-p">+456 875 369 208</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <p class="in-p ti">support@findhouses.com</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="navigation">
                                <h3>Navigation</h3>
                                <div class="nav-footer">
                                    <ul>
                                        <li><a href="/">Home One</a></li>
                                        <li><a href="#">Properties Right</a></li>
                                        <li><a href="#">Properties List</a></li>
                                        <li><a href="#">Property Details</a></li>
                                        <li class="no-mgb"><a href="#">Agents Listing</a></li>
                                    </ul>
                                    <ul class="nav-right">
                                        <li><a href="#">Agents Details</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">Blog Default</a></li>
                                        <li><a href="#">Blog Details</a></li>
                                        <li class="no-mgb"><a href="#">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="widget">
                                <h3>Twitter Feeds</h3>
                                <div class="twitter-widget contuct">
                                    <div class="twitter-area">
                                        <a class="twitter-timeline" data-height="200" data-theme="dark"
                                        data-chrome="nofooter noborders noheader noscrollbar transparent"
                                        href="https://twitter.com/moringaschool?ref_src=twsrc%5Etfw">Tweets
                                        by moringaschool</a>
                                      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="newsletters">
                                <h3>Newsletters</h3>
                                <p>Sign Up for Our Newsletter to get Latest Updates and Offers. Subscribe to receive
                                    news in your inbox.</p>
                            </div>
                            <form class="bloq-email form-inline" method="post">
                                <div class="email">
                                    <input type="email" id="subscribeEmail" name="EMAIL" placeholder="Enter Your Email">
                                    <input type="submit" value="Subscribe">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="second-footer">
                <div class="container">
                    <p>2021 © Copyright - All Rights Reserved.</p>
                    <ul class="netsocials">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <!--register form -->
        <div class="login-and-register-form modal">
            <div class="main-overlay"></div>
            <div class="main-register-holder">
                <div class="main-register fl-wrap">
                    <div class="close-reg"><i class="fa fa-times"></i></div>
                    <h3>Welcome to <span>Find<strong>Houses</strong></span></h3>
                    <div class="soc-log fl-wrap">
                        <p>Login</p>
                        <a href="#" class="facebook-log"><i class="fa fa-facebook-official"></i>Log in with Facebook</a>
                        <a href="#" class="twitter-log"><i class="fa fa-twitter"></i> Log in with Twitter</a>
                    </div>
                    <div class="log-separator fl-wrap"><span>Or</span></div>
                    <div id="tabs-container">
                        <ul class="tabs-menu">
                            <li class="current"><a href="#tab-1">Login</a></li>
                            <li><a href="#tab-2">Register</a></li>
                        </ul>
                        <div class="tab">
                            <div id="tab-1" class="tab-contents">
                                <div class="custom-form">
                                    <form method="post" name="registerform">
                                        <label>Username or Email Address * </label>
                                        <input name="email" type="text" onClick="this.select()" value="">
                                        <label>Password * </label>
                                        <input name="password" type="password" onClick="this.select()" value="">
                                        <button type="submit" class="log-submit-btn"><span>Log In</span></button>
                                        <div class="clearfix"></div>
                                        <div class="filter-tags">
                                            <input id="check-a" type="checkbox" name="check">
                                            <label for="check-a">Remember me</label>
                                        </div>
                                    </form>
                                    <div class="lost_password">
                                        <a href="#">Lost Your Password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div id="tab-2" class="tab-contents">
                                    <div class="custom-form">
                                        <form method="post" name="registerform" class="main-register-form"
                                            id="main-register-form2">
                                            <label>First Name * </label>
                                            <input name="name" type="text" onClick="this.select()" value="">
                                            <label>Second Name *</label>
                                            <input name="name2" type="text" onClick="this.select()" value="">
                                            <label>Email Address *</label>
                                            <input name="email" type="text" onClick="this.select()" value="">
                                            <label>Password *</label>
                                            <input name="password" type="password" onClick="this.select()" value="">
                                            <button type="submit" class="log-submit-btn"><span>Register</span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--register form end -->

        <!-- START PRELOADER -->
        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
        <!-- END PRELOADER -->

        <!-- ARCHIVES JS -->
        <script src="{{ asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{ asset('js/rangeSlider.js')}}"></script>
        <script src="{{ asset('js/tether.min.js')}}"></script>
        <script src="{{ asset('js/popper.min.js')}}"></script>
        <script src="{{ asset('js/moment.js')}}"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/mmenu.min.js')}}"></script>
        <script src="{{ asset('js/mmenu.js')}}"></script>
        <script src="{{ asset('js/aos.js')}}"></script>
        <script src="{{ asset('js/aos2.js')}}"></script>
        <script src="{{ asset('js/slick.min.js')}}"></script>
        <script src="{{ asset('js/fitvids.js')}}"></script>
        <script src="{{ asset('js/jquery.waypoints.min.js')}}"></script>
        <script src="{{ asset('js/typed.min.js')}}"></script>
        <script src="{{ asset('js/jquery.counterup.min.js')}}"></script>
        <script src="{{ asset('js/imagesloaded.pkgd.min.js')}}"></script>
        <script src="{{ asset('js/isotope.pkgd.min.js')}}"></script>
        <script src="{{ asset('js/smooth-scroll.min.js')}}"></script>
        <script src="{{ asset('js/lightcase.js')}}"></script>
        <script src="{{ asset('js/search.js')}}"></script>
        <script src="{{ asset('js/owl.carousel.js')}}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ asset('js/ajaxchimp.min.js')}}"></script>
        <script src="{{ asset('js/newsletter.js')}}"></script>
        <script src="{{ asset('js/jquery.form.js')}}"></script>
        <script src="{{ asset('js/jquery.validate.min.js')}}"></script>
        <script src="{{ asset('js/searched.js')}}"></script>
        <script src="{{ asset('js/forms-2.js')}}"></script>
        <script src="{{ asset('js/leaflet.js')}}"></script>
        <script src="{{ asset('js/leaflet-gesture-handling.min.js')}}"></script>
        <script src="{{ asset('js/leaflet-providers.js')}}"></script>
        <script src="{{ asset('js/leaflet.markercluster.js')}}"></script>
        <script src="{{ asset('js/map-style2.js')}}"></script>
        <script src="{{ asset('js/range.js')}}"></script>
        <script src="{{ asset('js/color-switcher.js')}}"></script>

        <!-- Slider Revolution scripts -->
        <script src="{{ asset('revolution/js/jquery.themepunch.tools.min.js')}}"></script>
        <script src="{{ asset('revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.carousel.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
        <script src="{{ asset('revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
        <script>
            var typed = new Typed('.typed', {
                strings: ["House ^2000", "Apartment ^2000", "Plaza ^4000"],
                smartBackspace: false,
                loop: true,
                showCursor: true,
                cursorChar: "|",
                typeSpeed: 50,
                backSpeed: 30,
                startDelay: 800
            });

        </script>
        <script>
            $('.slick-lancers').slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: true,
                arrows: false,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1292,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                }, {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }]
            });

        </script>

        <script>
            $(".dropdown-filter").on('click', function () {

                $(".explore__form-checkbox-list").toggleClass("filter-block");

            });

        </script>

        <!-- MAIN JS -->
        <script src="{{ asset('js/script.js')}}"></script>

    </div>
    <!-- Wrapper / End -->
</body>



</html>
