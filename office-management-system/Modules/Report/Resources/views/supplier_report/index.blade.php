@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Suppliers </h3>

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
                                <th scope="col">Sl</th>
                                <th scope="col">ID</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Pay Term</th>
                                <th scope="col">Tax Number</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suppliers as $key => $supplier_value)
                                <tr>
                                    <th scope="col">
                                        <label class="primary_checkbox d-flex">
                                            <input name="sms1" type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th>{{$key+1}}</th>
                                    <td>{{$supplier_value->contact_id}}</td>
                                    <td>{{$supplier_value->name}}</td>
                                    <td>{{$supplier_value->email}}</td>
                                    <td>{{$supplier_value->mobile}}</td>
                                    <td>{{$supplier_value->pay_term}} {{$supplier_value->pay_term_condition}} </td>
                                    <td>{{$supplier_value->tax_number}}</td>
                                    <td>
                                        <!-- shortby  -->
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                select
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                <a href="{{ route('supplier_report.history', $supplier_value->id) }}" class="dropdown-item" type="button">Account History</a>
                                                <a href="{{route('supplier.view',$supplier_value->id)}}" target="_blank" class="dropdown-item" type="button">View</a>
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
        <div class="modal fade admin-query" id="Import_Customer">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Customer</h4>
                        <button type="button" class="close " data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <p>Opposed to using Content here, content here, making it look like readable
                                        English. </p>
                                </div>
                                <div class="col-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="">Choose CSV File</label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName"
                                                   placeholder="Browse CSV file" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="document_file_1">Browse</label>
                                                <input type="file" class="d-none" name="file" id="document_file_1">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                data-dismiss="modal" type="button"><i class="ti-check"></i> Import Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Import Lead -->
    </div>
@endsection
