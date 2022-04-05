 <title> {{ env('APP_NAME') }} » @yield('page-name')</title>
 <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.jpg') }}">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="description" content="Revolt Music Awards">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/bootstrap4/bootstrap.min.css') }}">
 <link href="{{ asset('assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}" rel="stylesheet"
     type="text/css">
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/animate.css') }}">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>

 @if (Route::currentRouteName() === 'welcome' || Route::currentRouteName() === 'group' || Route::currentRouteName() === 'profile' || Route::currentRouteName() === 'dashboard' || Route::currentRouteName() === 'chart')
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/slick-1.8.0/slick.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/main_styles.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/responsive.css') }}">
     @if (Route::currentRouteName() === 'dashboard' || Route::currentRouteName() === 'chart')
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
         <!-- Charting library -->
         <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
         <!-- Chartisan -->
         <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>

         {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
             integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
             crossorigin="anonymous">
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
             integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
             crossorigin="anonymous"></script> --}}
     @endif
 @endif

 @if (Route::currentRouteName() === 'detail')
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/product_styles.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/product_responsive.css') }}">
 @endif
 {{-- @if (Route::currentRouteName() === 'contact' || Route::currentRouteName() === 'account' || Route::currentRouteName() === 'about')
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/contact_styles.css') }}">
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/contact_responsive.css') }}">
 @endif --}}

 @php
     $userid = Auth::user() ? Auth::user()->id : '';
 @endphp
 <script>
     var APP_URL = "{{ config('app.url') }}";
     const CREATEUSER = "{!! $userid !!}";

 </script>
