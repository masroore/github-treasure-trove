<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('assets/img/royal_green/logos/favicon_royal.png') }}" type="image/x-icon">

    <title>Royal Life</title>
    {{-- Styles --}}
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    @include('layouts.componenteDashboard.styles')
    {{-- Fin Styles --}}
</head>

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  text-white" style="background:#E5E5E5" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">
    {{-- Notificaciones del sistema --}}
    @include('.layouts.componenteDashboard.messageSystem')
    {{-- Notificaciones del sistema --}}
    {{-- Header --}}
    @include('backofice.layouts.componenteDashboard.header')
    {{-- Fin Header --}}
    {{-- Sidebar
    @include('layouts.componenteDashboard.sidebar') --}}
    {{-- Fin Sidebar --}}
    {{-- Cuerpo --}}
    <!-- BEGIN: Content-->
    <div class="" style="background: #ffffff;">
        <div class=""></div>
        <div class="" style="background: #ffffff;"></div>
        <div class="" style="background: #ffffff;">
            <div class="">
                {{-- Migaja de pan --}}
                @if (!empty($titleg))
                @include('layouts.componenteDashboard.breadcrumb')
                @endif
                {{-- Fin Migaja de pan --}}
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    {{-- Fin Cuerpo --}}
 {{-- footer Sidebar --}}
 @include('backofice.layouts.componenteDashboard.footer')
 {{-- Fin footer --}}
    {{-- formulario de salir --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

        {{-- Scritps --}}
        @routes
        @include('layouts.componenteDashboard.scripts')
        {{-- Fin Scripts --}}
</body>

</html>
