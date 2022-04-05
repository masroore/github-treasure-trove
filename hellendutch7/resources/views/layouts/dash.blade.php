<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    @include('layouts.partials.meta')

    @yield('addstyles')

    @livewireStyles

    @include('layouts.partials.css')

</head>
@section('title', 'Dashboard')

@section('content')


<body class="font-sans antialiased">
    @include('layouts.partials.nav')
    @include('layouts.partials.pageheader')

    <div id="app">

{{ $slot }}
    </div>

    @livewireScripts

</body>

@include('layouts.partials.scripts')

</html>