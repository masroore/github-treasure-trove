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
            <x-featured />
            @endif

            <section class="Contents">
                <div class="container d_flex">
                    <div class="innerContainer row">

                        @yield('content')

                    </div>
                    <!--    side bar component   -->
                    <x-sidebar />
                </div>
            </section>
        </main>

        <!--    footer section   -->
        @include('partials._footer')
    </div>
    <!--    all scripts   -->
    @include('partials._scripts')

    @yield('scripts')

</body>

</html>
