@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('attendance.Select Criteria') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white pb-3">
                        <form class="" action="{{ route('bill.search') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Supplier') }}</label>
                                        <select class="primary_select mb-15" name="supplier_id" id="supplier_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ isset($supplier_id) && $supplier->id == $supplier_id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                                @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('supplier_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Customer') }}</label>
                                        <select class="primary_select mb-15" name="customer_id" id="customer_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ isset($customer_id) && $customer->id == $customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                                @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('supplier_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.From Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date" class="primary_input_field primary-input date form-control" id="date" type="text" name="from_date" value="{{isset($from_date) ? $form_date : ''}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                            <span class="text-danger">{{$errors->first('from_date')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.To Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date" class="primary_input_field primary-input date form-control" id="date" type="text" name="to_date" value="{{isset($to_date) ? $to_date : ''}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                            <span class="text-danger">{{$errors->first('to_date')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                    <div class="primary_input">
                                        <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                                class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>
                                    <div class="primary_input ml-2">
                                        <a href="{{route('user.bill')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                                class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($accounts)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Purchases Report') }}</h3>
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
                                            <th scope="col">{{__('sale.Sl')}}</th>
                                            <th scope="col">{{__('quotation.Date')}}</th>
                                            <th scope="col">{{__('quotation.Invoice No')}}</th>
                                            <th scope="col">{{__('quotation.Reference No')}}</th>
                                            <th scope="col">{{__('quotation.Total Amount')}}</th>
                                            <th scope="col">{{__('quotation.Paid Amount')}}</th>
                                            <th scope="col">{{__('purchase.Return Amount')}}</th>
                                            <th scope="col">{{__('quotation.Due Amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $total_due = 0;
                                        $given_amount = 0;
                                        $return_amount = 0;
                                        @endphp
                                        @foreach($accounts as $key=> $account)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{date(app('general_setting')->dateFormat->format, strtotime($account->date))}}</td>
                                                <td>{{$account->invoice_no}}</td>
                                                <td>{{$account->ref_no}}</td>
                                                @php
                                                $due = $account->payable_amount - ($account->amount['given_amount'] - $account->amount['return_amount']);
                                                $total_due += $due;
                                                $given_amount += $account->amount['given_amount'];
                                                $return_amount += $account->amount['return_amount'];
                                                @endphp
                                                <td>{{@single_price($account->payable_amount)}}</td>
                                                <td>{{@single_price($account->amount['given_amount'])}}</td>
                                                <td>{{@single_price($account->amount['return_amount'])}}</td>
                                                <td>{{@single_price($due)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4"><b>{{__('report.Total')}} :</b></td>
                                            <td>{{single_price($accounts->sum('payable_amount'))}}</td>
                                            <td>{{single_price($given_amount)}}</td>
                                            <td>{{single_price($return_amount)}}</td>
                                            <td>{{single_price($total_due)}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    {{$accounts->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </section>
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script>
        function getDetails(el) {
            $.post('{{ route('get_purchase_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#purchase_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
