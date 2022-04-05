<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
@yield('stylesheet')
<!--    head files   -->
    @include('partials._head')

</head>

<body>
<div id="page-contianer">
    <!--    header component   -->
    <x-header></x-header>
    <main id="main-content">
        <!-- feature post component -->
        @if (Request::is('/'))
            <x-featured/>
        @endif


        <section class="Contents py-5">
            <div class="container">
                @yield('content')


            </div>
        </section>
    </main>

</div>
<!--    all scripts   -->
@include('partials._scripts')

@yield('scripts')

</body>

</html>
