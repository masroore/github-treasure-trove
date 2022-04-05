<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') &mdash; {{ config('app.name') }}</title>
  <!-- Favicon -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/png">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/modules/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/css/modules/selectric.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/social.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <!-- CSRF token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @livewireStyles
  @yield('css')
</head>

<body>
  <div id="app">
    @yield('content')
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/modules/pooper.min.js') }}"></script>
  <script src="{{ asset('assets/js/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/modules/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/js/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('assets/js/modules/pwstrength.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  @yield('js')
  @livewireScripts
</body>

</html>