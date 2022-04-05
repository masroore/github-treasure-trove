
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

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/jquery-ui.css')}}"/>

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/jquery.data-tables.css')}}">
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/rowReorder.dataTables.min.css/')}}">
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/responsive.dataTables.min.css')}}">

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/bootstrap-datepicker.min.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/bootstrap-datetimepicker.min.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/daterangepicker.css')}}">


<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/themify-icons.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/flaticon.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/font-awesome.min.css')}}"/>
<link rel="stylesheet" href="{{asset('public/frontend/vendors/font_awesome/css/all.min.css')}}" />

<link rel="stylesheet" href="{{asset('public/frontend/vendors/text_editor/summernote-bs4.css')}}" />

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/magnific-popup.css')}}"/>

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/toastr.min.css')}}"/>

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/fastselect.min.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/js/select2/select2.css')}}"/>
<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/nice-select.css')}}"/>

<link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/vendors/calender_js/core/main.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/vendors/calender_js/daygrid/main.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/vendors/calender_js/timegrid/main.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/vendors/calender_js/list/main.css/')}}">

  <link rel="stylesheet" href="{{ asset('public/css/parsley.css') }}" />
<!-- color picker  -->
<link rel="stylesheet" href="{{asset('public/frontend/vendors/color_picker/colorpicker.min.css/')}}">


<!-- metis menu  -->
<link rel="stylesheet" href="{{asset('public/frontend/css/metisMenu.css/')}}">

@stack('styles')


@if(Illuminate\Support\Facades\Cache::get('language')->rtl == 1)
    <link rel="stylesheet" href="{{asset('public/backEnd/css/rtl/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/css/rtl/infix.css')}}"/>
@else
    <link rel="stylesheet" href="{{asset('public/backEnd/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/css/infix.css')}}"/>
@endif

<link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}" />

@if($setting->default_view == 'compact')
    <link rel="stylesheet" href="{{asset('public/frontend/css/themes/default_compact.css')}}" />
@endif

<link rel="stylesheet" href="{{asset('public/css/app.css')}}" />


@stack('css')
