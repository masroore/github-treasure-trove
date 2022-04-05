@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.Customers')}} </h3>

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
                                <th scope="col">{{__('common.Sl')}}</th>
                                <th scope="col">{{__('common.ID')}}</th>
                                <th scope="col">{{__('common.Customer Name')}}</th>
                                <th scope="col">{{__('common.Email')}}</th>
                                <th scope="col">{{__('common.Phone')}}</th>
                                <th scope="col">{{__('common.Pay Term')}}</th>
                                <th scope="col">{{__('common.Tax Number')}}</th>
                                <th scope="col">{{__('common.Group')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $key => $customer_value)
                                <tr>
                                    <th scope="col">
                                        <label class="primary_checkbox d-flex">
                                            <input name="sms1" type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th>{{$key+1}}</th>
                                    <td>{{$customer_value->contact_id}}</td>
                                    <td>{{$customer_value->name}}</td>
                                    <td>{{$customer_value->email}}</td>
                                    <td>{{$customer_value->mobile}}</td>
                                    <td>{{$customer_value->pay_term}} {{$customer_value->pay_term_condition}} </td>
                                    <td>{{$customer_value->tax_number}}</td>
                                    <td>{{$customer_value->customer_group}}</td>
                                    <td>
                                        <!-- shortby  -->
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                select
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                 <a href="{{route('customer.view',$customer_value->id)}}" class="dropdown-item">View</a>

                                                 <a href="{{ route('customer_report.history', $customer_value->id) }}" class="dropdown-item">Account History</a>
                                            </div>
                                        </div>
                                        <!-- shortby  -->
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
    <div id="Customer_info">

    </div>
@endsection
@push("scripts")
   
@endpush
