@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
    <style>
        .slim {
            border-radius: 50%;
        }
    </style>
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($user) ? route('user.update', ['user' => $user]) : route('user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('users') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($user))
                    {{ method_field('PATCH') }}
                    Uredi Korisnika <small class="text-primary pl-4">{{ $user->name }}</small>
                @else
                    Napravi Novog Korisnika
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="form-group mb-50">
                                <label for="user_name">Korisničko Ime</label>
                                <input type="text" class="form-control form-control-lg" name="user_name" value="{{ isset($user) ? $user->name : '' }}">
                            </div>

                            <div class="form-group mb-50">
                                <label for="user_email">Email</label>
                                <input type="text" class="form-control form-control-lg" name="user_email" value="{{ isset($user) ? $user->email : '' }}">
                            </div>

                            <h5 class="text-black mb-0 mt-20">Profilni Podaci</h5>
                            <hr class="mb-30">

                            <div class="form-group row mb-50">
                                <div class="col-md-6">
                                    <label for="user_fname">Ime</label>
                                    <input type="text" class="form-control form-control-lg" name="user_fname" value="{{ isset($user->details) ? $user->details->fname : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="user_lname">Prezime</label>
                                    <input type="text" class="form-control form-control-lg" name="user_lname" value="{{ isset($user->details) ? $user->details->lname : '' }}">
                                </div>
                            </div>


                            <div class="form-group mb-50">
                                <label for="user_address">Adresa</label>
                                <input type="text" class="form-control form-control-lg" name="user_address" value="{{ isset($user->details) ? $user->details->address : '' }}">
                            </div>

                            <div class="form-group row mb-50">
                                <div class="col-md-6">
                                    <label for="user_zip">Poštanski br.</label>
                                    <input type="text" class="form-control form-control-lg" name="user_zip" value="{{ isset($user->details) ? $user->details->zip : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="user_city">Grad</label>
                                    <input type="text" class="form-control form-control-lg" name="user_city" value="{{ isset($user->details) ? $user->details->city : '' }}">
                                </div>
                            </div>

                            <div class="form-group mb-50">
                                <label for="user_phone">Telefon</label>
                                <input type="text" class="form-control form-control-lg" name="user_phone" value="{{ isset($user->details) ? $user->details->phone : '' }}">
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Profila</h5>
                            <hr class="mb-30">

                            <div class="form-group px-150 mb-50">
                                <div class="slim"
                                     data-ratio="1:1"
                                     data-size="360,360"
                                     data-max-file-size="2">
                                    <img src="{{ isset($user->details) && isset($user->details->avatar) ? asset($user->details->avatar) : asset('media/images/avatar.jpg') }}" alt=""/>
                                    <input type="file" name="user_image"/>
                                </div>
                            </div>

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="user_status" @if (isset($user) and $user->status) checked @endif>
                                            <span class="css-control-indicator"></span> Status Korisnika
                                        </label>
                                    </div>
                                    @if (Bouncer::is(auth()->user())->an('admin'))
                                        <div class="form-group mb-30">
                                            <label for="user_password">Promijeni Lozinku</label>
                                            <input type="text" class="form-control form-control-lg" name="user_password">
                                        </div>

                                        <div class="form-group mb-10">
                                            <label for="user_role">Odaberi korisničku Ulogu</label>
                                            <select class="form-control" id="role-select" name="user_role" style="width: 100%;">
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach (config('settings.roles') as $key => $role)
                                                    <option value="{{ $key }}" {{ ((isset($user)) and ($user->role == $key)) ? 'selected' : '' }}>{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-12">
                            <div class="block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Ukratko o sebi</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option ml-10" data-toggle="popover" data-placement="top" data-html="true" title="Languages" data-content="Insert description content in appropriate languages tabs.">
                                            <i class="si si-question ml-5"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0;">
                                    <div class="form-group mb-30">
                                        <textarea class="js-summernote" name="user_description">
                                            @if (isset($user->details))
                                                {!! $user->details->bio !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis sebe ukratko...</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-5"></i> Snimi
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(() => {
            $('#role-select').select2()

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Upiši neki info...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link', 'tabel', 'hr']],
                    ['view', ['help']]
                ],
                styleTags: ['p', 'h4', 'blockquote'],
            })

            isClient()
        })

        function setImage(e) {
            let file = e.target.files[0]
            document.getElementById('user-image-name').innerHTML = file.name

            let reader = new FileReader()
            let cx = this

            reader.onload = event => {
                document.getElementById('user-image-thumb').src = event.target.result
            }

            reader.readAsDataURL(file)
        }

        function isClient() {
            let nav_client = document.getElementById('nav-item-client')
            let tab_client = document.getElementById('user-client')
            let checked;

            if (document.getElementById('is-client')) {
                checked = document.getElementById('is-client').checked
            } else {
                if ('{{ isset($user) and $user->status }}') {
                    checked = true
                } else {
                    checked = false
                }
            }


            if (checked) {
                nav_client.hidden = false
                tab_client.hidden = false

            } else {
                nav_client.hidden = true
                tab_client.hidden = true
            }
        }
    </script>

    @stack('client_scripts')

@endpush
