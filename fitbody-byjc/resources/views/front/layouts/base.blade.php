<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="AG media" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title -->
    <title>{{ $appinfo->long_name }}</title>
    <meta name="description" content="{{ $appinfo->long_name }}" />

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/base.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('front/css/cookie.css') }}" type="text/css" />
    @stack('css')
    <!-- favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/images/favicon-16x16.png') }}">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#ffffff">

    <!-- og:graph -->
    @yield('og')

</head>

<body class="stretched sticky-responsive-menu side-panel-left no-transition "{{-- data-loader="2" data-animation-in="fadeIn" data-speed-in="1800" data-animation-out="fadeOut" data-speed-out="900"--}}>
<div class="body-overlay"></div>
@include('front.layouts.partials.sidenav')

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    @include('front.layouts.partials.topbar')

    @include('front.layouts.partials.navbar')

    @yield('content')

    @include('front.layouts.partials.footer')

</div>

<!-- Go To Top -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts -->
<script src="{{ asset('front/js/base.js') }}"></script>
@stack('js')
<script src="{{ asset('front/js/jquery.ihavecookies.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('body').ihavecookies({

            delay: 600,
            expires: 90,

            onAccept: function(){
                var myPreferences = $.fn.ihavecookies.cookie();

            },
            uncheckBoxes: false
        });

    });
</script>
</body>
</html>
