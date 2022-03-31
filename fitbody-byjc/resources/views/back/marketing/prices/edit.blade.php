@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@stack('price_css')


@section('content')
    <div class="content" id="prices-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($price) ? route('price.update', ['price' => $price]) : route('price.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('prices') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($price))
                    {{ method_field('PATCH') }}
                    Uredi Cjenik <small class="text-primary pl-4">{{ $price->title }}</small>
                @else
                    Napravi Novi Cjenik
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">

                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="form-group mb-30 mt-30">
                                <label for="title">Naslov Cjenika @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control form-control-lg" name="title" placeholder="Upišite naslov cjenika..." value="{{ isset($price) ? $price->title : '' }}">
                                @error('title')
                                <span class="text-danger font-italic">Naslov cjenika je obvezan...</span>
                                @enderror
                            </div>
                            <div class="form-group mb-50">
                                <label for="subtitle">Podnaslov</label>
                                <input type="text" class="js-maxlength form-control" name="subtitle" id="subtitle-input" maxlength="100" placeholder="Upišite podnaslov..." data-always-show="true" value="{{ isset($price) ? $price->subtitle : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="price">Cijena</label>
                                <input type="text" class="js-maxlength form-control" name="price" id="price-input" maxlength="100" placeholder="Upišite cjenu..." data-always-show="true" value="{{ isset($price) ? $price->price : '' }}">
                            </div>
                            <div class="form-group mb-50">
                                <label for="price_per">Cijena prema...</label>
                                <input type="text" class="js-maxlength form-control" name="price_per" id="price_per-input" maxlength="100" placeholder="Upišite cjenu prema kojem vremenskom periodu (tjedan, mjesec, god...)..." data-always-show="true" value="{{ isset($price) ? $price->price_per : '' }}">
                            </div>
                            <div class="form-group mb-30">
                                <label for="tags">Ključne riječi</label>
                                <input type="text" class="js-tags-input form-control text-primary" id="tags-input" name="tags" value="{{ isset($price) ? $price->tags : '' }}">
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-30">Status Cjenika</h5>
                            <hr class="mb-20">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="status" @if (isset($price) and $price->status) checked @endif>
                                            <span class="css-control-indicator"></span> Objavi Cjenik
                                        </label>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="css-control css-control css-control-info css-switch">
                                            <input type="checkbox" class="css-control-input" name="featured" @if (isset($price) and $price->featured) checked @endif>
                                            <span class="css-control-indicator"></span> Featured Cjenik
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <div class="row items-push">
                        <div class="col-12">
                            <div class="block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Sadržaj Stranice</h3>
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
                                        <textarea class="js-summernote" name="description">
                                            @if (isset($price))
                                                {!! $price->subtitle !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis stranice ili sadržaj...</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/components/ag-block.js') }}"></script>

    <script>
        $(() => {
            $('#tags-input').tagsInput({
                height: '38px',
                width: '100%',
                defaultText: 'Upiši listu ključnih riječi odvojenih zarezom...',
                removeWithBackspace: true,
                delimiter: [',']
            })

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Upiši sadržaj stranice...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['picture', 'video', 'link', 'tabel', 'hr']],
                    ['view', ['codeview', 'help']]
                ],
                styleTags: ['p', 'h4', 'h2', 'blockquote'],
            })
        })
    </script>

    @stack('price_js')

@endpush
