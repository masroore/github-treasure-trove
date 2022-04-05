@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/core/colors/palette-gradient.css')}}">
<link rel="stylesheet" type="text/css"
    href="{{asset('assets/app-assets/css/plugins/forms/validation/form-validation.css')}}">
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
          @if(Auth::user()->dni != NULL)
                previewPersistedFile("{{asset('storage/dni/'.Auth::user()->dni)}}", 'photo_preview');
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
    <div class="header-navbar-shadow"></div>

    <div class="content-body">
        <!-- account setting page start -->
        <section id="page-account-settings">
            <div class="row">

                <!-- right content section -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">

                                        <form action="{{ route('profile.update.kyc',Auth::user()->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h4 class="font-weight-bold">Billetera Electronica</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="account-api">Billetera</label>
                                                        <input type="text" id="account-api" class="form-control"
                                                            placeholder="wallet_address" name="wallet_address"
                                                            value="{{ Auth::user()->wallet_address }}">
                                                    </div>

                                                    <a href="https://accounts.binance.com/es/register" target="_blank"
                                                    class="waves-effect waves-light"> <b>¿No tiene billetera? Abre una cuenta en binance</b></a>

                                                </div>

                                                @if (Auth::user()->dni == NULL && Auth::user()->status == 0)

                                            

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h4 class="font-weight-bold">Subir DNI / Cedula para
                                                                activacion de la cuenta</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="media">
                                                        <div class="custom-file">
                                                            <label class="custom-file-label" for="dni">Seleccione su
                                                                Foto <b>(Se permiten JPG o PNG.
                                                                Tamaño máximo de 800kB)</b></label>
                                                            <input type="file" id="dni"
                                                                class="custom-file-input @error('dni') is-invalid @enderror"
                                                                name="dni" onchange="previewFile(this, 'photo_preview')"
                                                                accept="image/*">
                                                            @error('dni')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row mb-4 mt-4 d-none" id="photo_preview_wrapper">
                                                        <div class="col"></div>
                                                        <div class="col-auto">
                                                          <img id="photo_preview" class="img-fluid rounded" />
                                                        </div>
                                                        <div class="col"></div>
                                                    </div>

                                                </div>
                                                @elseif(Auth::user()->dni != NULL && Auth::user()->status == 1)

                                                <div class="col-12 mt-2 mb-2">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h2 class="text-center font-weight-bold text-primary">CUENTA ACTUALMENTE ACTIVA</h2>
                                                        </div>
                                                    </div>
                                                </div>

                                                @elseif (Auth::user()->dni !=NULL)

                                                <div class="col-12 mt-2 mb-2">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h2 class="text-center font-weight-bold text-primary">DNI SUBIDO, CUENTA
                                                                ACTUALMENTE EN REVISION</h2>
                                                        </div>
                                                    </div>
                                                </div>

                                                @endif

                                            </div>
                                            <div class="col-12 d-flex mt-2 flex-sm-row flex-column justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 waves-effect waves-light">GUARDAR</button>
                                            </div>
                                        </form>
                                </div>
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
