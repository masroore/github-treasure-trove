@extends('setting::layouts.master')

@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('setting.Color Theme')}}</h3>
                    @if(permissionCheck('themes.index'))
                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('themes.index') }}" ><i
                                        class="ti-list"></i>{{__('setting.Color Theme List')}}</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="white_box_50px box_shadow_white">
                {!! Form::open(['route' => ['themes.update', $theme->id],'method' => 'put', 'files' => true]) !!}
                <div class="row form">
                    <div class="col-lg-3">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="title">{{__('setting.Theme Title')}} *</label>
                            <input type="text" name="title" class="primary_input_field" id="title" required maxlength="191" autofocus value="{{ old('title', $theme->title) }}" >
                            <span class="text-danger">{{$errors->first('title')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{__('setting.Color Mode')}} *</label>
                            <select class="primary_select mb-15 color_mode" name="color_mode" id="color_mode">
                                <option value="gradient" {{ old('color_mode', $theme->color_mode) == 'gradient' ? 'selected' : '' }}>{{__('setting.gradient')}}</option>
                                <option value="solid" {{ old('color_mode', $theme->color_mode) == 'solid' ? 'selected' : '' }}>{{__('setting.solid')}}</option>
                            </select>
                            <span class="text-danger">{{$errors->first('color_mode')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="primary_input_label" for="">{{__('setting.background_type')}} *</label>
                        <select class="primary_select mb-15 contact_type" name="background_type" id="background-type">

                            <option value="image" {{ old('background_type', $theme->background_type) == 'image' ? 'selected' : '' }}>@lang('common.Image') (1920x1400)</option>
                            <option value="color" {{ old('background_type', $theme->background_type) == 'color' ? 'selected' : '' }}>@lang('common.color')</option>
                        </select>
                        @if ($errors->has('background_type'))
                            <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('background_type') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="col-lg-3" id="background-color">
                        <div class="input-effect">
                            <label class="primary_input_label" for="color"> @lang('setting.background_color')
                                <span>*</span></label>
                            <input
                                class="primary_input_field "
                                type="color" name="background_color" autocomplete="off" id="background_color"
                                value="{{old('background_color', $theme->background_color)}}">

                            @if ($errors->has('background_color'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('background_color') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>


                    <div class="col-lg-3" id="background-image">
                        <label class="primary_input_label" for="color"> @lang('setting.background_image')
                            </label>
                        <div class="primary_file_uploader">
                            <input class="primary-input" type="text" id="backGroundImagePlaceholder"
                                   placeholder="Browse file" readonly>
                            <button class="" type="button">
                                <label class="primary-btn small fix-gr-bg"
                                       for="background_image">{{__("common.Browse")}} </label>
                                <input type="file" class="d-none" name="background_image" id="background_image">
                            </button>
                        </div>
                        <input type="hidden" id="old_bg_image" value="{{ asset($theme->background_image) }}">
                        @if ($errors->has('background_image'))
                            <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('background_image') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="row form">
                    @foreach($theme->colors as $color)
                        <div class="col-lg-2" id="{{ $color->name.'_div' }}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="{{ $color->name }}">{{__('setting.'.$color->name)}} *</label>
                                <input type="color" name="color[{{ $color->id }}]" class="primary_input_field color_field" data-name="{{ $color->name }}" id="{{ $color->name }}" required value="{{ old('color.'.$color->id, $color->pivot->value) }}" data-value="{{ $color->pivot->value }}">
                                <span class="text-danger">{{$errors->first('color.'.$color->id)}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row form">
                    <div class="col-12">
                        <div class="submit_btn text-center ">
                            <button class="primary-btn semi_large2 fix-gr-bg" id="reset_to_default" type="button"><i
                                    class="ti-check"></i>{{__('setting.Reset To Default')}}
                            </button>
                            <button class="primary-btn semi_large2 fix-gr-bg" type="submit"><i
                                    class="ti-check"></i>{{__('common.Update')}}
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('setting::themes.script')
@endpush
