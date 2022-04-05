<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'CTEX') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/range-slider/rangeslider.css') }}" rel="stylesheet">
    <!--Toastr switch files-->
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet" >

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="background-dark">
<!-- Body Inner -->
<div class="body-inner dark vh-100">
    @auth
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
                            <div class="p-dropdown" id="notify_dropdown">
                                <a href="#"><i class="icon-bell"></i></a>
                                <div class="p-dropdown-content background-black-dark border-panel">
                                    <div class="widget-notification">
                                        <h4 class="mb-0">{{ trans('common.top_menu.notification') }}</h4>
                                        <!--<p class="text-muted">You have 2 new notifications</p>-->
                                        @foreach(\App\Http\Controllers\Controller::getLastNotifications() as $notification_info)
                                            <div class="notification-item @if($notification_info['status'] == config('constants.notifications_status.unread')) notification-new @endif">
                                                <div class="notification-meta">
                                                    <a href="#">{{ $notification_info['title'] }}</a>
                                                    <span>{{ $notification_info['updated_at'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="m-t-20"><a href="{{ route('notifications') }}" class="text-theme">{{ trans('buttons.all_notifications') }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="p-dropdown" id="lang_dropdown">
                                <a href="#"><i class="icon-globe"></i><span>{{ app()->getLocale() }}</span></a>
                                <div class="p-dropdown-content background-black-dark border-panel">
                                    <ul>
                                        @foreach(config('constants.language_list') as $language_info)
                                            <li><a href="{{ url('lang') . '/' . $language_info['code']}}">{{ $language_info['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--end: Header Extras-->
                <!--Navigation Resposnive Trigger-->
                <div id="mainMenu-trigger">
                    <a class="lines-button x mx-2"><span class="lines"></span></a>
                </div>
                <!--end: Navigation Resposnive Trigger-->
                <!--Navigation-->
                <div id="mainMenu">
                    <div class="container">
                        <nav>
                            <ul>
                                <li><a id="top_home" href="{{ route('home') }}"><i class="fas fa-tachometer-alt"></i>{{ trans('common.top_menu.dashboard') }}</a></li>
                                <li><a id="top_news" href="{{ route('news') }}"><i class="fas fa-newspaper"></i>{{ trans('common.top_menu.news') }}</a></li>
                                <li><a id="top_exchange" href="{{ route('exchange') }}"><i class="fa fa-chart-bar"></i>{{ trans('common.top_menu.exchange') }}</a></li>
                                <li><a id="top_dealer" href="{{ route('dealer') }}"><i class="fa fa-money-bill-wave"></i>{{ trans('common.top_menu.dealer') }}</a></li>
                                <li><a id="top_payment" href="{{ route('payment') }}"><i class="fa fa-wallet"></i>{{ trans('common.top_menu.payment') }}</a></li>
                                <li><a id="top_report" href="{{ route('report') }}"><i class="fa fa-file-alt"></i>{{ trans('common.top_menu.report') }}</a></li>
                                <li><a id="top_setting" href="{{ route('setting') }}"><i class="fa fa-cog"></i>{{ trans('common.top_menu.setting') }}</a></li>
                                <li><a id="top_faq" href="{{ route('faq') }}"><i class="fa fa-question-circle"></i>{{ trans('common.top_menu.faq') }}</a></li>
                            <!--                                <li><a href="{{ route('contactus') }}"><i class="fas fa-envelope"></i>{{ trans('common.top_menu.contactus') }}</a></li>-->
                                <li class="dropdown"><a href="#"><img src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('images/user-avatar.png') }}" class="avatar avatar-lg m-r-5"><span>{{ Auth::user()->name }}</span></a>
                                    <ul class="dropdown-menu background-black-dark border-panel">
                                        <li><a href="{{ route('setting') }}">{{ trans('common.top_menu.setting') }}</a></li>
                                        <li><a href="{{ route('notifications') }}">{{ trans('common.top_menu.notification') }}</a></li>
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ trans('common.top_menu.logout') }}</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--end: Navigation-->
            </div>
        </div>
    </header>
    @else
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
    @endauth
    <!-- Topbar -->
    <div id="topbar" class="dark topbar-fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="top-menu">

                        <li class="p-dropdown" id="symbol_dropdown">
                            <a href=""><span class="border-symbol px-3 py-2 b-r-10" id="symbol"></span></a>
                            <input type="hidden" id="symbol_id">
                            <ul class="p-dropdown-content background-dark border-symbol">
                                @foreach(\App\Http\Controllers\Controller::getCurrencyList() as $currency_info)
                                    <li><a onclick="onSelectCurrency('{{ $currency_info['id'] }}', '{{ $currency_info['currency'] }}', '{{ $currency_info['price_decimals'] }}')" href="#">{{ $currency_info['currency'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a><span class="text-info" id="top_price">0</span></a></li>
                        <li><a><span class="text-info">0</span></a></li>
                        <li><a><i class="fab fa-btc"></i>0</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end: Topbar -->

    @yield('content')
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>

<!--Toastr plugin files-->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('js/socket.io.js') }}"></script>

<!--Template functions-->
<script src="{{ asset('js/functions.js') }}"></script>

<script src="{{ asset('js/__common.js') }}"></script>

<!--Bootstrap switch files-->
<script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('plugins/range-slider/rangeslider.js') }}"></script>

<!--Datatables plugin files-->
<script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

<script src="{{ asset('plugins/charting_library/charting_library.min.js') }}"></script>
<script src="{{ asset('plugins/charting_library/datafeeds/udf/dist/datafeed.js') }}"></script>

<script>
    $(document).on("click", function(event){
        var $trigger = $("#lang_dropdown");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $("#lang_dropdown").removeClass("dropdown-active");
        }

        $trigger = $("#menu_dropdown");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $("#menu_dropdown").removeClass("dropdown-active");
        }

        $trigger = $("#symbol_dropdown");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $("#symbol_dropdown").removeClass("dropdown-active");
        }
    });
</script>
@yield('script')
</body>
</html>
