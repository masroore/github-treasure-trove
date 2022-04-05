<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')

</head>

<body>

    <div class="super_container">

        <!-- Header -->

        <header class="header" style="background-color:black">

            <!-- Top Bar -->

            {{-- @include('includes.topbar') --}}


            <!-- Header Main -->

            <!-- Main Navigation -->

            @include('includes.nav')

        </header>
        <!-- Banner -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block pb-0 mb-0">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong class="text-dark mb-4">{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block pb-0 mb-0">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong class="text-dark mb-4">{{ $message }}</strong>
            </div>
        @endif

        <style>
            .vote {
                transition-property: background-color;
                transition-duration: 2s;
            }
       
            .vote:hover {
                background-color: rgb(228, 157, 235);
            }

            .voted{
                background-color: #F8A11C;
            }

       
        </style>
        @yield('page-content')

        <!-- Footer -->
        @include('includes.footer')

    </div>
    @include('includes.scripts')

</body>

</html>
