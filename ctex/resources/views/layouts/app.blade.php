<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'ADAM Bit') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Bootstrap datetimepicker css -->
    <link href="{{ asset('plugins/bootstrap-datetimepicker/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Body Inner -->
    <div class="body-inner background-dark min-vh-100">
        <!-- Header -->
        <header id="header" class="dark" data-fullwidth="true">
            <div class="header-inner">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="{{ route('/') }}">
                            <span class="logo-default"><img src="{{ asset('/images/logo_main.png') }}"></span>
                            <span class="logo-dark text-primary"><img src="{{ asset('/images/logo_main.png') }}" style="max-height: 45px"></span>
                        </a>
                    </div>
                    <!--End: Logo-->
                    <!--Header Extras-->
                    <div class="header-extras">
                        <ul>
                            <li>
                                <div class="p-dropdown" id="lang_dropdown">
                                    <a href="#"><i class="icon-globe"></i><span>{{ app()->getLocale() }}</span></a>
                                    <ul class="p-dropdown-content background-black-dark border-panel">
                                        @foreach(config('constants.language_list') as $language_info)
                                            <li><a href="{{ url('lang') . '/' . $language_info['code']}}">{{ $language_info['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--end: Header Extras-->
                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <a class="lines-button x mx-3"><span class="lines"></span></a>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->
                    <!--Navigation-->
                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a id="top_home" href="{{ route('/') }}"><i class="fa fa-home"></i>{{ trans('common.top_menu.home') }}</a></li>
                                    <li><a id="top_news" href="{{ route('news') }}"><i class="fas fa-newspaper"></i>{{ trans('common.top_menu.news') }}</a></li>
                                    <li><a id="top_exchange" href="{{ route('exchange') }}"><i class="fa fa-chart-bar"></i>{{ trans('common.top_menu.exchange') }}</a></li>
                                    <li><a id="top_dealer" href="{{ route('dealer') }}"><i class="fa fa-money-bill-wave"></i>{{ trans('common.top_menu.dealer') }}</a></li>
                                    <!--<li><a href="">Overview</a></li>
                                    <li><a href="">Services</a></li>
                                    <li><a href="">How to Use</a></li>-->
                                    <li><a id="top_faq" href="{{ route('faq') }}"><i class="fa fa-question-circle"></i>{{ trans('common.top_menu.faq') }}</a></li>
                                    <li><a id="top_contactus" href="{{ route('contactus') }}"><i class="fas fa-envelope"></i>{{ trans('common.top_menu.contactus') }}</a></li>
                                    @guest
                                    <li><a id="top_login" href="{{ route('login') }}"><i class="icon-log-in"> </i>{{ trans('common.top_menu.login') }}</a></li>
                                    <li><a id="top_register" href="{{ route('register') }}"><i class="icon-user-plus"> </i>{{ trans('common.top_menu.register') }}</a></li>
                                    @else
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ trans('common.top_menu.logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                    @endguest
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--end: Navigation-->
                </div>
            </div>
        </header>

        @yield('content')

        <footer id="footer" class="inverted">
            <div class="footer-content">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-md-5">
                            <div class="widget">
                                <div class="widget-title">{{ config('app.name') }}</div>
                                <p>{{ trans('common.footer_menu.desc') }}</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="widget">
                                        <ul class="list">
                                            <li><a href="{{ route('cookiespolicy') }}">{{ trans('common.footer_menu.cookiespolicy') }}</a></li>
                                            <li><a href="{{ route('termofservice') }}">{{ trans('common.footer_menu.termofservice') }}</a></li>
                                            <li><a href="{{ route('privacynotice') }}">{{ trans('common.footer_menu.privacynotice') }}</a></li>
                                            <li><a href="{{ route('disclosures') }}">{{ trans('common.footer_menu.disclosures') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="widget">
                                        <ul class="list">
                                            <li><a href="{{ route('exchange') }}">{{ trans('common.footer_menu.exchange') }}</a></li>
                                            <li><a href="{{ route('dealer') }}">{{ trans('common.footer_menu.dealer') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="widget">
                                        <ul class="list">
                                            <li><a href="{{ route('news') }}">{{ trans('common.footer_menu.news') }}</a></li>
                                            <li><a href="{{ route('faq') }}">{{ trans('common.footer_menu.faq') }}</a></li>
                                            <li><a href="{{ route('contactus') }}">{{ trans('common.footer_menu.contactus') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="widget">
                                        <ul class="list">
                                            <li><a href="{{ route('login') }}">{{ trans('common.footer_menu.login') }}</a></li>
                                            <li><a href="{{ route('register') }}">{{ trans('common.footer_menu.register') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!--Template functions-->
    <script src="{{ asset('js/functions.js') }}"></script>

    <script>
        $(document).on("click", function(event){
            var $trigger = $("#lang_dropdown");
            if($trigger !== event.target && !$trigger.has(event.target).length){
                $("#lang_dropdown").removeClass("dropdown-active");
            }
        });
    </script>

    @yield('script')
</body>
</html>
