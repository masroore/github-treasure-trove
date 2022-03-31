@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ route('info.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('info') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                Info Podaci Aplikacije
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i>Snimi</button>
            </h2>

            <div class="row items-push">
                <div class="col-md-6">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Info Podaci</h3>
                        </div>
                        <div class="block-content">
                            <div class="form-group mb-30 mt-20">
                                <label for="name">Ime Aplikacije @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control form-control-lg" name="name" placeholder="Obvezno upišite naslov aplikacije..." value="{{ isset($data) ? $data->name : '' }}">
                                @error('name')
                                <span class="text-danger font-italic">Naslov stranice je obvezan...</span>
                                @enderror
                            </div>
                            <div class="form-group mb-30">
                                <label for="admin_name">Ime Administracije <small class="text-gray">Odvojite razmakom za dvobojno</small></label>
                                <input type="text" class="form-control form-control-lg" name="admin_name" placeholder="Ime Administracije..." value="{{ isset($data) ? $data->admin_name : '' }}">
                            </div>
                            <div class="form-group mb-50">
                                <label for="long_name">Puno ime aplikacije <small class="text-gray">Legalno ime tvrtke</small></label>
                                <input type="text" class="form-control form-control-lg" name="long_name" placeholder="Dugačko ime aplikacije..." value="{{ isset($data) ? $data->long_name : '' }}">
                            </div>

                            <div class="form-group mb-30">
                                <label for="address">Adresa</label>
                                <input type="text" class="form-control form-control-lg" name="address" placeholder="Adresa..." value="{{ isset($data) ? $data->address : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="city">Grad</label>
                                <input type="text" class="form-control form-control-lg" name="city" placeholder="Grad..." value="{{ isset($data) ? $data->city : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="zip">Poštanski broj</label>
                                <input type="text" class="form-control form-control-lg" name="zip" placeholder="Zip..." value="{{ isset($data) ? $data->zip : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Kontakt podaci i mreže</h3>
                        </div>
                        <div class="block-content">
                            <div class="form-group mb-30 mt-20">
                                <label for="phone">Telefon</label>
                                <input type="text" class="form-control form-control-lg" name="phone" placeholder="Broj telefona..." value="{{ isset($data) ? $data->phone : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control form-control-lg" name="mobile" placeholder="Dugačko ime aplikacije..." value="{{ isset($data) ? $data->mobile : '' }}">
                            </div>
                            <div class="form-group mb-50">
                                <label for="email">Email</label>
                                <input type="text" class="form-control form-control-lg" name="email" placeholder="Email adresa..." value="{{ isset($data) ? $data->email : '' }}">
                            </div>

                            <div class="form-group mb-30">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control form-control-lg" name="facebook" placeholder="Facebook adresa..." value="{{ isset($data) ? $data->facebook : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="instagram">Instagram</label>
                                <input type="text" class="form-control form-control-lg" name="instagram" placeholder="Instagram adresa..." value="{{ isset($data) ? $data->instagram : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="mailchimp">Mailchimp</label>
                                <input type="text" class="form-control form-control-lg" name="mailchimp" placeholder="Mailchimp newsletter ID..." value="{{ isset($data) ? $data->mailchimp : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
@endpush
