<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="icon" href="{{url('/')}}/{{isset($fav)?$fav:''}}" type="image/png"/>
    <title>Admin </title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    @include('backEnd.partials.style')
</head>
@php
    $setting = app('general_setting');
@endphp
<body class="admin">
<div class="preloader">
    <h3 data-text="infix..">infix..</h3>
</div>

<div class="main-wrapper" style="min-height: 600px">

 <div id="main-content" class="mini_main_content">
<!-- Page Content  -->
<!-- application baseUrlForJS  -->
<input name="app_base_url" id="app_base_url" type="hidden" value="{{ url('/') }}">

@include('backEnd.partials.menu')
