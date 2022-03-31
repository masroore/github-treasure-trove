<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>LOGIN</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/font-awesome.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/metisMenu/dist/metisMenu.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/animate.css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.css')}}" />

    <!-- App styles -->
    <link rel="stylesheet" href="{{asset('fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" />
    <link rel="stylesheet" href="{{asset('fonts/pe-icon-7-stroke/css/helper.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/style.css')}}">

</head>
<body class="blank">
    @yield('content')
<!-- Vendor scripts -->
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('vendor/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/metisMenu/dist/metisMenu.min.js')}}"></script>
<script src="{{asset('vendor/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('vendor/sparkline/index.js')}}"></script>

<!-- App scripts -->
<script src="{{asset('scripts/homer.js')}}"></script>

</body>
</html>
