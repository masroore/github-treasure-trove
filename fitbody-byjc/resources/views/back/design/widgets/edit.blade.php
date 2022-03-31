@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <style>


        .ag-hide {
            display: none;
        }
    </style>
@endpush


@section('content')
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($widget) ? route('widget.update', ['widget' => $widget]) : route('widget.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('widgets') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($widget))
                    {{ method_field('PATCH') }}
                    Uredi Widget <small class="text-primary pl-4">{{ $widget->title }}</small>
                @else
                    Napravi Novi Widget
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="block {{ isset($widget) && isset($widget->image) ? '' : 'block-mode-hidden' }} mb-30">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Glavna Fotografija Proizvođača</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0 20px 0;">
                                    <div class="row">
                                        <div class="col-md-10 offset-md-1" id="size-half">
                                            <div class="slim"
                                                 data-ratio="16:9"
                                                 data-force-size="640,360"
                                                 data-max-file-size="2">
                                                <img src="{{ isset($widget) && isset($widget->image) ? asset($widget->image) : '' }}" alt=""/>
                                                <input type="file" name="image"/>
                                            </div>
                                        </div>
                                        <div class="col-md-10 offset-md-1 ag-hide" id="size-all">
                                            <div class="slim"
                                                 data-ratio="16:9"
                                                 data-force-size="1024,320"
                                                 data-max-file-size="2">
                                                <img src="{{ isset($widget) && isset($widget->image) ? asset($widget->image) : '' }}" alt=""/>
                                                <input type="file" name="image_long"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-30">
                                <label for="title-input">Naslov @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control" name="title" id="title-input" value="{{ isset($widget->title) ? $widget->title : '' }}" placeholder="">
                            </div>

                            <div class="form-group row mb-30">
                                <label class="col-12" for="subtitle-input">Podnaslov</label>
                                <div class="col-12">
                                    <textarea class="form-control" id="subtitle-input" name="subtitle" rows="4" placeholder="Kratak tekst, ako je potreban..">{{ isset($widget->subtitle) ? $widget->subtitle : '' }}</textarea>
                                </div>
                            </div>

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group row mb-30">
                                        <div class="col-4">
                                            <label for="subtitle-input">Tip linka</label>
                                            <select class="js-select2 form-control" id="link-select" name="link" style="width: 100%;">
                                                <option></option>
                                                <option value="category">Kategorija</option>
                                                <option value="page">Stranica</option>
                                            </select>
                                        </div>
                                        <div class="col-8">
                                            <label for="subtitle-input">Link</label>
                                            <select class="js-select2 form-control" id="link-id-select" name="link_id" style="width: 100%;">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label for="url-input">URL Link @include('back.layouts.partials.popover', ['title' => 'Link Widgeta', 'content' => 'Ima prioritet kod linkanja u odnosu na tip. Može se proizvoljno upisati bilo koji link.'])</label>
                                        <input type="text" class="form-control" name="url" id="url-input" value="{{ isset($widget->url) ? $widget->url : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Grupa Widgeta</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label for="group">Grupa Widgeta @include('back.layouts.partials.required-star')</label>
                                        <select class="js-select2 form-control" id="group-select" name="group" style="width: 100%;">
                                            <option></option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" {{ (isset($widget->group_id) and $group->id == $widget->group_id) ? 'selected="selected"' : '' }}>{{ strtoupper($group->title) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-10">
                                        <label for="subtitle-input">Veličina widgeta u grupi @include('back.layouts.partials.popover', ['title' => 'Valičina widgeta', 'content' => 'Veličina se odnosi na širinu pojedinog widgeta unutar grupe.'])</label>
                                        <select class="js-select2 form-control" id="width-select" name="width" style="width: 100%;">
                                            <option></option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size['value'] }}" {{ (isset($widget) && $widget->width == $size['value']) ? 'selected' : '' }}>{{ $size['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-black mb-0 mt-30">Detalji Widgeta</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30 mt-10">
                                        <label class="css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($widget->status) and $widget->status) ? 'checked' : '' }} name="status">
                                            <span class="css-control-indicator"></span> Online Status
                                        </label>
                                    </div>

                                    <div class="form-group mb-20">
                                        <label for="sort_order">Badge Traka @include('back.layouts.partials.popover', ['title' => 'Badge traka', 'content' => 'Ako polje ostane prazno badge traka se neće prikazivati. Ako se upiše prikazivat će se badge traka sa upisanim tekstom.'])</label>
                                        <input type="text" class="form-control" name="badge" value="{{ isset($widget) ? $widget->badge : '' }}">
                                    </div>

                                    <div class="form-group mb-10">
                                        <label for="sort_order">Redosljed Sortiranja</label>
                                        <input type="text" class="js-maxlength form-control" name="sort_order" maxlength="3" placeholder="Samo brojevi..." data-always-show="true" value="{{ isset($widget) ? $widget->sort_order : '' }}">
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

    <script>
        $(() => {
            let preselected_size = '{{ isset($widget->width) ? $widget->width : 0 }}';
            setSize(preselected_size);

            $('#group-select').select2({
                placeholder: 'Odaberite ili upišite novu grupu..',
                tags: true
            });

            $('#width-select').select2({
                placeholder: 'Odaberite širinu widgeta..',
                minimumResultsForSearch: -1,
            }).on('change', item => {
                setSize(item.currentTarget.value);
            });

            //
            $('#link-select').select2({
                placeholder: 'Odaberite..',
                minimumResultsForSearch: -1,
                allowClear: true
                //
            }).on('change', e => {
                $('#link-id-select').empty().trigger('change');
                let selected = e.currentTarget.value;

                axios.get("{{ route('widget.api.get-links') }}?type=" + selected)
                .then(response => {
                    let data = [];

                    for (let item in response.data) {
                        if (selected == 'manufacturer' || selected == 'page') {
                            data.push({
                                id:   item,
                                text: response.data[item]
                            });
                        }
                        data.push({
                            id:   response.data[item].id,
                            text: response.data[item].name
                        });
                    }
                    $('#link-id-select').select2({data: data});
                    setType(data)
                })
                .catch(e => {
                    errorToast.fire({
                        text: e,
                    })
                })
            });
            $('#link-id-select').select2({
                placeholder: 'Odaberite prvo tip linka..',
                allowClear: true
            });
        });


        function setSize(size) {
            if (size == 12) {
                $('#size-half').addClass('ag-hide');
                $('#size-all').removeClass('ag-hide');
            } else {
                $('#size-half').removeClass('ag-hide');
                $('#size-all').addClass('ag-hide');
            }
        }

        /**
         *
         * @param zone
         */
        function setType(type) {
            $('#link-id-select').val(type);
            $('#link-id-select').trigger('change');
        }
    </script>

@endpush
