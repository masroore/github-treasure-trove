@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($slider) ? route('slider.individual.update', ['id' => $group->id, 'sid' => $slider->id]) : route('slider.individual.store', ['id' => $group->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="group" value="{{ $group->id }}">
            <h2 class="content-heading"> <a href="{{ route('slider.edit', ['id' => $group->id]) }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($slider))
                    {{ method_field('PATCH') }}
                    Uredi Slider <small class="text-primary pl-4">{{ $slider->name }}</small>
                @else
                    Stvori Novi Slider
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-20">Pozadina i Poruka</h5>
                            <hr class="mb-10">

                            <div class="block mb-20">
                                <div class="block-content" style="padding: 0;">
                                    <div class="slim"
                                         data-force-size="1600,600"
                                         data-max-file-size="5">
                                        <img src="{{ isset($slider) ? asset($slider->image) : asset('media/temp/slider/1.jpg') }}" alt=""/>
                                        <input type="file" name="image"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-30">
                                <label for="title">Naslov @include('back.layouts.partials.required-star') <span class="text-gray">Max 40 znakova!</span></label>
                                <input type="text" class="js-maxlength form-control" name="title" maxlength="40" placeholder="Kratki naslov..." data-always-show="true" value="{{ isset($slider) ? $slider->title : '' }}">
                            </div>

                            <div class="form-group mb-30">
                                <label for="title">Podnaslov <span class="text-gray">Max 200 znakova!</span></label>
                                <textarea class="js-maxlength form-control" maxlength="200" data-always-show="true" name="subtitle" rows="4" placeholder="Kratki podnaslov...">{{ isset($slider) ? $slider->subtitle : '' }}</textarea>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Teksta</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="text_placement" @if (isset($slider) and $slider->text_placement == 'center') checked @endif>
                                            <span class="css-control-indicator"></span> Tekst u sredini
                                        </label>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="text_color" @if (isset($slider) and $slider->text_color == 'white') checked @endif>
                                            <span class="css-control-indicator"></span> Bijeli tekst
                                        </label>
                                    </div>
                                    <div class="form-group mb-10">
                                        <label for="title">Redosljed u grupi</label>
                                        <input type="text" class="form-control" name="sort_order" placeholder="Upisati broj..." value="{{ isset($slider) ? $slider->sort_order : '' }}">
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

    </script>

    @stack('slider_scripts')

@endpush
