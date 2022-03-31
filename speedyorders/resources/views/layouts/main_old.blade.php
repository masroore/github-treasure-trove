<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="app-url" content="{{ asset('/') }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Page title -->
    <title>TECOMMERCE</title>

    <!-- Place favicon.ico and ap ple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{asset('vendor/metisMenu/dist/metisMenu.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/animate.css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/themes/base/all.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/select2/dist/css/select2.min.css')}}" />

    <!-- App styles -->
    <link rel="stylesheet" href="{{asset('fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" />
    <link rel="stylesheet" href="{{asset('fonts/pe-icon-7-stroke/css/helper.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/style.css')}}">
    <link rel="stylesheet" href="{{ asset('styles/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('vendor/datatables/media/css/dataTables.bootstrap.css')}}">
    <style type="text/css">
    #productTable_previous {
        border: 1px solid gray;
        padding: 10px;
    } #productTable_next {
        border: 1px solid gray;
        padding: 10px;
    }
    a.paginate_button {
        border: 1px solid gray;
        padding: 10px;
    }
    a.paginate_button.current {
        background: #2588ca;
    }
</style>
    @yield('ext_css')
</head>
<body class="fixed-navbar sidebar-scroll">

@include('commons.header')

@include('commons.sidebar')

<!-- Main Wrapper -->
<div id="wrapper">
    @if( isset($breadcrumb) )
        <div class="normalheader" style="padding: 0px 24px 0 0px;">
            <div class="hpanel">
                <div class="panel-body" style="background: none;border: none;padding: 20px 20px 0px 0px;">

                    <div id="hbreadcrumb" class="pull-right">
                        <ol class="hbreadcrumb breadcrumb" style="background-color: #f1f3f6!important;">
                            <li class="text-bold"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            {!! $breadcrumb ?? null !!}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="content">
        @include('commons.flash')
        @yield('content')
    </div>

    <br>
    {{-- @include('commons.footer') --}}
</div>

<!-- Vendor scripts -->
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('vendor/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/jquery-flot/jquery.flot.js')}}"></script>
<script src="{{asset('vendor/jquery-flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('vendor/jquery-flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('vendor/flot.curvedlines/curvedLines.js')}}"></script>
<script src="{{asset('vendor/jquery.flot.spline/index.js')}}"></script>
<script src="{{asset('vendor/metisMenu/dist/metisMenu.min.js')}}"></script>
<script src="{{asset('vendor/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('vendor/peity/jquery.peity.min.js')}}"></script>
<script src="{{asset('vendor/sparkline/index.js')}}"></script>
<script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>

<!-- App scripts -->
<script src="{{asset('scripts/homer.js')}}"></script>
{{-- <script src="{{asset('scripts/charts.js')}}"></script> --}}
<script src="{{asset('scripts/newchart.js')}}"></script>
<script src="{{asset('scripts/jquery.validate.min.js')}}"></script>
<script src="{{asset('scripts/additional-methods.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script>
     $(document).ready(function(){
        $(".js-dropdown-select2").select2({
            
        });
    });
</script>
@yield('ext_js')
</body>
</html>
