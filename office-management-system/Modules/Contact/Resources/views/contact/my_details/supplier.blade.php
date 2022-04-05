@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('common.Supplier') }} {{__('common.Profile')}}</h3>
                        </div>

                        
                    </div>




                    <div class="row ">
                        <div class="col-lg-6 col-xl-4 col-md-6 mb_60">
                            <div class="supplier_img mb_15">
                                <img src="{{ file_exists(@$supplier->avatar) ? asset(@$supplier->avatar) : asset('public/img/profile.jpg') }}" alt="">
                            </div>
                            <h3 class="f_s_23 f_w_400 mb_15">{{ $supplier->name }}</h3>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.Email')}}:</span>
                                <span class="f_s_14 f_w_400 theme_text" ><a href="#" class="inderline_text_lisk">{{ $supplier->email }}</a></span>
                            </div>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.Mobile')}}: </span>
                                <span class="f_s_14 f_w_400 theme_text" >{{ $supplier->mobile }}</span>
                            </div>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.Address')}}: </span>
                                <span class="f_s_14 f_w_400 theme_text" >{{ $supplier->address }}</span>
                            </div>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.City')}}: </span>
                                <span class="f_s_14 f_w_400 theme_text" >{{ @$supplier->district->name }}</span>
                            </div>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.State')}}: </span>
                                <span class="f_s_14 f_w_400 theme_text" >{{ @$supplier->division->name }}</span>
                            </div>
                            <div class="grid_template mb-10">
                                <span class="f_s_14 f_w_400 theme_text" >{{__('contact.Tax Number')}}:  </span>
                                <span class="f_s_14 f_w_400 theme_text" >{{$supplier->tax_number }}</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 mb_60">
                            <div class="purchage_widget">
                                <h4 class="f_s_20 f_w_500 mb_20">{{__('contact.Purchase Information')}}</h4>
                                <div class="grid_template mb-20">
                                    <span class="f_s_14 f_w_400 theme_text">{{__('contact.Total Invoice')}}:  </span>
                                    <span class="f_s_14 f_w_400 theme_text"> {{$supplier->accounts['total_invoice']}}</span>
                                </div>
                                <div class="grid_template mb-20">
                                    <span class="f_s_14 f_w_400 theme_text">{{__('contact.Total Due')}}:  </span>
                                    <span class="f_s_14 f_w_400 theme_text"> {{$supplier->accounts['due_invoice']}}</span>
                                </div>
                                <a class="primary-btn radius_30px fix-gr-bg" href="{{ route('contact.my_products') }}"><i class="fas fa-list"></i>{{__('contact.View Products')}}</a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 mb_60">
                            <div class="purchage_widget">
                                <div class="grid_template mb-10">
                                    <span class="f_s_14 f_w_400 theme_text">{{__('contact.Total Balance')}}:</span>
                                    <span class="f_s_14 f_w_400 required_text">{{single_price($supplier->accounts['total'])}}</span>
                                </div>
                                <div class="grid_template mb-10">
                                    <span class="f_s_14 f_w_400 theme_text">{{__('contact.Total Due')}}:</span>
                                    <span class="f_s_14 f_w_400 required_text ">{{single_price($supplier->accounts['due'])}}</span>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col">
                            <label class="primary_input_label" for="">
                                @php
                                echo $supplier->note;
                                @endphp
                            </label>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <!-- Start Sms Details -->
                        <div class="col-lg-12 student-details">
                            <ul class="nav nav-tabs tab_column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#Invoice" role="tab" data-toggle="tab">{{ __('common.Invoice') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Return" role="tab" data-toggle="tab">{{ __('common.Return') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#Transactions" role="tab" data-toggle="tab">{{__('common.Transactions')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane fade show active" id="Invoice">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table class="table Crm_table_active">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{__('sale.Date')}}</th>
                                                                    <th scope="col">{{__('sale.Invoice')}}</th>
                                                                    <th scope="col">{{__('sale.Reference No')}}</th>
                                                                    <th scope="col">{{__('quotation.Supplier')}}</th>
                                                                    <th scope="col">{{__('common.Purchesed By')}}</th>
                                                                    <th scope="col">{{__('common.Paid Status')}}</th>
                                                                    <th scope="col">{{__('common.Amount')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $total = 0;
                                                                @endphp
                                                                @foreach ($supplier->purchases as $key => $purchase)
                                                                @php
                                                                $total += $purchase->amount;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($purchase->created_at)) }}</td>
                                                                    <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->invoice_no}}</a></td>
                                                                    <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->ref_no}}</a></td>
                                                                    <td>
                                                                        @if ($purchase->supplier_id)
                                                                        {{@$purchase->supplier->name}}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{@$purchase->user->name}}</td>
                                                                    <td>
                                                                        @if ($purchase->is_paid == 0)
                                                                        <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                                                        @elseif ($purchase->is_paid == 1)
                                                                        <h6><span class="badge_4">{{__('sale.Partial')}}</span></h6>
                                                                        @else
                                                                        <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $purchase->amount }}</td>
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="6">{{ __('common.Total') }}</td>
                                                                    <td colspan="1">{{ $total }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Return">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table class="table Crm_table_active">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{__('sale.Date')}}</th>
                                                                    <th scope="col">{{__('sale.Reference No')}}</th>
                                                                    <th scope="col">{{__('common.Customer')}}</th>
                                                                    <th scope="col">{{__('common.Paid Status')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($supplier->purchases->where('return_status', 1) as $key => $sale)
                                                                <tr>
                                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                                    <td><a onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                                    <td>
                                                                        @if ($sale->supplier)
                                                                        {{@$sale->supplier->name}}
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if ($sale->return_status == 0)
                                                                        <h6><span class="badge_4">{{__('common.Pending')}}</span></h6>
                                                                        @else
                                                                        <h6><span class="badge_1">{{__('common.Approve')}}</span></h6>
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

                                <div role="tabpanel" class="tab-pane fade" id="Transactions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        @include('contact::contact.credit_transaction_list_table', ['chartAccount' => Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $supplier->id)->first()])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="getDetails">

</div>
@include('contact::contact.minus_balance_modal_supplier')
@include('contact::contact.add_balance_modal_supplier')
@endsection
@push("scripts")
<script type="text/javascript">
    function getDetails(el){
        $.post('{{ route('get_purchase_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
            $('#getDetails').html(data);
            $('#purchase_info_modal').modal('show');
            $('select').niceSelect();
        });
    }
    $(document).ready(function () {
        $('.payment_from_div').hide();
        $(".bank_branch_div").hide();
        $(".bank_name_div").hide();
        $(".cheque_date_div").hide();
        $(".cheque_no_div").hide();
    });

    function get_accounts()
    {
        var account_cat_id = $('#payment_from_type').val();
        $.post('{{ route('get_accounts_for_payment') }}', {_token:'{{ csrf_token() }}', id:account_cat_id}, function(data){
            $('.payment_from_account').html(data);
            $('.payment_from_div').show();
            $('select').niceSelect();
        });
        if (account_cat_id == 1) {
            $("#bank_branch").attr('disabled', true);
            $("#bank_name").attr('disabled', true);
            $("#cheque_date").attr('disabled', true);
            $("#cheque_no").attr('disabled', true);
            $(".bank_branch_div").hide();
            $(".bank_name_div").hide();
            $(".cheque_date_div").hide();
            $(".cheque_no_div").hide();
        }
        else if (account_cat_id == 2) {
            $("#bank_branch").removeAttr("disabled");
            $("#bank_name").removeAttr("disabled");
            $("#cheque_date").removeAttr("disabled");
            $("#cheque_no").removeAttr("disabled");
            $(".bank_branch_div").show();
            $(".bank_name_div").show();
            $(".cheque_date_div").show();
            $(".cheque_no_div").show();
        }
    }
</script>
@endpush
