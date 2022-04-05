@extends('layouts.dashboard')

{{-- vendor css --}}
@push('vendor_css')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/charts/apexcharts.css')}}">
--}}
<link rel="stylesheet" type="text/css"
    href="{{asset('assets/app-assets/vendors/css/extensions/tether-theme-arrows.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/tether.min.css')}}">
<link rel="stylesheet" type="text/css"
    href="{{asset('assets/app-assets/vendors/css/extensions/shepherd-theme-default.css')}}">
@endpush

{{-- page css --}}
@push('page_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/pages/dashboard-analytics.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/pages/card-analytics.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/apexcharts/apexcharts.css')}}">
<style>
    .carrusel_rango::after {
        background: transparent;
        height: 100%;
        width: 100%;
        position: absolute;
        z-index: 1;
        content: '';

    }

    .text-center.slick-slide.slick-current.slick-active.slick-center {
        background: rgba(54,99,112,1)
        padding: 10px;
    }

</style>
@endpush

{{-- page vendor js --}}
@push('page_vendor_js')
{{-- <script src="{{asset('assets/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script> --}}
<script src="{{asset('assets/app-assets/vendors/js/extensions/tether.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/shepherd.min.js')}}"></script>
@endpush

{{-- page js --}}
@push('page_js')
{{-- <script src="{{asset('assets/app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script> --}}
{{-- <script src="{{asset('assets/app-assets/js/scripts/cards/card-statistics.js')}}"></script> --}}
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
@endpush

{{-- custom js --}}
@push('custom_js')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{asset('assets/js/dashboard.js')}}"></script>
<script>
   $(document).ready(function () {
    let idrango = parseInt($('#idrango').val())
  console.log(idrango);
  $('.carrusel_rango').slick({
          infinite: true,
          centerMode: true,
          centerPadding: '80px',
          variableWidth: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          touchMove: false,
          initialSlide: (idrango),
          accessibility: false,
          arrows: false,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
              }
            },
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
        });
})
</script>
@endpush

@section('content')
@if (Auth::user()->admin == 1)

@include('dashboard.componente.index-admin')

@else

@include('dashboard.componente.index-user')

{{-- Primera Seccion --}}
{{-- @include('dashboard.componente.adminsection') --}}
{{-- Fin Primera Seccion --}}
{{-- @else --}}
{{-- Primera Seccion --}}
{{-- @include('dashboard.componente.firstsection') --}}
{{-- Fin Primera Seccion --}}
{{-- Segundo Seccion --}}
{{-- @include('dashboard.componente.secondsection') --}}
{{-- Fin Segundo Seccion --}}
{{-- Tercera Seccion --}}
{{-- @include('dashboard.componente.thirdsection') --}}
{{-- Fin Tercera Seccion --}}
@endif

{{-- link de referido --}}
@include('layouts.componenteDashboard.linkReferido')
{{--Modal retirar saldo disponible--}}
@include('layouts.componenteDashboard.modalRetirar')
@endsection
