@extends('backEnd.master')
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30" >{{ __('common.Activity Logs') }}</h3>
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
                                        <th scope="col">
                                            <label class="primary_checkbox d-flex ">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Description') }}</th>
                                        <th scope="col">{{ __('common.Model') }}</th>
                                        <th scope="col">{{ __('common.Attempted At') }}</th>
                                        <th scope="col">{{ __('common.User') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activities as $key=>$activity)
                                        <tr>

                                            <th scope="col">
                                                <label class="primary_checkbox d-flex">
                                                    <input name="sms1" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $activity->description }}</td>
                                            <td>
                                                @if ($activity->subject_type != null)
                                                    @php
                                                        $a = explode("\\", $activity->subject_type);
                                                    @endphp
                                                    {{ end($a) }}
                                                @endif
                                            </td>
                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($activity->created_at)) }}</td>
                                            <td>{{ userName($activity->causer_id) }}</td>
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
    </section>
@endsection
