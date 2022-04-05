@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-12">
                                <div class="box_header">
                                    <div class="main-title">
                                        <h3 class="mb-0" >{{__('contact.Customer Return')}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                </div>
            </div>
        </div>
    </section>


@endsection
@push('scripts')
    <script>
       

    </script>
@endpush
