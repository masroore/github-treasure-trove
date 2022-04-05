@php
    $bg_image = 'public/backEnd/img/login-bg.png';
   if (app()->bound('general_setting')){
       $setting = app('general_setting');
       $bg_image = $setting->login_bg;
   }
@endphp
<!doctype html>
@php
    Illuminate\Support\Facades\Cache::remember('language', 3600 , function() {
        return Modules\Localization\Entities\Language::where('code', session()->get('locale', Config::get('app.locale')))->first();
    });
@endphp
<html @if(Illuminate\Support\Facades\Cache::get('language')->rtl == 1) dir="rtl" class="rtl" @endif >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <link rel="icon" href="{{ asset('public/uploads/settings/favicon.png')}}" type="image/png"/>
    <title>{{ isset($title) ? $title .' | '. $setting->site_title : $setting->site_title }}</title>
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
    </style>
    <!-- <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/bootstrap.min.css')}}"/> -->
    <link rel="stylesheet" href="{{asset('public/login-asset/css/style.css')}}"/>
    <link rel="stylesheet" href="{{ asset('public/login-asset/css/login.css') }}">
    <link rel="stylesheet" href="{{asset('public/backEnd/vendors/css/toastr.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
    <style>

        .login-registration-area .main-login-area.login-res-v2::before {
            background-image: url({{ asset($bg_image) }})
        }
        .login-registration-area .main-login-area .main-content .media-link {
            float: left;
        }


    </style>

    @stack('css')

</head>


<body class="login-registration-area">
<!-- main-login-area-start -->
<div class="main-login-area login-res-v2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-xl-7 offset-xl-5">
                <div class="main-content">
                    <div class="logo_img">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset( $setting->logo ) }}" alt="Logo Image" class="img img-responsive">
                        </a>
                    </div>

                @yield('content')

                </div>

            </div>
        </div>
    </div>
</div>
<script src="{{asset('public/backEnd/vendors/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('public/js/parsley.min.js') }}"></script>
<script src="{{ asset('public/backEnd/vendors/js/toastr.min.js')}}"></script>

<script>
    // submit btn protect


        function ajax_error(data) {
            "use strict";
            if (data.status === 404) {
                toastr.error("What you are looking is not found", 'Opps!');
                return;
            } else if (data.status === 500) {
                toastr.error('Something went wrong. If you are seeing this message multiple times, please contact Spondon IT authors.', 'Opps');
                return;
            } else if (data.status === 200) {
                toastr.error('Something is not right', 'Error');
                return;
            }
            let jsonValue = $.parseJSON(data.responseText);
            let errors = jsonValue.errors;
            if (errors) {
                let i = 0;
                $.each(errors, function(key, value) {
                    let first_item = Object.keys(errors)[i];
                    let error_el_id = $('#' + first_item);
                    if (error_el_id.length > 0) {
                        error_el_id.parsley().addError('ajax', {
                            message: value,
                            updateClass: true
                        });
                    }

                    toastr.error(value, 'Validation Error');
                    i++;
                });
            } else {
                toastr.error(jsonValue.message, 'Opps!');
            }
        }
        function _formValidation(form_id = 'content_form', modal = false, modal_id = 'content_modal', ajax_table = null) {

            const form = $('#' + form_id);

            if (!form.length) {
                return;
            }

            form.parsley().on('field:validated', function() {
                $('.parsley-ajax').remove();
                const ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
            form.on('submit', function(e) {
                e.preventDefault();
                $('.parsley-ajax').remove();
                form.find('.submit').hide();
                form.find('.submitting').show();
                const submit_url = form.attr('action');
                const method = form.attr('method');
                //Start Ajax
                const formData = new FormData(form[0]);
                $.ajax({
                    url: submit_url,
                    type: method,
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        form.trigger("reset");
                        form.find("input:text:visible:first").focus();
                        toastr.success(data.message, 'Succes');
                        if (modal) {
                            $("." + modal_id).modal('hide');
                        }
                        if (ajax_table) {
                            ajax_table.ajax.reload();
                        }

                        if (data.goto) {
                            window.location.href = data.goto;
                        }

                        form.find('.submit').show();
                        form.find('.submitting').hide();

                    },
                    error: function(data) {
                        ajax_error(data);
                        form.find('.submit').show();
                        form.find('.submitting').hide();
                    }
                });
            });
        }
    $(document).ready(function () {
        _formValidation();
    });

</script>

@stack('js')
</body>
</html>
