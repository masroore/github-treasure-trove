<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | 961Freelancer - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="961Freelancer - Admin Dashboard" name="description" />
        <meta content="Zeeshan" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('admin-assets/assets/images/favicon.ico')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
            .btn-success {
                color: #fff;
                background-color: #00a651;
                border-color: #00a651;
            }
            body[data-sidebar=dark] .menu-title {
                color: #ffffff;
            }
            body[data-sidebar=dark] #sidebar-menu ul li a {
                color: #02a350;
            }
            body[data-sidebar=dark] #sidebar-menu ul li a i {
                color: #00a651;
            }
            body[data-sidebar=dark] #sidebar-menu ul li ul.sub-menu li a {
                color: #00a651;
            }
            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #ed1c24;
                border-color: #ed1c24;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                color: white !important;
                border: 1px solid #00a651;
                background-color: #585858;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111));
                background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
                background: -moz-linear-gradient(top, #585858 0%, #111 100%);
                background: -ms-linear-gradient(top, #585858 0%, #111 100%);
                background: -o-linear-gradient(top, #585858 0%, #111 100%);
                background: linear-gradient(to bottom, #03a450 0%, #00a651 100%);
            }

        </style>
    </head>

    @section('body')
    @show
    <body data-sidebar="dark">
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
          <!-- Begin page -->
          <div id="layout-wrapper">
            @include('admin.layouts.topbar')
            @include('admin.layouts.sidebar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
            </div>
            <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @include('admin.layouts.footer-script')
    </body>
</html>