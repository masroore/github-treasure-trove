@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('common.Customer') }} {{__('common.Profile')}}</h3>
                        </div>

                        <ul class="d-flex">

                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-12">
                            <img class="student-meta-img img-100 mb-3" src="{{ file_exists(@$customer->avatar) ? asset(@$customer->avatar) : asset('public/img/profile.jpg') }}"  alt="">
                            <h3>{{$customer->name}}</h3>
                            <table class="table table-borderless supplier_view">
                                <tr><td>{{ __('common.Name') }}:</td><td>{{ $customer->name }}</td></tr>
                                <tr><td>{{ __('common.Email') }}:</td><td>{{ $customer->email }}</td></tr>
                                <tr><td>{{ __('common.Phone') }}:</td><td>{{ $customer->mobile }}</td></tr>
                                <tr><td>{{ __('common.Address') }}:</td><td>{{ $customer->address }}</td></tr>
                                <tr><td>{{ __('contact.Country') }}:</td><td>{{ @$customer->country->name }}</td></tr>
                                <tr><td>{{ __('contact.State') }}:</td><td>{{ $customer->state }}</td></tr>
                                <tr><td>{{ __('contact.City') }}:</td><td>{{ @$customer->city }}</td></tr>
                                <tr><td>{{ __('common.Tax Number') }}:</td><td>{{ $customer->tax_number }}</td></tr>
                                <tr><td>{{ __('common.Opening Balance') }}:</td><td>{{ single_price($customer->opening_balance) }}</td></tr>
                                <tr><td>{{ __('common.Registered Date') }}:</td><td>{{ date(app('general_setting')->dateFormat->format, strtotime($customer->created_at)) }}</td></tr>
                                <tr>
                                    <td>{{ __('common.Active Status') }}:</td>
                                    <td>
                                        @if ($customer->is_active == 1)
                                        <span class="badge_1">{{__('common.Active')}}</span>
                                        @else
                                        <span class="badge_4">{{__('common.De-Active')}}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 supplier_profile_purchase">
                            <h3>{{__('sale.Sale Information')}}</h3>
                            <table class="table table-borderless supplier_view">
                                <tr><td>{{__('purchase.Total Invoice')}} : {{$customer->accounts['total_invoice']}}</td></tr>
                                <tr><td>{{__('purchase.Due Invoice')}} : {{$customer->accounts['due_invoice']}}</td></tr>
                            </table>
                            <a href="{{ route('contact.my_products')  }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-bars"></i> {{__('product.Products')}}</a>
                        </div>
                        <div class="col-md-1 col-lg-1 col-sm-12"></div>
                        <div class="col-md-5 col-lg-5 col-sm-12 supplier_profile_purchase">
                            <table class="table table-borderless supplier_view">
                                @if ($customer->accounts)
                                <tr><td>{{__('retailer.Total Sales (Opening Balance + Sales)')}} : {{single_price($customer->accounts['total'])}}</td></tr>
                                <tr><td>{{__('purchase.Due Balance')}} : {{single_price($customer->accounts['due'])}}</td></tr>
                                @endif
                            </table>

                        </div>
                    </div>
                    @if ($customer->note)
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label class="primary_input_label" for="">
                                @php
                                echo $customer->note;
                                @endphp
                            </label>
                        </div>
                    </div>
                    <hr>
                    @endif

                    <div class="row">
                        <!-- Start Sms Details -->
                        <div class="col-lg-12 student-details">
                            <ul class="nav nav-tabs tab_column" role="tablist">
                                @if ($customer->id != 1)
                                <li class="nav-item">
                                    <a class="nav-link active" href="#Invoice" role="tab" data-toggle="tab">{{ __('common.Invoice') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Return" role="tab" data-toggle="tab">{{ __('common.Return') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Transactions" role="tab" data-toggle="tab">{{__('common.Transactions')}}</a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                @if ($customer->id != 1)
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
                                                                    <th scope="col">{{__('common.Sold By')}}</th>
                                                                    <th scope="col">{{__('common.Customer')}}</th>
                                                                    <th scope="col">{{__('common.Paid Status')}}</th>
                                                                    <th scope="col">{{__('common.Amount')}}</th>
                                                                    <th scope="col">{{ __('common.Action') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $total = 0;
                                                                @endphp
                                                                @foreach ($customer->sales as $key => $sale)
                                                                @php
                                                                $total += $sale->amount;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                                    <td><a onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                                    <td>{{$sale->ref_no}}</td>
                                                                    <td>{{@$sale->user->name}}</td>
                                                                    <td>
                                                                        @if ($sale->customer_id)
                                                                        {{@$sale->customer->name}}
                                                                        @else
                                                                        {{@$sale->agentuser->name}}
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if ($sale->status == 0)
                                                                        <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                                                        @elseif ($sale->status == 2)
                                                                        <h6><span class="badge_4">{{__('sale.Partial')}}</span></h6>
                                                                        @else
                                                                        <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$sale->amount}}</td>
                                                                    <td>
                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false"> {{__('common.select')}}
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                        aria-labelledby="dropdownMenu2">

                                                                        @if ($sale->status != 1)
                                                                        <a href="{{route('contact.my_payment',$sale->id)}}" class="dropdown-item"
                                                                         type="button">{{__('pos.Payment')}}</a>
                                                                         @endif

                                                                         <a href="{{route('sale.pdf',$sale->id)}}" class="dropdown-item" type="button">{{__('quotation.Download')}}</a>

                                                                     </div>
                                                                 </div>
                                                             </td>
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
                                                            <th scope="col">{{__('sale.Invoice')}}</th>
                                                            <th scope="col">{{__('sale.Reference No')}}</th>
                                                            <th scope="col">{{__('common.Sold By')}}</th>
                                                            <th scope="col">{{__('common.Customer')}}</th>
                                                            <th scope="col">{{__('common.Status')}}</th>
                                                            <th scope="col">{{__('common.Amount')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @php
                                                       $returnTotal = 0;
                                                       @endphp
                                                       @foreach ($customer->sales->where('return_status', 1) as $key => $sale)
                                                       @php

                                                       $returnTotal += $sale->amount;

                                                       @endphp
                                                       <tr>
                                                        <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                        <td>{{$sale->invoice_no}}</td>
                                                        <td><a onclick="getDetails({{ $sale->id }})">{{$sale->ref_no}}</a></td>
                                                        <td>{{@$sale->user->name}}</td>
                                                        <td>
                                                            @if ($sale->customer_id)
                                                            {{@$sale->customer->name}}
                                                            @else
                                                            {{@$sale->agentuser->name}}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($sale->status == 0)
                                                            <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                                            @elseif ($sale->status == 2)
                                                            <h6><span class="badge_4">{{__('sale.Partial')}}</span></h6>
                                                            @else
                                                            <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                                            @endif
                                                        </td>
                                                        <td>{{ $returnTotal }}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6">{{ __('common.Total') }}</td>
                                                        <td colspan="1">{{ $returnTotal }}</td>
                                                    </tr>

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
                                        @include('contact::contact.debit_transaction_list_table', ['chartAccount' => Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $customer->id)->first()])

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div role="tabpanel" class="tab-pane fade show active" id="Transactions">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            @include('contact::contact.debit_transaction_list_table', ['chartAccount' => Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $customer->id)->first()])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
@include('contact::contact.minus_balance_modal_customer')
@include('contact::contact.add_balance_modal_customer')

@endsection
@push('scripts')
<script>
    function getDetails(el){
        $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
            $('#getDetails').html(data);
            $('#sale_info_modal').modal('show');
            $('select').niceSelect();
        });
    }
    $(document).ready(function () {
        $(".bank_branch_div").hide();
        $(".bank_name_div").hide();
        $(".cheque_date_div").hide();
        $(".cheque_no_div").hide();
    });
    $( "#debit_account_id" ).change(function() {
        var debit_account_id = $('#debit_account_id').val();
        $.post('{{ route('get_accounts_configurable_type') }}', {_token:'{{ csrf_token() }}', id:debit_account_id}, function(data){
            $('#voucher_type').val(data.configuration_group_id);
            if (data.configuration_group_id == 1) {
                $("#bank_branch").attr('disabled', true);
                $("#bank_name").attr('disabled', true);
                $("#cheque_date").attr('disabled', true);
                $("#cheque_no").attr('disabled', true);
                $(".bank_branch_div").hide();
                $(".bank_name_div").hide();
                $(".cheque_date_div").hide();
                $(".cheque_no_div").hide();
            }
            else if (data.configuration_group_id == 2) {
                $("#bank_branch").removeAttr("disabled");
                $("#bank_name").removeAttr("disabled");
                $("#cheque_date").removeAttr("disabled");
                $("#cheque_no").removeAttr("disabled");
                $(".bank_branch_div").show();
                $(".bank_name_div").show();
                $(".cheque_date_div").show();
                $(".cheque_no_div").show();
            }
        });

    });

</script>
@endpush
