@extends('layouts.dashboard')

@section('page-title', __('Company Information'))
@section('estimate-number', __('Company Information'))
@section('page-heading', __('Company Information'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Company Information')
    </li>
@stop

@section('content')
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-xl-7">
                <div class="card full-height">
                    <div class="card-content">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h2>Company Demographics</h2>
                            @permission('company.edit') <span class="text-primary"><i class="fas fa-edit"></i></span> @endpermission
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$company->company_name ?? 'Not Listed'}}

                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    EIN: {{$company->ein ?? 'Not Listed'}}

                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sales Certificate: {{$company->salesCertificate ?? 'Not Listed'}}

                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Address:

                                        {{$company->house ?? ''}} {{$company->street ?? ''}} <br/>
                                        {{$company->city ?? ''}} {{$company->state ?? ''}} {{$company->zip ?? ''}}


                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Phone: {{$company->phone ?? ''}}

                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Main Contact: {{$company->primaryContact->first_name ?? ''}} {{$company->primaryContact->last_name ?? ''}}

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card ">
                            <div class="card-content">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h2>Company Logo</h2>
                                    @permission('companyLinks.edit') <span class="text-primary"><i class="fas fa-edit"></i></span> @endpermission
                                </div>
                                <div class="card-body">
                                    <img src="{{$company->logo}}" alt="navbar brand" class="img-fluid navbar-brand">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h2>Google Review Link</h2>
                                    @permission('companyLinks.edit') <span class="text-primary"><i class="fas fa-edit"></i></span> @endpermission
                                </div>
                                <div class="card-body">
                                    {{$company->googleReview ?? 'No Google Review Link Provided'}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-title justify-content-between align-items-center">
                                    <h2>Facebook Link</h2>
                                    @permission('companyLinks.edit') <span class="text-primary"><i class="fas fa-edit"></i></span> @endpermission
                                </div>
                                <div class="card-body">
                                    {{$company->facebookReview ?? 'No Facebook Review Link Provided'}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row">
        <!--
        <div class="col">
            <div class="card full-height">
                <div class="card-title">
                    <h2>Customer Email Templates</h2>
                </div>
                <div class="card-body">
                    <a href="/estimateapproved/{{Auth()->user()->companyId}}"><button class="btn btn-primary btn-block mb-3">Estimate Approval</button></a>

                    <button class="btn btn-primary btn-block mb-3">Estimate Approved</button>

                    <button class="btn btn-primary btn-block mb-3">Tech Enroute</button>

                    <button class="btn btn-primary btn-block mb-3">Tech Arrived</button>

                    <button class="btn btn-primary btn-block mb-3">Inspection Complete</button>

                    <button class="btn btn-primary btn-block mb-3">Customer Meeting</button>

                    <button class="btn btn-primary btn-block mb-3">Work In Progress</button>

                    <button class="btn btn-primary btn-block mb-3">Customer Inspection</button>

                    <button class="btn btn-primary btn-block mb-3">Job Complete</button>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card full-height">
                <div class="card-title">
                    <h2>Customer Text Templates</h2>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-block mb-3">Estimate Approval</button>

                    <button class="btn btn-primary btn-block mb-3">Estimate Approved</button>

                    <button class="btn btn-primary btn-block mb-3">Tech Enroute</button>

                    <button class="btn btn-primary btn-block mb-3">Tech Arrived</button>

                    <button class="btn btn-primary btn-block mb-3">Inspection Complete</button>

                    <button class="btn btn-primary btn-block mb-3">Customer Meeting</button>

                    <button class="btn btn-primary btn-block mb-3">Work In Progress</button>

                    <button class="btn btn-primary btn-block mb-3">Customer Inspection</button>

                    <button class="btn btn-primary btn-block mb-3">Job Complete</button>
                </div>
            </div>
        </div>
        -->
        <div class="col">
            <div class="card full-height">
                <div class="card-title">
                    <h2>Payment Processing</h2>
                </div>
                <div class="card-body">
                    Feature in future release.
                </div>
            </div>
        </div>
    </div>


    </div>


@stop



@section('scripts')

@stop
