<h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
        <p class="text-muted">Generalne informacije o prodavaču...</p>
        <hr>
        <div class="row mt-20">
            <div class="col-12">
                <label class="form-group mb-20 fileContainer">
                    @if (isset($user))
                        <label for="client-image" id="client-image-name">Promjeni Korisničku Fotografiju</label>
                    @else
                        <label for="client-image" id="client-image-name">Dodaj Korisničku Fotografiju</label>
                    @endif
                    <input type="file" onchange="setClientImage(event)" id="client-image" name="client_image" accept="image/*">
                </label>
            </div>
        </div>

        <div class="row mt-10">
            <div class="col-12">
                <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                    <img class="img-thumbnail options-item" src="{{ isset($client->logo) ? asset($client->logo) : 'media/images/avatar.jpg' }}" alt="" id="client-image-thumb">
                    <input type="hidden" name="logo" value="{{ isset($client->logo) ? $client->logo : 'media/images/avatar.jpg' }}">
                    <div class="options-overlay bg-primary-dark-op">
                        <div class="options-overlay-content">
                            <h3 class="h4 text-white mb-5" id="client-image-name"></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1" id="ag-auto-suggestion-app">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Opis Prodavača @include('back.layouts.partials.required-star')</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option ml-10"
                            data-toggle="popover" data-placement="top" data-html="true"
                            title="Languages"
                            data-content="Insert description content in appropriate languages tabs.">
                        <i class="si si-question ml-5"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="form-group mb-30">
                    <textarea class="js-summernote" name="description">
                        @if (isset($client))
                            {!! $client->description !!}
                        @endif
                    </textarea>
                    @error('description')
                    <span class="text-danger font-italic">Molimo upišite Opis proizvoda...</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-20 mt-50">
            <label class="css-control css-control-success css-switch">
                <input type="checkbox" class="css-control-input" {{ (isset($client->status) and $client->status) ? 'checked' : '' }} name="status">
                <span class="css-control-indicator"></span> Online Status Prodavača
            </label>
        </div>

    </div>
</div>

<h5 class="text-black mb-0 mt-20">Detalji Prodavača</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-7 offset-lg-1">

        <div class="form-group mb-50">
            <label for="name">Ime Prodavača @include('back.layouts.partials.required-star')</label>
            <input type="text" class="form-control form-control-lg" name="name" value="{{ isset($client) ? $client->name : '' }}">
        </div>

        <div class="form-group mb-50">
            <label for="address">Adresa @include('back.layouts.partials.required-star')</label>
            <input type="text" class="form-control form-control-lg" name="address" value="{{ isset($client) ? $client->address : '' }}">
        </div>

        <div class="form-group row mb-50">
            <div class="col-md-6">
                <label for="zip">Poštanski br.</label>
                <input type="text" class="form-control form-control-lg" name="zip" value="{{ isset($client) ? $client->zip : '' }}">
            </div>
            <div class="col-md-6">
                <label for="city">Grad @include('back.layouts.partials.required-star')</label>
                <input type="text" class="form-control form-control-lg" name="city" value="{{ isset($client) ? $client->city : '' }}">
            </div>
        </div>

        <div class="form-group row mb-50">
            <div class="col-md-6">
                <label for="email">Email @include('back.layouts.partials.required-star')</label>
                <input type="text" class="form-control form-control-lg" name="email" value="{{ isset($client) ? $client->email : '' }}">
            </div>
            <div class="col-md-6">
                <label for="phone">Telefon</label>
                <input type="text" class="form-control form-control-lg" name="phone" value="{{ isset($client) ? $client->phone : '' }}">
            </div>
        </div>

        <div class="form-group mb-50">
            <label for="www">www</label>
            <input type="text" class="form-control form-control-lg" name="www" value="{{ isset($client) ? $client->www : '' }}">
        </div>

        <div class="form-group mb-50">
            <label for="name">OIB @include('back.layouts.partials.required-star')</label>
            <input type="text" class="form-control form-control-lg" name="oib" value="{{ isset($client) ? $client->oib : '' }}">
        </div>

    </div>
</div>

<h5 class="text-black mb-0 mt-20">Detalji Narudžbi</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-7 offset-lg-1">

        <div class="form-group mb-50">
            <label for="name">Minimalni iznos narudžbe za besplatnu dostavu (kn)</label>
            <input type="text" class="form-control form-control-lg" name="min_order" value="{{ isset($client) ? $client->min_order : '' }}" placeholder="Nije obvezan...">
        </div>

        <div class="form-group mb-50">
            <label for="address">Cijena dostave (kn)</label>
            <input type="text" class="form-control form-control-lg" name="shipping_price" value="{{ isset($client) ? $client->shipping_price : '' }}">
        </div>

    </div>
</div>

@push('client_scripts')

@endpush
