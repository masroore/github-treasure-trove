<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | Admin &mdash; {{ setting()->get('app_name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/png">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/modules/font-awesome.css') }}">
    @livewireStyles
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/modules/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- CSS Libraries -->
    @yield('css')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg" style="background-color: #191d21"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                @include('admin.partials.topnav')
            </nav>
            @include('admin.partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
                @include('cookieConsent::index')
            </div>c
            <footer class="main-footer">
                @include('admin.partials.footer')
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/pooper.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/modules/sweetalert.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/modules/notyf.min.js') }}"></script>
    @yield('js')
    @livewireScripts
    @stack('scripts')
    <!-- Notyf -->
    <script src="{{ asset('assets/js/modules/notyf-init.js') }}"></script>
    @stack('notyf')
</body>

</html>
