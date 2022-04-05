@php
    $bg_image = 'public/backEnd/img/login-bg.jpg';
   if (app()->bound('general_setting')){
       $setting = app('general_setting');
       $bg_image = $setting->error_page_bg;
   }
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap.css"/>
    <style>
        :root {
            --base_color : #415094;
            --gradient_1 : #7c32ff;
            --gradient_2 : #A235EC;
            --gradient_3 : #c738d8;
            --scroll_color : #7e7172;
            --text : #828bb2;
            --text_white : #ffffff;
            --bg_white : #ffffff;
            --text_black : #000000;
            --bg_black : #000000;
            --border_color : #ECEEF4;
            --input__bg : #ffffff;
            --success : #4BCF90;
            --warning : #E09079;
            --danger : #FF6D68;
}
    </style>
    <link rel="stylesheet" href="{{ asset('public/') }}/css/error.css">
    <link rel="stylesheet" href="{{asset('public/backEnd/css/style.css')}}" />

    <title>
        @yield('code') | @yield('title')
    </title>

    <style>
        body {
            background: url({{ asset($bg_image) }});
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="antialiased font-sans">

<div class="md:flex min-h-screen">
    <div class="w-full md:w-1/2   flex items-center justify-center">
        @yield('content')

    </div>


</div>
</body>

</html>
