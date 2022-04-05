@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @lang('common.Upload SQL File')
                                </h3>
                            </div>
                            <div class="mt-40 pt-30">
                                <form method="POST" action="{{ route('backup.import') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="row  mt-25">
                                                <div class="col-lg-12">

                                                    <div class="primary_input mb-15">
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                   id="placeholderFileOneName" placeholder="Browse file"
                                                                   readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                       for="document_file_1">{{__("common.Browse")}} </label>
                                                                <input type="file" class="d-none" name="db_file"
                                                                       id="document_file_1">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                            title="">
                                                        <span class="ti-check"></span>
                                                        {{ __('common.Update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 ">
                    <div class="row">
                        <div class="col-lg-12 no-gutters">

                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">@lang('common.Database Backup List')</h3>
                                     @if(permissionCheck('backup.create'))
                                <ul class="pull-right">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="{{route('backup.create')}}"><i
                                                class="ti-plus"></i>{{__('common.Generate New Backup')}}</a></li>
                                </ul>
                            @endif

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mt-10">
                        <div class="col-lg-12 mt-10">

                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="mt-30">
                                        <table class="table Crm_table_active3">
                                            <thead>
                                            @include('backEnd.partials.alertMessagePageLevelAll')
                                            <tr>
                                                <th width="30%">@lang('common.sl')</th>
                                                <th width="30%">@lang('common.date')</th>
                                                <th width="40%">@lang('common.file_name')</th>
                                                <th width="40%">@lang('common.download')</th>
                                                <th width="40%">@lang('common.action')</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($allBackup as $key => $value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$value}}</td>
                                                    <td>{{"infix_trading_db_$value".'.sql'}}</td>
                                                    <td class="text-center">
                                                       @if(!env('APP_SYNC'))
                                                         <a href="{{ asset('public/database-backup/'.$value.'/'.$value.'-dump.sql') }}"
                                                            download="{{ "infix_biz_db_$value".'.sql' }}"><i
                                                                class="fa fa-download"></i></a>
                                                       @else

                                                        <span style="cursor: pointer;" data-toggle="tooltip" title="Restricted in demo mode"><i
                                                                class="fa fa-download"></i></a>

                                                       @endif

                                                            </td>

                                                    <td>
                                                        @if(permissionCheck('backup.delete'))

                                                            <a href="{{ route('backup.delete', $value) }}"
                                                               class="dropdown-item"
                                                               type="button">@lang('common.Delete')</a>

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
