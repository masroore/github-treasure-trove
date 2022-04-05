@extends('backEnd.master')
@section('mainContent')
    <section class="mb-40 student-details">
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @elseif(session()->has('message-danger'))
            <div class="alert alert-danger">
                {{ session()->get('message-danger') }}
            </div>
        @endif
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Start Student Meta Information -->
                    <div class="main-title">
                        <h3 class="mb-20">@lang('common.Staff Info')</h3>
                    </div>
                    <div class="student-meta-box">
                        <div class="student-meta-top"></div>
                        <img class="student-meta-img img-100"
                             src="{{ file_exists(@$staffDetails->user->avatar) ? asset(@$staffDetails->user->avatar) : asset('public/img/profile.jpg') }}"
                             alt="">
                        <div class="white-box radius-t-y-0">
                            <div class="single-meta mt-10">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('common.Name') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($staffDetails)){{@$staffDetails->user->name}}@endif
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->role_id != 1)
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Employee Id') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($staffDetails)){{$staffDetails->employee_id}}@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Opening Balance') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($staffDetails)){{single_price($staffDetails->opening_balance)}}@endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('role.Role') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($staffDetails)){{@$staffDetails->user->role->name}}@endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('department.Department') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($staffDetails)){{ !empty($staffDetails->department != null)? $staffDetails->department->name:''}}@endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('showroom.Branch') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($staffDetails)){{ @$staffDetails->showroom->name }}@endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('inventory.Warehouse') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($staffDetails)){{ !empty($staffDetails->warehouse != null)? $staffDetails->warehouse->name:''}}@endif
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->role_id != 1)
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Date of Joining') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($staffDetails))
                                                {{ date(app('general_setting')->dateFormat->format, strtotime($staffDetails->date_of_joining)) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Employment Type') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($staffDetails))
                                                {{ $staffDetails->employment_type }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Last Date Of Provisional Period') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($staffDetails))
                                                {{ date(app('general_setting')->dateFormat->format, strtotime(\Carbon\Carbon::now()->addMonths($staffDetails->provisional_months))) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- End Student Meta Information -->
                </div>
                <!-- Start Student Details -->
                <div class="col-lg-9 staff-details">
                    <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#studentProfile" role="tab"
                               data-toggle="tab">{{ __('common.Profile') }}</a>
                        </li>
                        @if (auth()->user()->role_id != 1)
                            <li class="nav-item">
                                <a class="nav-link" href="#payroll" role="tab"
                                   data-toggle="tab">{{ __('payroll.Payroll') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#leaves" role="tab"
                                   data-toggle="tab">{{ __('leave.Leave') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#staffDocuments" role="tab"
                                   data-toggle="tab">{{ __('common.Documents') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#staffLoans" role="tab"
                                   data-toggle="tab">{{ __('common.Loan & Advance') }}</a>
                            </li>
                        @endif
                        <li class="nav-item edit-button">
                            <a href="#" class="primary-btn small fix-gr-bg"
                               data-toggle="modal" data-target="#profileEditForm">{{ __('common.Edit') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Start Profile Tab -->
                        <div role="tabpanel" class="tab-pane fade show active" id="studentProfile">
                            <div class="white-box">
                                <h4 class="stu-sub-head">{{ __('common.Personal Info') }}</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                {{ __('common.Phone') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                @if(isset($staffDetails)){{$staffDetails->phone}}@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                {{ __('common.Email') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                @if(isset($staffDetails)){{@$staffDetails->user->email}}@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (auth()->user()->role_id != 1)
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6">
                                                <div class="">
                                                    {{ __('common.Date of Birth') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <div class="">
                                                    @if(isset($staffDetails))
                                                        {{$staffDetails->date_of_birth != ""? date('m/d/Y', strtotime($staffDetails->date_of_birth)):''}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Start Parent Part -->
                                    <h4 class="stu-sub-head mt-40">{{ __('common.Address') }}</h4>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Current Address') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->current_address}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Permanent Address') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->permanent_address}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Parent Part -->
                                    <!-- Start Transport Part -->
                                    <h4 class="stu-sub-head mt-40">{{ __('common.Bank Account Details') }}</h4>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Account Name') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->bank_account_name}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Bank Account Number') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->bank_account_no}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Bank Name') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->bank_name}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Bank Branch Name') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    @if(isset($staffDetails)){{$staffDetails->bank_branch_name}}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Transport Part -->
                                @endif
                            </div>
                        </div>
                        <!-- End Profile Tab -->
                        @if(isset($staffDetails))<input type="hidden" name="user_id" id="user_id" value="{{ @$staffDetails->user->id }}">@endif
                    <!-- Start payroll Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="payroll">
                            <div class="white-box">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <table class="table Crm_table_active">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('payroll.Payslip')}} {{__('common.ID')}}</th>
                                                <th scope="col">{{__('attendance.Month')}}
                                                    -{{__('attendance.Year')}}</th>
                                                <th scope="col">{{__('attendance.Date')}}</th>
                                                <th scope="col">{{__('payroll.Payment Method')}}</th>
                                                <th scope="col">{{__('payroll.Net Salary')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($payrollDetails as $key => $payrollDetail)
                                                <tr>
                                                    <td>{{ $payrollDetail->id }}</td>
                                                    <td>{{ $payrollDetail->payroll_month }}
                                                        - {{ $payrollDetail->payroll_year }}</td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($payrollDetail->payment_date)) }}</td>
                                                    <td>{{ $payrollDetail->payment_mode }}</td>
                                                    <td>{{ single_price($payrollDetail->net_salary) }}</td>
                                                    <td>
                                                        @if ($payrollDetail->payroll_status == "G")
                                                            <span class="badge_3">{{ __('payroll.Generated') }}</span>
                                                        @elseif ($payrollDetail->payroll_status == "P")
                                                            <span class="badge_1">{{ __('payroll.Paid') }}</span>
                                                        @else
                                                            <span
                                                                class="badge_4">{{ __('payroll.Not generated') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($payrollDetail))
                                                            @if($payrollDetail->payroll_status == 'G')
                                                                <a title="Proceed to pay"
                                                                   onclick="payrollPayment({{ $payrollDetail->id }},{{ @$staffDetails->user->role_id }})">
                                                                    <button
                                                                        class="primary-btn btn-sm tr-bg">{{ __('payroll.Proceed To Pay') }}</button>
                                                                </a>
                                                            @endif
                                                            @if($payrollDetail->payroll_status == 'P')
                                                                <a onclick="viewSlip({{ $payrollDetail->id }})">
                                                                    <button
                                                                        class="primary-btn btn-sm tr-bg">{{ __('payroll.View PaySlip') }}</button>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a class=""
                                                               href="{{url('payroll/generate-Payroll/'.$staffDetails->user_id.'/'.$m.'/'.$y)}}">
                                                                <button
                                                                    class="primary-btn btn-sm tr-bg"> {{ __('payroll.Generate Payroll') }}</button>
                                                            </a>
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
                        <!-- End payroll Tab -->
                        <!-- Start leave Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="leaves">
                            @php
                                $remaining_leave_days = 0;
                                $extra_leave_days =  0;
                                if ($total_leave->sum('total_days') > $leaveDetails->sum('total_days')) {
                                    $remaining_leave_days = $total_leave->sum('total_days') - $leaveDetails->sum('total_days');
                                }else {
                                    $extra_leave_days =  $apply_leave_histories->sum('total_days') - $leaveDetails->sum('total_days');
                                }
                            @endphp
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('leave.Total Leave') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ $total_leave->sum('total_days') }} {{__('leave.Days')}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('leave.Remaining') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ $remaining_leave_days }} {{__('leave.Days')}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('leave.Extra Taken') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ $extra_leave_days }} {{__('leave.Days')}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white-box">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <table class="table Crm_table_active">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('leave.Leave')}} {{__('leave.Type')}}</th>
                                                <th scope="col">{{__('leave.Leave From')}}</th>
                                                <th scope="col">{{__('leave.Leave To')}}</th>
                                                <th scope="col">{{__('leave.Apply Date')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($leaveDetails as $key => $leaveDetail)
                                                <tr>
                                                    <td>{{ @$leaveDetail->leave_type->name }}</td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($leaveDetail->start_date)) }}</td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($leaveDetail->end_date)) }}</td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($leaveDetail->apply_date)) }}</td>
                                                    <td>
                                                        @if ($leaveDetail->status == 0)
                                                            <span class="badge_3">{{ __('common.Pending') }}</span>
                                                        @elseif ($leaveDetail->status == 1)
                                                            <span class="badge_1">{{ __('common.Approved') }}</span>
                                                        @else
                                                            <span class="badge_4">{{ __('common.Cancelled') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown CRM_dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenu2" data-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                {{ __('common.Select') }}
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                 aria-labelledby="dropdownMenu2">
                                                                <a href="#" class="dropdown-item"
                                                                   onclick="edit_apply_leave_modal({{ $leaveDetail->id }})">{{__('common.View')}}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End leave Tab -->
                        <!-- Start Documents Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="staffDocuments">
                            <div class="white-box">
                                <div class="text-right mb-20">
                                    <button type="button" data-toggle="modal" data-target="#add_document_madal"
                                            class="primary-btn tr-bg text-uppercase bord-rad">
                                        {{__('common.Upload Document')}}
                                        <span class="pl ti-upload"></span>
                                    </button>
                                </div>
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <table class="table Crm_table_active">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.Document Title')}}</th>
                                                <th scope="col">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($staffDocuments)
                                                @foreach ($staffDocuments as $key => $staffDocument)
                                                    <tr>
                                                        <td><a href="{{asset($staffDocument->documents)}}" download
                                                               target="_blank">{{ $staffDocument->name }}</a></td>
                                                        <td>
                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="dropdownMenu2" data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{ __('common.Select') }}
                                                                </button>
                                                                @php
                                                                    $ids = [1,2];
                                                                @endphp
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                     aria-labelledby="dropdownMenu2">
                                                                    <a href="{{asset($staffDocument->documents)}}"
                                                                       class="dropdown-item"
                                                                       download>{{__('common.Download')}}</a>
                                                                    @if (!in_array($staffDocument->user->role_id,$ids))
                                                                        <a onclick="confirm_modal('{{route('staff_document.destroy', $staffDocument->id)}}');"
                                                                           class="dropdown-item">{{__('common.Delete')}}</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Documents Tab -->
                        <!-- Add Document modal form start-->
                        <div class="modal fade admin-query" id="add_document_madal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{__('common.Upload Document')}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <form class="" action="{{ route('staff_document.store') }}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="staff_id" value="{{$staffDetails->id}}">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.Name') }}</label>
                                                            <input name="name" class="primary_input_field name"
                                                                   placeholder="{{ __('common.Name') }}" type="text"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="primary_input mb-15">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.Avatar') }}</label>
                                                            <div class="primary_file_uploader">
                                                                <input class="primary-input" type="text"
                                                                       id="placeholderFileOneName"
                                                                       placeholder="Browse file" readonly="">
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="document_file_1">{{ __('common.Browse') }}</label>
                                                                    <input type="file" class="d-none" name="file"
                                                                           id="document_file_1">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center mt-40">
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                    data-dismiss="modal">{{ __('common.Cancel') }}</button>
                                                            <button class="primary-btn fix-gr-bg"
                                                                    type="submit">{{ __('common.Save') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="staffLoans">
                            @php
                                $total_return_loan = $loans->sum('paid_loan_amount');
                                $total_loan = $loans->sum('amount');
                                $due = $total_loan - $total_return_loan;
                                $total_monthly_installment = $loans->where('paid', 0)->sum('monthly_installment');
                            @endphp
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('common.Total Loan') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ single_price($total_loan) }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('common.Returned Amount') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ single_price($total_return_loan) }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('common.Due') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ single_price($due) }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="white-box single-summery">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>{{ __('common.Monthly Installment') }}</h3>
                                            </div>
                                            <h1 class="gradient-color2">{{ single_price($total_monthly_installment) }}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white-box">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <table class="table Crm_table_active">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('common.ID') }}</th>
                                                <th scope="col">{{ __('common.Name') }}</th>
                                                <th scope="col">{{ __('common.Type') }}</th>
                                                <th scope="col">{{ __('common.Amount') }}</th>
                                                <th scope="col">{{ __('common.Monthly Installment') }}</th>
                                                <th scope="col">{{ __('common.Due') }}</th>
                                                <th scope="col">{{ __('common.Approval') }}</th>
                                                <th scope="col">{{ __('common.Status') }}</th>
                                                <th scope="col">{{ __('common.Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($loans)
                                                @foreach($loans as $key => $loan)
                                                    @if ($loan->user != null)
                                                        <tr>
                                                            <th>{{ $key+1 }}</th>
                                                            <td>{{ $loan->user != null ? $loan->user->name : "Removed" }}</td>
                                                            <td>{{ $loan->loan_type }}</td>
                                                            <td>{{ single_price($loan->amount) }}</td>
                                                            <td>{{ single_price($loan->monthly_installment) }}</td>
                                                            @php
                                                                $due = $loan->amount - $loan->paid_loan_amount;
                                                            @endphp
                                                            <td>{{ single_price($due) }}</td>
                                                            <td>
                                                                @if ($loan->approval == 0)
                                                                    <span
                                                                        class="badge_3">{{__('common.Pending')}}</span>
                                                                @elseif ($loan->approval == 1)
                                                                    <span
                                                                        class="badge_1">{{__('common.Approved')}}</span>
                                                                @else
                                                                    <span
                                                                        class="badge_4">{{__('common.Cancelled')}}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($loan->paid == 0)
                                                                    <span
                                                                        class="badge_3">{{__('common.Running')}}</span>
                                                                @else
                                                                    <span
                                                                        class="badge_1">{{__('common.Complete')}}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- shortby  -->
                                                                <div class="dropdown CRM_dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle"
                                                                            type="button" id="dropdownMenu2"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        {{ __('common.Select') }}
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right"
                                                                         aria-labelledby="dropdownMenu2">
                                                                         @if(permissionCheck('applied_loans.show'))
                                                                        <a href="#"
                                                                           onclick="ApplyLoanDetails({{ $loan->id }})"
                                                                           class="dropdown-item">{{__('common.View')}}</a>
                                                                         @endif
                                                                        @if ($loan->approval != 1)
                                                                            <a onclick="confirm_modal('{{route('apply_loans.destroy', $loan->id)}}');"
                                                                               class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                                        @endif
                                                                        <a href="#" class="dropdown-item">{{__('common.Access Denied')}}</a>
                                                                    </div>
                                                                </div>
                                                                <!-- shortby  -->
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endisset
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
    <div class="edit_form">

    </div>
    @php
    $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    <div class="modal fade admin-query" id="profileEditForm">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Edit Profile') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Name') }} <span class="text-danger">*</span></label>
                                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" value="{{ $user->name }}" type="text">
                                </div>
                                @error('name')
                                {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('name'))}}
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Email') }} <span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field name" placeholder="{{ __('common.Email') }}" value="{{ $user->email }}" type="email" readonly>
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Phone') }} </label>
                                    <input name="phone" value="{{$user->staff->phone}}" class="primary_input_field name" placeholder="{{ __('common.Phone') }}" type="tel">
                                    @error('phone')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('phone'))}}
                                    @enderror
                                </div>
                            </div>

                            @if (auth()->user()->role_id != 1)
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Current Address') }} <span class="text-danger">*</span></label>
                                        <input name="current_address" value="{{$user->staff->current_address}}" class="primary_input_field name" placeholder="{{ __('common.Current Address') }}"  type="text">
                                    </div>
                                    @error('current_address')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('current_address'))}}
                                    @enderror
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Permanent Address') }} <span class="text-danger">*</span></label>
                                        <input name="permanent_address" value="{{$user->staff->permanent_address}}" class="primary_input_field name" placeholder="{{ __('common.Permanent Address') }}" type="text">
                                    </div>
                                </div>
                                @error('permanent_address')
                                {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('permanent_address'))}}
                                @enderror
                            @endif

                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.Avatar') }}</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="placeholderFileTwoName" placeholder="Browse file" readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_2">{{ __('common.Browse') }}</label>
                                            <input type="file" class="d-none" name="avatar" id="document_file_2">
                                        </button>
                                    </div>
                                </div>

                            </div>
                            @if (auth()->user()->role_id != 1)
                                <div class="col-xl-12 mt-5">
                                    <div class="main-title d-flex">
                                        <h3 class="mb-0 mr-30">{{ __('common.Bank Info') }}</h3>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Bank Name') }} <span class="text-danger">*</span></label>
                                        <input name="bank_name" class="primary_input_field name" placeholder="{{ __('common.Bank Name') }}" value="{{ $user->staff != null ? $user->staff->bank_name : "" }}" type="text">
                                    </div>
                                    @error('bank_name')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('bank_name'))}}
                                    @enderror
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Bank Branch Name') }} <span class="text-danger">*</span></label>
                                        <input name="bank_branch_name" class="primary_input_field name" placeholder="{{ __('common.Bank Branch Name') }}" value="{{ $user->staff != null ? $user->staff->bank_branch_name : "" }}" type="text">
                                    </div>
                                    @error('bank_branch_name')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('bank_branch_name'))}}
                                    @enderror
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Account Name') }} <span class="text-danger">*</span></label>
                                        <input name="bank_account_name" class="primary_input_field name" placeholder="{{ __('common.Account Name') }}" value="{{ $user->staff != null ? $user->staff->bank_account_name : "" }}" type="text">
                                    </div>
                                    @error('bank_account_name')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('bank_account_name'))}}
                                    @enderror
                                </div>

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Bank Account Number') }} <span class="text-danger">*</span></label>
                                        <input name="bank_account_no" class="primary_input_field name" placeholder="{{ __('common.Bank Account Number') }}" value="{{ $user->staff != null ? $user->staff->bank_account_no : "" }}" type="text">
                                    </div>
                                </div>
                                @error('bank_account_no')
                                {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('bank_account_no'))}}
                                @enderror
                            @endif

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        function edit_apply_leave_modal(el) {
            var user_id = $('#user_id').val();
            $.post('{{ route('apply_leave.view') }}', {
                _token: '{{ csrf_token() }}',
                id: el,
                user_id: user_id
            }, function (data) {
                $('.edit_form').html(data);
                $('#Apply_Leave_Edit').modal('show');
                $('select').niceSelect();
            });
        }

        function payrollPayment(el, role_id) {
            $.post('{{ route('payroll_payment_modal') }}', {
                _token: '{{ csrf_token() }}',
                id: el,
                role_id: role_id
            }, function (data) {
                $(".edit_form").html(data);
                $('#PaymentForm').modal('show');
                $('select').niceSelect();
            });
        }

        function viewSlip(el) {
            $.post('{{ route('payroll_view_slip_modal') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $(".edit_form").html(data);
                $('#SlipForm').modal('show');
            });
        }

        function ApplyLoanDetails(el) {
            $.post('{{ route('applied_loans.show') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('.edit_form').html(data);
                $('#ApplyLoanview').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
