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
                            <h3 class="mb-0 mr-30" >{{ __('common.Login - Logut Activity') }}</h3>
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
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.User') }}</th>
                                        <th scope="col">{{ __('common.Login At') }}</th>
                                        <th scope="col">{{ __('common.Logout At') }}</th>
                                        <th scope="col">{{ __('setting.IP') }}</th>
                                        <th scope="col">{{ __('setting.Agent') }}</th>
                                        <th scope="col">{{ __('common.Description') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activities as $key => $activity)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $activity->user->name }}</td>
                                            <td>{{ $activity->login_time }}</td>
                                            <td>{{ $activity->logout_time }}</td>
                                            <td>{{ $activity->ip }}</td>
                                            <td>{{ $activity->agent }}</td>
                                            <td>{{ $activity->subject }}</td>
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
