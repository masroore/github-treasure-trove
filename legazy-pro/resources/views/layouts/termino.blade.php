
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    @if(!$config->getMedia('icon')->isEmpty())
    <link rel="shortcut icon" href="{{ $config->getMedia('icon')->first()->getUrl() }}" type="image/x-icon">
    @else
    <link rel="shortcut icon" href="{{ asset('assets/img/sistema/favicon.png') }}" type="image/x-icon">
    @endif

    <title>{{$config->title}}</title>
    @include('layouts.componenteAuth.styles')
    
</head>
    
<body
    class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>

    @include('layouts.componenteAuth.scripts')
</body>

</html>
