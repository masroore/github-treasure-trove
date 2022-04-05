<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('maintenance.title') }} - {{ config('app.name', 'ADAM Bit') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
<!-- Body Inner -->
<div class="body-inner dark">
    <section class="fullscreen text-center">
        <div class="container container-fullscreen">
            <div class="text-middle text-center">
                <i class="fa fa-exclamation-triangle fa-5x" style="color: #ffd530;"></i>
                <h1 class="text-uppercase text-lg">{{ trans('maintenance.title') }}</h1>
                <p class="lead">{!! $content !!}</p>
            </div>
        </div>
    </section>
</div> <!-- end: Body Inner -->
<!-- Scroll top -->
<a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
<!--Plugins-->
<script src="js/jquery.js"></script>
<script src="js/plugins.js"></script>
<!--Template functions-->
<script src="js/functions.js"></script>
</body>

</html>