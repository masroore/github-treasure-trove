@extends('setting::layouts.master')

@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('setting.Color Theme')}}</h3>
                    @if(permissionCheck('themes.create'))
                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                   href="{{ route('themes.create') }}"><i
                                        class="ti-plus"></i>{{__('setting.Add New Theme')}}</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('common.Title')}}</th>
                                <th scope="col">{{__('common.Type')}}</th>
                                <th scope="col">{{__('setting.Colors')}}</th>
                                <th scope="col">{{__('setting.Background')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($themes as $theme)

                                <tr>
                                    <td>{{ $theme->title }}</td>
                                    <td>{{ __('setting.'.$theme->color_mode) }}</td>
                                    <td>
                                        <div class="row">
                                            @foreach($theme->colors as $color)

                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="color_theme_list">
                                                            <span>{{ __('setting.'.$color->name) }} </span>


                                                                    <span class="color_preview">:  <span class="bg-color"
                                                                                style="background: {{ @$color->pivot->value }}"></span>{{@$color->pivot->value}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>

                                    </td>
                                    <td>
                                        @if(@$theme->background_type == 'image')
                                            <div class="bg_img_previw" style="background-image : url({{asset($theme->background_image)}})">

                                            </div>
                                        @else
                                            <div
                                                style="width: 100px; height: 50px; background-color:{{@$theme->background_color}} "></div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(@$theme->is_default==1)
                                            <span class="primary-btn small fix-gr-bg "> @lang('common.Active') </span>
                                        @else
                                            @if(env('APP_SYNC'))
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                      title="Disabled For Demo ">
                                                            <a class="primary-btn small tr-bg text-nowrap"
                                                               href="#"> @lang('common.Make Default')</a>
                                                </span>

                                            @else
                                                @if(permissionCheck('themes.default'))
                                                    <a class="primary-btn small tr-bg text-nowrap"
                                                       href="{{route('themes.default',@$theme->id)}}"> @lang('common.Make Default') </a>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>

                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"> {{__('common.select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenu2">
                                                @if ($theme->id != 1)
                                                    @if(permissionCheck('themes.edit'))
                                                        <a class="dropdown-item"
                                                           href="{{ route('themes.edit', $theme->id) }}">@lang('common.Edit')</a>
                                                    @endif
                                                @endif

                                                @if(permissionCheck('themes.copy'))
                                                    <a class="dropdown-item"
                                                       type="button"
                                                       href="{{ route('themes.copy', $theme->id) }}">@lang('setting.Clone Theme')</a>
                                                @endif
                                                @if ($theme->id != 1)
                                                    @if(permissionCheck('themes.destroy'))
                                                        <a class="dropdown-item"
                                                           type="button" data-toggle="modal"
                                                           data-target="#deletebackground_settingModal{{@$theme->id}}"
                                                           href="#">@lang('common.Delete')</a>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>

                                    </td>

                                    <div class="modal fade admin-query"
                                         id="deletebackground_settingModal{{@$theme->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('common.Delete')</h4>
                                                    <button type="button" class="close" data-dismiss="modal"> <i class="ti-close"></i>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.Are you sure to delete ?')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">@lang('common.Cancel')
                                                        </button>

                                                        {!! Form::open(['route' => ['themes.destroy', $theme->id], 'method' => 'delete']) !!}
                                                        <button type="submit"  class="primary-btn fix-gr-bg">@lang('common.Delete')</button>
                                                        {!! Form::close() !!}


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
