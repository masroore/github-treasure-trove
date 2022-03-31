<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | 961Freelancer - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="961Freelancer - Admin Dashboarde" name="description" />
        <meta content="Zeeshan" name="author" />
        <!-- App favicon -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @include('admin.layouts.head')
        <style>
            .btn-primary{
                background-color: #ed1c24;
                border-color: #ed1c24;
                border-radius: 35px;
            }
            .btn-primary:hover {
                color: #fff;
                background-color: #00a651;
                border-color: #00a651;
            }
        </style>
  </head>

    @yield('body')
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    @yield('content')

    @include('admin.layouts.footer-script')
    </body>
</html>