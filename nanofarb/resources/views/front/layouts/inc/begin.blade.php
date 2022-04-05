<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="180x180" href="/its-client/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/its-client/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/its-client/img/favicon-16x16.png">
    <link rel="manifest" href="/its-client/img/site.webmanifest">
    <link rel="mask-icon" href="/its-client/img/safari-pinned-tab.svg" color="#f75b5b">
    <meta name="msapplication-TileColor" content="#f75b5b">
    <meta name="theme-color" content="#f75b5b">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! variable('front_code_in_head', '') !!}
    {!! MetaTag::setPath(\Fomvasss\UrlAliases\Facades\UrlAlias::current(false))->render() !!}

    <!-- Styles application -->
    <link rel="stylesheet" href="{{ asset('its-client/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('its-client/css/style.css') }}?v=1908202012">
    <link rel="stylesheet" href="{{ asset('its-client/css/custom.css') }}">
    @stack('styles')
</head>
<body @isset($bodyAttrs) {!! $bodyAttrs  !!} @endisset>
<div class="loader" style="display: none;">
    <div class="loader__wrapper">
        <div class="load">
            <hr/><hr/><hr/><hr/>
        </div>
    </div>
</div>
{!! variable('front_code_start_body', '') !!}