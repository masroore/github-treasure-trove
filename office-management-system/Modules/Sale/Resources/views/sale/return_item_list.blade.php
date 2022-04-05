@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('sale.Sale Return List')}} </h3>
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("sale.sale_return_list")}}"><i class="ti-plus"></i>{{__('sale.Create Sale Return')}}</a>
                        </li>
                    </ul>
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
                                <th scope="col">{{__('common.No')}}</th>
                                <th scope="col">{{__('sale.Invoice')}}</th>
                                <th scope="col">{{__('sale.Branch')}}</th>
                                <th scope="col">{{__('sale.Biller')}}</th>
                                <th scope="col">{{__('sale.Customer')}}</th>
                                <th scope="col">{{__('sale.Quantity')}}</th>
                                <th scope="col">{{__('common.Total Amount')}}</th>
                                <th scope="col">{{__('sale.Return Amount')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ @$item->invoice_no }}</td>
                                    <td>{{ @$item->saleable->name }}</td>
                                    <td>{{ @$item->user->name }}</td>
                                    <td>{{ @$item->customer->name }}</td>
                                    <td>{{ @$item->items->sum('return_quantity') }}</td>
                                    <td>{{ single_price($item->payable_amount) }}</td>
                                    <td>{{ single_price(@$item->items->sum('return_amount')) }}</td>
                                    <td>
                                        @if (@$item->return_status == 0)
                                            <h6><span class="badge_4">{{__('sale.Pending')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('sale.Approved')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ __('common.Select One') }} </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                @if (@$item->return_status == 2)
                                                    <a href="{{route('sale.return',$item->id)}}" class="dropdown-item" type="button">{{__('sale.Sale Return')}}</a>
                                                @endif
                                                @if(@$item->return_status == 0 && @$item->items->sum('return_quantity') > 0)
                                                    <a onclick="approve_modal('{{route('return.sale.approve', @$item->id)}}')" class="dropdown-item edit_brand">{{__('sale.Return Approve')}}</a>
                                                @endif
                                                <a href="{{route('sale.return_detail_show',@$item->id)}}" class="dropdown-item" type="button">{{__('sale.Details')}}</a>
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
    </div>
    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')
@endsection
