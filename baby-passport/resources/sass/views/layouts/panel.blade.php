<!DOCTYPE html>
<html lang="es-MX">
<head>


    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="icon" href="{{asset('img/miscellaneous/fav.jpg')}}" type="image/x-icon"/>
@yield('title')
<!-- CRITICAL CSS -->
    <style>
        @font-face {
            font-family: "Campton";
            font-display: auto;
            src: url({{asset('fonts/Campton-SemiBold.otf')}});
        }

        @font-face {
            font-family: "Roboto";
            font-display: auto;
            src: url({{asset('fonts/Roboto-Regular.ttf')}});
        }

        body {
            font-family: "Roboto", Arial, Helvetica, sans-serif !important;
        }

        body h1,
        body h2,
        body h3,
        body h4,
        body h5 {
            font-family: "Campton", Arial, Helvetica, sans-serif;
        }


    </style>

    <!-- END CRITICAL CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>

    <link rel="stylesheet" href="{{asset(mix('/css/panel/panel.css'))}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('custom_styles')

</head>
<body>


@include('_partials/navbar_panel')

<div class="container-fluid px-0 mt-5">
    @yield('content')
</div>


<a id="DATA" data-url="{{URL::to('/')}}"></a>

<script src="{{asset(mix('/js/panel/panel.js'))}}"></script>


@yield('custom_scripts')
</body>
</html>
