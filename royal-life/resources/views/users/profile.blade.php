@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/core/colors/palette-gradient.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dashboard/colors.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script>
@endpush

@push('custom_js')
<script>


$(document).ready(function() {
          @if($user->photoDB != NULL)
                previewPersistedFile("{{asset('storage/photo/'.$user->photoDB)}}", 'photo_preview');
          @endif
        });
   


    function previewFile(input, preview_id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#" + preview_id).attr('src', e.target.result);
                $("#" + preview_id).css('height', '300px');
                $("#" + preview_id).parent().parent().removeClass('d-none');
            }
            $("label[for='" + $(input).attr('id') + "']").text(input.files[0].name);
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPersistedFile(url, preview_id) {
        $("#" + preview_id).attr('src', url);
        $("#" + preview_id).css('height', '300px');
        $("#" + preview_id).parent().parent().removeClass('d-none');

    }

</script>

<script src="{{asset('assets/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/app-assets/js/core/app.js')}}"></script>
<script src="{{asset('assets/app-assets/js/scripts/components.js')}}"></script>
@endpush

@section('content')

<div class="app-content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow" style="background: #11262C;"></div>

    <div class="content-body">
        <!-- account setting page start -->
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                        <li class="nav-item">
                            <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill"
                                href="#account-vertical-general" aria-expanded="true">
                                <i class="feather icon-user mr-50 font-medium-3"></i>
                                Datos personales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex py-75" id="account-pill-pass" data-toggle="pill"
                                href="#account-vertical-pass" aria-expanded="false">
                                <i class="feather icon-lock mr-50 font-medium-3"></i>
                                Cambiar la contraseña
                            </a>
                        </li>-->
  {{--                         <li class="nav-item">
                            <a class="nav-link d-flex py-75"
                                href="{{ route('kyc') }}">
                                <i class="feather icon-file-text mr-50 font-medium-3"></i>
                                Verificar KYC
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a class="nav-link d-flex py-75"
                                href="{{ route('profile.change-password')}}">
                                <i class="feather icon-lock mr-50 font-medium-3"></i>
                                Cambiar la contraseña
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link d-flex py-75" id="account-pill-social" data-toggle="pill"
                                href="#account-vertical-social" aria-expanded="false">
                                <i class="feather icon-link mr-50 font-medium-3"></i>
                                Tu clave API
                            </a>
                        </li> --}}
                    </ul>
                </div>
 
                <!-- right content section -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body" style="background: #11262C;">
                                <div class="tab-content">
                                    
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                        aria-labelledby="account-pill-general" aria-expanded="true">

                                        @include('users.componenteProfile.edit-profile')

                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="account-vertical-pass"
                                        aria-labelledby="account-pill-pass" aria-expanded="false">

                                        @include('users.componenteProfile.changePassword')

                                    </div>

                         

                                </div>

                              {{-- <div class="tab-pane fade " id="account-vertical-social" role="tabpanel"
                                    aria-labelledby="account-pill-social" aria-expanded="false">

                                    @include('users.componenteProfile.api-profile')
                                   
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
@endsection
