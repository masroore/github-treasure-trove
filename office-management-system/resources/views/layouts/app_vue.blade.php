@php
    $setting = app('general_setting');

Illuminate\Support\Facades\Cache::remember('language', 3600 , function() {
    return Modules\Localization\Entities\Language::where('code', session()->get('locale', Config::get('app.locale')))->first();
});
@endphp
<!DOCTYPE html>
<html @if(Illuminate\Support\Facades\Cache::get('language') != null && Illuminate\Support\Facades\Cache::get('language')->rtl == 1) dir="rtl" class="rtl" @endif >

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="shortcut icon" href="{{ asset($setting->favicon) }}"/>
    <meta name="url" content="{{ url('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$setting->site_title}} </title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    @include('backEnd.partials.style')
</head>
@php
    if (empty($color_theme)) {
     $css = "background: url('".asset('/public/backEnd/img/body-bg.jpg')."')  no-repeat center; background-size: cover; ";
 } else {
     if (!empty($color_theme->background_type == 'image')) {
         $css = "background: url('" . url($color_theme->background_image) . "')  no-repeat center; background-size: cover; background-attachment: fixed; background-position: top; ";
     } else {
         $css = "background:" . $color_theme->background_color;
     }
 }

@endphp
<body class="admin pm_body" style="{!! $css !!} ">
<div class="preloader">
    <h3 data-text="{{ $setting->preloader }}..">{{ $setting->preloader }}..</h3>
</div>

<div class="main-wrapper" style="min-height: 600px">
    <!-- Sidebar  -->.
     @php
        if (file_exists($setting->logo)) {
            $tt = file_get_contents(url('/').'/'.$setting->logo);
        } else {
            $tt = file_get_contents(url('/').'/uploads/settings/logo.png');
        }
    @endphp
     <input type="text" hidden value="{{ base64_encode($tt) }}" id="logo_img">
    @if (!request()->is('pos/pos-order-products'))
        @include('backEnd.partials.sidebar')
    @endif
    <div id="main-content" class="{{Request::is('pos/pos-order-products') ? 'mini_main_content' : ''}}">
        <!-- Page Content  -->
        <!-- application baseUrlForJS  -->
        <input name="app_base_url" id="app_base_url" type="hidden" value="{{ url('/') }}">

@include('backEnd.partials.menu')
<div class="header_iner infixbiz_subheader border_bottom_1px d-flex justify-content-between align-items-center" >
    <div class="pm_project_top__header">
        @section('header_content')

        @show
    </div>
</div>


@section('content')

@show


</div>
</div>

<div class="has-modal modal fade" id="showDetaildModal">
    <div class="modal-dialog modal-dialog-centered" id="modalSize">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="showDetaildModalTile">{{ __('common.New Client Information') }}</h4>
                <button type="button" class="close icons" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="showDetaildModalBody">

            </div>

            <!-- Modal footer -->

        </div>
    </div>
</div>


<!--  Start Modal Area -->
<div class="modal fade invoice-details" id="showDetaildModalInvoice">
    <div class="modal-dialog large-modal modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Add Invoice') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="showDetaildModalBodyInvoice">
            </div>

        </div>
    </div>
</div>


<!-- ================Footer Area ================= -->
<footer class="footer-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 text-center">
                <p> </p>
            </div>
        </div>
    </div>
</footer>
<!-- ================End Footer Area ================= -->

{!! Toastr::message() !!}
<script src="{{ asset('js/lang') }}"></script>
@stack('js_before')

@stack('js_after')

@stack('scripts')
<div class="modal fade animated team_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>

<div class="modal fade animated project_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>

<div class="modal fade animated invite_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>
</body>
</html>
