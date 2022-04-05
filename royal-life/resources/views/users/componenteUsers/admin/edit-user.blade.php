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
    $(document).ready(function () {
        @if($user->dni != NULL)
        previewPersistedFile("{{asset('storage/dni/'.$user->dni)}}",'photo_preview');
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h1 class="mt-2 mb-2">Editando el Usuario #{{ $user->id }}</h1>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                        aria-labelledby="account-pill-general" aria-expanded="true">

                                        <form action="{{ route('users.update-user',$user->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <hr>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h2 class="font-weight-bold">Datos Personales</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required" for="">Nombre</label>
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="name" name="name" placeholder="Nombre"
                                                                value="{{ $user->name }}">
                                                            @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required" for="last_name">Apellido</label>
                                                            <input type="text"
                                                                class="form-control @error('last_name') is-invalid @enderror"
                                                                id="last_name" name="last_name" placeholder="Apellido"
                                                                value="{{ $user->last_name }}">
                                                            @error('last_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required" for="email">Email</label>
                                                            <input type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                id="email" name="email" placeholder="Email"
                                                                value="{{ $user->email }}">
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required" for="whatsapp">Whatsapp</label>
                                                            <input type="text"
                                                                class="form-control @error('whatsapp') is-invalid @enderror"
                                                                name="whatsapp" value="{{ $user->whatsapp }}"
                                                                placeholder="whatsapp">
                                                            @error('whatsapp')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required" for="address">Dirección</label>
                                                            <textarea type="text"
                                                                class="form-control @error('address') is-invalid @enderror"
                                                                id="address"
                                                                name="address">{{ $user->address}}</textarea>
                                                            @error('address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h2 class="font-weight-bold">DNI</h2>
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
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <h2 class="font-weight-bold">Información Administrativa</h2>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required">Rol del Usuario</label>
                                                            <select name="admin" id="admin"
                                                                class="custom-select admin @error('admin') is-invalid @enderror"
                                                                required data-toggle="select">
                                                                @if ( $user->admin == 0 )
                                                                <option value="{{ $user->admin }}">Normal</option>
                                                                <option class="text-danger text-bold-600" value="1">
                                                                    Administrador</option>

                                                                @elseif ( $user->admin == 1 )
                                                                <option class="text-danger text-bold-600"
                                                                    value="{{ $user->admin }}">Administrador</option>
                                                                <option value="0">Normal</option>

                                                                @endif
                                                            </select>
                                                            @error('admin')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required">Estado de la Cuenta</label>
                                                            <select name="status" id="status"
                                                                class="custom-select status @error('status') is-invalid @enderror"
                                                                required data-toggle="select">
                                                                <option value="0" @if($user->status == '0') selected
                                                                    @endif>Inactivo</option>
                                                                <option value="1" @if($user->status == '1') selected
                                                                    @endif>Activo</option>
                                                                <option value="2" @if($user->status == '2') selected
                                                                    @endif>Eliminado</option>
                                                            </select>
                                                            @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label class="required">Balance de la Cuenta</label>
                                                            <input type="number"
                                                                class="form-control @error('balance') is-invalid @enderror"
                                                                id="balance" name="balance" value="{{ $user->balance}}">
                                                            @error('balance')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 waves-effect waves-light">GUARDAR</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
