@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($category) ? route('category.update', ['category' => $category]) : route('category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('categories') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($category))
                    {{ method_field('PATCH') }}
                    Uredi Kategoriju <small class="text-primary pl-4">{{ $category->name }}</small>
                @else
                    Napravi Novu Kategoriju
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
                                <label for="name">Ime</label>
                                <input type="text" class="form-control" name="name" id="category-name-input" value="{{ isset($category->name) ? $category->name : '' }}" placeholder="" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-50">
                                <label for="slug">Svojevoljni SEO URL <span class="text-gray">Nije preporučljivo!</span></label>
                                <input type="text" class="form-control" name="slug" id="slug-input" value="{{ isset($category->slug) ? $category->slug : '' }}" placeholder="">
                            </div>
                            <div class="form-group mb-50">
                                <label for="seo-description">Meta opis</label>
                                <textarea class="form-control" name="meta_description" id="category-meta-description" rows="4" placeholder="Kratki SEO opis kategorije..." onkeyup="SetSEOPreview()">
                                    {{ isset($category) ? $category->meta_description : '' }}
                                </textarea>
                            </div>
                            <div class="form-group mb-50">
                                <label for="meta_keywords">Meta ključne riječi</label>
                                <input type="text" class="form-control form-control-lg text-primary" id="tags-input" name="meta_keyword" value="{{ isset($category->meta_keyword) ? $category->meta_keyword : '' }}">
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
                                                <p id="category-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                <p id="category-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                <p id="category-content-value" class=""></p>
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
                                    <div class="form-group mb-50" id="group-category-select">
                                        <label for="group">Grupa Kategorije</label>
                                        <select class="js-select2 form-control" id="group-select" name="group" style="width: 100%;">
                                            @foreach ($groups as $group)
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                <option value="{{ $group }}" {{ (isset($category->group) and $group == $category->group) ? 'selected="selected"' : '' }}>{{ strtoupper($group) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-50" id="parent-category-select">
                                        <label for="parent">Krovna Kategorija</label>
                                        <select class="js-select2 form-control" id="parent-select" name="parent" style="width: 100%;">
                                            @foreach ($parents as $id => $name)
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                <option value="{{ $id }}" {{ (isset($category->parent_id) and $id == $category->parent_id) ? 'selected="selected"' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control-primary css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($category->top) and $category->top) ? 'checked' : '' }} name="top" id="is-top" onchange="isTop()">
                                            <span class="css-control-indicator"></span> Krovna Kategorija
                                        </label>
                                    </div>
                                    <div class="form-group mb-30 mt-20">
                                        <label class="css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($category->status) and $category->status) ? 'checked' : '' }} name="status">
                                            <span class="css-control-indicator"></span> Online Status Kategorije
                                        </label>
                                    </div>
                                    <div class="form-group mb-50">
                                        <label class="css-control css-control-info css-switch res">
                                            <input type="checkbox" class="css-control-input" name="single_page" @if (isset($category) and $category->single_page) checked @endif>
                                            <span class="css-control-indicator"></span> Kategorija kao Samostalna Stranica
                                        </label>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label for="meta_description">Redosljed Sortiranja</label>
                                        <input type="text" class="js-maxlength form-control" name="sort_order" maxlength="3" placeholder="Samo brojevi..." data-always-show="true" value="{{ isset($category) ? $category->sort_order : '' }}">
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
                                            @if (isset($category))
                                                {!! $category->description !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis kategorije ako je potreban...</span>
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

    <script>
        $(() => {
            $('#parent-select').select2({
                tags: true
            })

            $('#group-select').select2({
                tags: true
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
                placeholder: "Možda kratki opis kategorije...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link', 'tabel', 'hr']],
                    ['view', ['help', 'codeview']]
                ],
                styleTags: ['p', 'h4', 'blockquote'],
            })

            SetSEOPreview()

        })


        function SetSEOPreview() {
            let title = document.getElementById('category-name-input').value
            document.getElementById('slug-input').value = slugify(title)

            if (title) {
                document.getElementById('category-title-value').innerHTML = title
                document.getElementById('category-url-value').innerHTML = 'https://{{ request()->getHost() }}/' + slugify(title)
            }

            let category_meta_description = document.getElementById('category-meta-description').value
            if (category_meta_description) {
                document.getElementById('category-content-value').innerHTML = category_meta_description
            }
        }

    </script>

    <script>
        $(() => {
            isTop()
        })

        function isTop() {
            let parent = document.getElementById('parent-category-select')
            let group = document.getElementById('group-category-select')
            let checked = document.getElementById('is-top').checked

            if (checked) {
                group.hidden = false
                return parent.hidden = true
            }

            group.hidden = true
            return parent.hidden = false
        }
    </script>

@endpush
