@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($slider) ? route('slider.update', ['id' => $slider->id]) : route('slider.store') }}"
              method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"><a href="{{ route('sliders') }}" class="mr-10 text-gray font-size-h4"><i
                        class="si si-action-undo"></i></a>
                @if (isset($slider))
                    {{ method_field('PATCH') }}
                    Uredi Grupu Slidera <small class="text-primary pl-4">{{ $slider->name }}</small>
                @else
                    Stvori Novu Slider Grupu
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi
                </button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-6">
                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">
                            <div class="form-group mb-50">
                                <label for="name">Ime Grupe</label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="Type slider group name..."
                                       value="{{ isset($slider) ? $slider->name : '' }}">
                            </div>

                            <div class="form-group mb-30">
                                <label for="name" class="mb-20">Odaberite gdje i kada želite prikazivati Slider Grupu.</label>
                                <table class="table table-borderless table-vcenter">
                                    <tbody>
                                    <tr>
                                        <td style="width: 25%;"><label for="categories">Kategorija</label></td>
                                        <td>
                                            <select class="form-control" id="categories-select" name="categories"
                                                    style="width: 100%;">
                                                <option></option>
                                                @foreach ($categories as $category)
                                                    <option
                                                        value="{{ $category['id'] }}" {{ (isset($slider) and ($category['id'] == $slider->category_id)) ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="pages">Stranica</label></td>
                                        <td>
                                            <select class="form-control" id="pages-select" name="pages"
                                                    style="width: 100%;">
                                                <option></option>
                                                @foreach ($pages as $page)
                                                    @if ($page['id'] != 1 || $page['id'] != 12)
                                                        <option
                                                            value="{{ $page['id'] }}" {{ (isset($slider) and ($page['id'] == $slider->page_id)) ? 'selected' : '' }}>{{ $page['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group row mb-50">
                                <div class="col-md-6">
                                    <label for="date_start">Početak</label>
                                    <input type="text" name="date_start" id="start-date-picker"
                                           class="form-control form-control-lg"
                                           value="{{ isset($slider) && $slider->date_start != '0000-00-00 00:00:00' ? date_format(date_create($slider->date_start), 'd.m.Y. H:m') : '' }}"
                                           style="height: 34px; background-color: white;">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_end">Kraj</label>
                                    <input type="text" class="form-control form-control-lg" name="date_end"
                                           id="end-date-picker"
                                           value="{{ isset($slider) && $slider->date_end != '0000-00-00 00:00:00' ? date_format(date_create($slider->date_end), 'd.m.Y. H:m') : '' }}"
                                           style="height: 34px; background-color: white;">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <h5 class="text-black mb-0 mt-20">Detalji Stranice</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content"
                                     style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-0">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="status"
                                                   @if (isset($slider) and $slider->status) checked @endif>
                                            <span class="css-control-indicator"></span> Online Status Slider Grupe
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if (isset($slider))
                                <h5 class="text-black mb-0 mt-30">Slideri
                                    <span class="float-right">
                                    <a href="{{ route('slider.individual.create', ['id' => $slider->id]) }}"
                                       class="btn btn-sm btn-outline-info"><i
                                            class="fa fa-film mr-5"></i> Novi Slider</a>
                                </span>
                                </h5>
                                <hr class="mb-30">

                                @if (isset($slider->sliders))
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach ($slider->sliders as $slide)
                                                <tr>
                                                    <td width="189">
                                                        <img class="img-thumbnail" src="{{ asset($slide->image) }}"
                                                             width="180">
                                                    </td>
                                                    <td class="font-w600">{{ $slide->title }}<br><span
                                                            class="font-w300">{{ $slide->subtitle }}</span></td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('slider.individual.edit', ['id' => $slider->id, 'sid' => $slide->id]) }}"
                                                               class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                               data-toggle="tooltip" title=""
                                                               data-original-title="Uredi">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a href=""
                                                               class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                               data-toggle="tooltip" title=""
                                                               data-original-title="Obriši">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endif
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
    {{--<script src="{{ asset('js/ag-slider-images.js') }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(() => {
            $('#categories-select').select2()
            $('#pages-select').select2()
            $('#blogs-select').select2()

            $('#start-date-picker').flatpickr({
                enableTime: true,
                dateFormat: "d.m.Y. H:i",
            })

            $('#end-date-picker').flatpickr({
                enableTime: true,
                dateFormat: "d.m.Y. H:i",
            })
        })
    </script>

    @stack('slider_scripts')

@endpush
