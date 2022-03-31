@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@stack('page_css')


@section('content')
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($page) ? route('page.update', ['page' => $page]) : route('page.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('pages') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($page))
                    {{ method_field('PATCH') }}
                    Uredi Stranicu <small class="text-primary pl-4">{{ $page->name }}</small>
                @else
                    Napravi Novu Stranicu
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">

                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="block {{ isset($page) && isset($page->image) ? '' : 'block-mode-hidden' }}">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Glavna slika stranice</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0 20px 0;">
                                    <div class="slim"
                                         {{--data-service="async.php"
                                         data-fetcher="fetch.php"--}}
                                         data-ratio="16:9"
                                         data-size="600,360"
                                         data-max-file-size="2">
                                        <img src="{{ isset($page) && isset($page->image) ? asset($page->image) : asset('media/temp/slider/1.jpg') }}" alt=""/>
                                        <input type="file" name="main_image"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-50 mt-30">
                                <label for="name">Ime Stranice @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control form-control-lg" name="name" placeholder="Upišite naslov stranice..." value="{{ isset($page) ? $page->name : '' }}">
                                @error('name')
                                <span class="text-danger font-italic">Naslov stranice je obvezan...</span>
                                @enderror
                            </div>

                            <h5 class="text-black mb-0 mt-20">Page SEO Detalji</h5>
                            <hr class="mb-30">

                            <div class="form-group mb-30">
                                <label for="slug">Svojevoljni SEO URL <span class="text-gray">Nije preporučljivo!</span></label>
                                <input type="text" class="js-maxlength form-control" name="slug" id="seo-url" maxlength="100" placeholder="Type short SEO Url..." data-always-show="true" value="{{ isset($page) ? $page->slug : '' }}" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-30">
                                <label for="seo_title">SEO Naslov</label>
                                <input type="text" class="js-maxlength form-control" name="seo_title" id="seo-title" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($page) ? $page->seo_title : '' }}" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-30">
                                <label for="seo-description">Meta opis</label>
                                <textarea class="form-control" id="seo-description" name="meta_description" rows="4" placeholder="Kratki SEO opis stranice..." onkeyup="SetSEOPreview()">{{ isset($page) ? $page->meta_description : '' }}</textarea>
                                {{--<input type="text" class="js-maxlength form-control" name="meta_description" id="seo-description" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($page) ? $page->meta_description : '' }}" onkeyup="SetSEOPreview()">--}}
                            </div>
                            <div class="form-group mb-30">
                                <label for="meta_keywords">Meta ključne riječi</label>
                                <input type="text" class="js-tags-input form-control text-primary" id="tags-input" name="meta_keywords" value="{{ isset($page) ? $page->meta_keywords : '' }}">
                            </div>

                            <div class="block block-mode-hidden mb-30 mt-20 d-none d-md-block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Google pregled</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="form-group">
                                        <div class="block border">
                                            <div class="block-content pt-10">
                                                <p id="seo-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                <p id="seo-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                <p id="seo-description-value" class=""></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Stranice</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    @if (Bouncer::is(auth()->user())->an('admin'))
                                        <div class="form-group mb-20">
                                            <label for="group">Odaberi Pripadnost Stranice @include('back.layouts.partials.required-star')</label>
                                            <select class="form-control" id="page-select" name="category_id" style="width: 100%;">
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach ($page_groups as $group)
                                                    <option value="{{ $group['id'] }}" {{ (isset($page) and ($page->category_id == $group['id'])) ? 'selected' : '' }}>{{ \Illuminate\Support\Str::upper($group['name']) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h5 class="text-black mb-0 mt-30">Status Stranice</h5>
                            <hr class="mb-20">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="status" @if (isset($page) and $page->status) checked @endif>
                                            <span class="css-control-indicator"></span> Objavi Stranicu
                                        </label>
                                    </div>

                                    <div class="form-group mb-20">
                                        <label for="slug">Ili objavi stranicu određenog datuma</label>
                                        <input type="text" name="date_published" id="published-date-picker" class="form-control " placeholder="Od..."
                                               value="{{ request()->input('from') ? date_format(date_create(request()->input('from')), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
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
                                            @if (isset($page))
                                                {!! $page->description !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis stranice ili sadržaj...</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="text-black mb-0 mt-0">Dodaci na Stranici</h5>
                            <hr class="mb-30">

                            <div class="block block-mode-hidden">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Galerija fotografija</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    @include('back.settings.pages.partials.gallery')
                                </div>
                            </div>

                            <div class="block block-mode-hidden">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Dokumenti</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" id="ag-doc-block-app">
                                    @include('back.settings.pages.partials.documents')
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

    <script src="{{ asset('js/components/ag-block.js') }}"></script>
    {{--<script src="{{ asset('vendors~pdfjsWorker.js') }}"></script>--}}

    <script>
        $(() => {
            $('#page-select').select2({
                tags: false
            })

            /* Datepickers */
            $('#published-date-picker').flatpickr({
                enableTime: false,
                dateFormat: "d.m.Y.",
            })

            $('#tags-input').tagsInput({
                height: '38px',
                width: '100%',
                defaultText: 'Insert tag...',
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

            SetSEOPreview()
        })

        function SetSEOPreview() {
            let seo_title = document.getElementById('seo-title').value
            document.getElementById('seo-title-value').innerHTML = seo_title

            let seo_url = document.getElementById('seo-url').value
            document.getElementById('seo-url-value').innerHTML = 'https://{{ request()->getHost() }}/' + seo_url

            let seo_description = document.getElementById('seo-description').value
            document.getElementById('seo-description-value').innerHTML = seo_description
        }
    </script>

    @stack('page_js')

@endpush
