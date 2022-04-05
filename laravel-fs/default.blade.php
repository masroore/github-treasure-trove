<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>

        <!-- CSS only -->
        <link rel="stylesheet" href="{{ asset('css/boostrap_css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/datatables/datatables.min.css') }}"  type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/select2/select2.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/sweetalert2/sweetalert2.min.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}" type="text/css" >
        <link rel="stylesheet" href="{{ asset('css/datepicker/bootstrap-datepicker.css') }}" type="text/css">



        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/formValidate/jquery.validate.min.js') }}"></script>

        <!-- JavaScript Bundle with Popper -->
        <script src="{{ asset('js/boostrap/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('js/select2/dist/js/select2.js') }}"></script>
        <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>  
        <script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>    

        <script src="{{ asset('js/fontAwesome/all.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <title>{{config('app.name')}}</title>
    </head>
    <body>


        @yield('content')


    </div>
</body>
</html>