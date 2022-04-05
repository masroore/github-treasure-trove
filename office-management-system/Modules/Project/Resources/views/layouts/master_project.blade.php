@php
    $setting = app('general_setting');
@endphp
<!DOCTYPE html>
<html @if(Illuminate\Support\Facades\Cache::get('language') != null && Illuminate\Support\Facades\Cache::get('language')->rtl == 1) dir="rtl" class="rtl" @endif >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset($setting->favicon) }}"/>
   <title>{{$setting->site_title}} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @if (Illuminate\Support\Facades\Cache::get('language')->rtl == 1)
    <link rel="stylesheet" href="{{asset('public/backEnd/css/rtl/bootstrap.min.css')}}"/>
    @else
    <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/bootstrap.min.css')}}"/>
    @endif
    <style>
        :root {
            @foreach($color_theme->colors as $color)
            --{{ $color->name}}: {{ $color->pivot->value }};
                    @endforeach
            }
    </style>
    <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/jquery-ui.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/themify-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/flaticon.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/toastr.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/backEnd/vendors/css/nice-select.css') }}"/>
    <link rel="stylesheet" href="{{asset('public/frontend/vendors/font_awesome/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/font-awesome.min.css')}}"/>
    @stack('css_before')
    <link rel="stylesheet" href="{{ asset('public/css/parsley.css') }}"/>
    <link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}" />

    @if(Illuminate\Support\Facades\Cache::get('language')->rtl == 1)
    <link rel="stylesheet" href="{{asset('public/backEnd/css/rtl/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/css/rtl/infix.css')}}"/>
    @else
    <link rel="stylesheet" href="{{asset('public/backEnd/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/css/infix.css')}}"/>
    @endif


    @stack('css_after')
</head>

<body class="admin">

    <!-- Pm_blacnk_project_area::START  -->
    <div class="Pm_blank_project_area">
        <!-- Pm_blank_project_header  -->
        <div class="Pm_blank_project_header">
            <a class="back_icon" href="{{ url()->previous('dashboard') }}">
                <i class="ti-arrow-left"></i>
            </a>
            <a class="close_icon" href="{{ url()->previous('dashboard') }}">
                <i class="ti-close"></i>
            </a>
        </div>
        <!-- Pm_blank_project_content  -->
        <div class="Pm_blank_project_content">
         @section('content')

         @show
     </div>
 </div>
 <!-- Pm_blacnk_project_area::end  -->

 <script src="{{asset('public/backEnd/vendors/js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('public/backEnd/vendors/js/popper.js')}}"></script>
 <script src="{{asset('public/backEnd/vendors/js/bootstrap.min.js')}}"></script>
 <script src="{{asset('public/backEnd/vendors/js/jquery-ui.js')}}"></script>
 <script src="{{asset('public/backEnd/vendors/js/nice-select.min.js')}}"></script>
  <script src="{{ asset('public/js/parsley.min.js') }}"></script>


 @stack('js_before')
 <script src="{{asset('public/backEnd/js/custom.js')}}"></script>
 <script src="{{asset('public/backEnd/js/search.js')}}"></script>
 <script src="{{asset('public/backEnd/vendors/js/toastr.min.js')}}"></script>


 @stack('js_after')

</body>

</html>
