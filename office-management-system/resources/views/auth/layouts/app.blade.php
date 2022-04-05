@php
    $bg_image = 'public/backEnd/img/login-bg.png';
   if (app()->bound('general_setting')){
       $setting = app('general_setting');
       $bg_image = $setting->login_bg;
   }
@endphp
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset(@$favicon)}}" type="image/png"/>
    <title>{{ isset($title) ? $title .' | '. config('app.name') :  config('app.name') }}</title>
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/themify-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/toastr.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/nice-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/css/style.css')}}"/>

    <style>
        .nice-select {
            background-color: transparent;
            border-bottom: 1px solid rgba(247, 247, 255, 0.2) !important;
        }
        .nice-select .current{
            color: #828bb2;
        }

        .nice-select::after {
            color:#828bb2;
        }
        .nice-select.open .list {
            max-height: 400px;
            overflow: auto;
        }
        .nice-select .list {
            width: 100%;
            background-color: #fff;
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            box-shadow: 0px 10px 20px rgba(108, 39, 255, 0.3);
        }
        .nice-select .list li {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus {
            background-color: #f6f6f6;
        }
        .nice-select .list li:first-child {
            color: #7c32ff;
        }


        .nice-select .option.disabled {
            background-color: transparent;
            color: #999;
            cursor: default;
            font-size: 13px;
            text-transform: capitalize;
            border-bottom: 0;
            margin: 0;
            cursor: pointer;
            font-weight: 400;
            line-height: 40px;
            list-style: none;
            min-height: 40px;
            outline: none;
            padding-left: 18px;
            padding-right: 29px;
            text-align: left;
            -webkit-transition: all 0.2s;
            transition: all 0.2s;
        }
        .select_group_padding{
            padding-left: 15px !important;
        }
    </style>

</head>
<body  style="background: url({{asset($bg_image)}})  no-repeat center; background-size: cover; ">

    @yield('content')
    <script src="{{asset('public/backEnd/vendors/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/js/popper.js')}}"></script>
	<script src="{{asset('public/backEnd/vendors/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/js/nice-select.min.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/js/toastr.min.js')}}"></script>
	<script src="{{asset('public/backEnd/js/login.js')}}"></script>

    {!! Toastr::message() !!}
</body>
</html>
