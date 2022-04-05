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

                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('add_contact.edit',$supplier->id)}}"><i class="ti-pen"></i>{{ __('common.Edit') }}</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12">
                                <img class="student-meta-img img-100 mb-3" src="{{ file_exists(@$supplier->avatar) ? asset(@$supplier->avatar) : asset('frontend/img/user.png') }}"  alt="">
                                <h3>{{$supplier->name}}</h3>
                                <table class="table table-borderless supplier_view">
                                    <tr><td>{{ __('common.Name') }}</td><td>: <span class="ml-1"></span>{{ $supplier->name }}</td></tr>
                                    <tr><td>{{ __('common.Email') }}</td><td>: <span class="ml-1"></span>{{ $supplier->email }}</td></tr>
                                    <tr><td>{{ __('common.Phone') }}</td><td>: <span class="ml-1"></span>{{ $supplier->mobile }}</td></tr>
                                    <tr><td>{{ __('common.Pay Term') }}</td><td>: <span class="ml-1"></span>{{ $supplier->pay_term }}</td></tr>
                                    <tr><td>{{ __('common.Pay Condition') }}</td><td>: <span class="ml-1"></span>{{ $supplier->pay_term_condition }}</td></tr>
                                    <tr><td>{{ __('common.Address') }}</td><td>: <span class="ml-1"></span>{{ $supplier->address }}</td></tr>
                                    <tr><td>{{ __('contact.Country') }}</td><td>: <span class="ml-1"></span>{{ @$supplier->country->name }}</td></tr>
                                    <tr><td>{{ __('contact.State') }}:</td><td>: <span class="ml-1"></span>{{ $supplier->state }}</td></tr>
                                    <tr><td>{{ __('contact.City') }}:</td><td>: <span class="ml-1"></span>{{ @$supplier->city }}</td></tr>
                                    <tr><td>{{ __('common.Tax Number') }}</td><td>: <span class="ml-1"></span>{{ $supplier->tax_number }}</td></tr>
                                    <tr><td>{{ __('common.Opening Balance') }}</td><td>: <span class="ml-1"></span>{{ single_price($supplier->opening_balance) }}</td></tr>
                                    <tr><td>{{ __('common.Registered Date') }}</td><td>: <span class="ml-1"></span>{{ date(app('general_setting')->dateFormat->format, strtotime($supplier->created_at)) }}</td></tr>
                                    <tr>
                                        <td>{{ __('common.Active Status') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if ($supplier->is_active == 1)
                                                <span class="badge_1">{{__('common.Active')}}</span>
                                            @else
                                                <span class="badge_4">{{__('common.DeActive')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-2 col-lg-2 col-sm-12 supplier_profile">
                                <h3>{{__('purchase.Purchase Information')}}</h3>
                                <table class="table table-borderless supplier_view">
                                    <tr><td>{{__('purchase.Total Invoice')}} : {{$supplier->accounts['total_invoice']}}</td></tr>
                                    <tr><td>{{__('purchase.Due Invoice')}} : {{$supplier->accounts['due_invoice']}}</td></tr>
                                </table>
                                <a href="{{ route('supplierPurchaseProductList', $supplier->id) }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-bars"></i> {{__('product.Products')}}</a>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-12"></div>
                            <div class="col-md-4 col-lg-4 col-sm-12 supplier_profile">
                                <h3>{{__('sale.Finance Information')}}</h3>
                                <table class="table table-borderless supplier_view">
                                    @if ($supplier->accounts)
                                        <tr><td>{{__('purchase.Total Purchase')}} : {{single_price($supplier->accounts['total'])}}</td></tr>
                                        <tr><td>{{__('purchase.Due Balance')}} : {{single_price($supplier->accounts['due'])}}</td></tr>
                                    @endif
                                        <tr><td> <small>['{{__('purchase.Total Purchase = Purchase + Opening Balance')}}']</small> </td></tr>
                                </table>
                                <a data-toggle="modal" data-target="#addBalanceModal" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-bars"></i>{{__('purchase.Add Balance')}}</a>
                                <a data-toggle="modal" data-target="#substractBalanceModal" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-minus"></i>{{__('purchase.Subtract Balance')}}</a>
                            </div>
                        </div>
                        <hr>
                        @if ($supplier->note != null)
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
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="col-lg-12 student-details">
                            <ul class="nav nav-tabs tab_column mb-50 border-0" role="tablist">
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
                            <div class="tab-content pt-30">

                                <div role="tabpanel" class="tab-pane fade show active" id="Invoice">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table class="table Crm_table_active4">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{__('Common.No')}}</th>
                                                                    <th scope="col">{{__('sale.Date')}}</th>
                                                                    <th scope="col">{{__('sale.Invoice')}}</th>
                                                                    <th scope="col">{{__('sale.Reference No')}}</th>
                                                                    {{-- <th scope="col">{{__('quotation.Supplier')}}</th> --}}
                                                                    <th scope="col">{{__('common.Purchesed By')}}</th>
                                                                    <th scope="col">{{__('common.Approval')}}</th>
                                                                    <th scope="col">{{__('common.Paid Status')}}</th>
                                                                    <th scope="col">{{__('common.Total Amount')}}</th>
                                                                    <th scope="col">{{__('sale.Paid')}}</th>
                                                                    <th scope="col">{{__('common.Due')}}</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total = 0;
                                                                @endphp
                                                                @foreach ($supplier->purchases->where('status',1) as $key => $purchase)
                                                                @php
                                                                    $total += $purchase->payable_amount;
                                                                @endphp
                                                                    <tr>
                                                                        <td>{{ $key+1 }}</td>
                                                                        <td>{{ date(app('general_setting')->dateFormat->format, strtotime($purchase->created_at)) }}</td>
                                                                        <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->invoice_no}}</a></td>
                                                                        <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->ref_no}}</a></td>
                                                                        {{-- <td>
                                                                            @if ($purchase->supplier_id)
                                                                                {{@$purchase->supplier->name}}
                                                                            @endif
                                                                        </td> --}}
                                                                         <td>{{@$purchase->user->name}}</td>
                                                                        <td>
                                                                            @if ($purchase->status == 0)
                                                                                <h6><span class="badge_4">{{__('purchase.No')}}</span></h6>
                                                                            @else
                                                                                <h6><span class="badge_1">{{__('purchase.Yes')}}</span></h6>
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if ($purchase->is_paid == 0)
                                                                                <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                                                            @elseif ($purchase->is_paid == 1)
                                                                                <h6><span class="badge_4">{{__('sale.Partial')}}</span></h6>
                                                                            @else
                                                                                <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ single_price($purchase->payable_amount)}}</td>
                                                                        <td>{{ single_price($purchase->payments->sum('amount')-$purchase->payments->sum('return_amount')) }}</td>
                                                                        <td>{{ single_price($purchase->payable_amount - $purchase->payments->sum('amount') - $purchase->payments->sum('return_amount')) }}</td>

                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="10">{{ __('common.Total Purchase') }}:  {{ single_price($total) }}</td>
                                                                </tr>
                                                            </tfoot>
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
                                                        <table class="table Crm_table_active4">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{__('Common.No')}}</th>
                                                                    <th scope="col">{{__('sale.Date')}}</th>
                                                                    <th scope="col">{{__('sale.Reference No')}}</th>
                                                                    <th scope="col">{{__('common.Customer')}}</th>
                                                                    <th scope="col">{{__('common.Paid Status')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($supplier->purchases->where('return_status', 1) as $key => $sale)
                                                                    <tr>
                                                                        <td>{{ $key+1 }}</td>
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
    </section>
    <div id="Voucher_info">

    </div>
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
