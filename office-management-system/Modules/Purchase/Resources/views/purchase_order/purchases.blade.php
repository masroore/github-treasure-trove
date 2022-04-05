@extends('backEnd.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('backEnd/css/custom.css')}}"/>
@endpush
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('purchase.Purchase Orders')}} </h3>
                     @if(permissionCheck('purchase_order.store'))
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                               href="{{route("purchase_order.create")}}"><i
                                    class="ti-plus"></i>{{__('purchase.New Order')}}</a>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('common.No')}}</th>
                                <th scope="col">{{__('quotation.Date')}}</th>
                                <th scope="col">{{__('quotation.Supplier')}} {{__('common.Name')}}</th>
                                <th scope="col">{{__('sale.Invoice No')}}</th>
                                <th scope="col">{{__('purchase.Total Amount')}}</th>
                                <th scope="col">{{__('purchase.Paid Amount')}}</th>
                                <th scope="col">{{__('purchase.Due Amount')}}</th>
                                <th scope="col">{{__('purchase.Is Approved')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key=> $order)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($order->created_at)) }}</td>
                                    <td>{{@$order->supplier->name}}</td>
                                    <td><a href="javascript:void(0)" onclick="getDetails({{ $order->id }})">{{$order->invoice_no}}</a></td>
                                    <td>{{single_price($order->payable_amount)}}</td>
                                    @php
                                    $paid = $order->payments->sum('amount') - $order->payments->sum('return_amount');
                                    @endphp
                                    <td>{{single_price($paid)}}</td>
                                    <td>{{single_price($order->payable_amount - $paid)}}</td>
                                    <td>
                                        @if ($order->status == 0)
                                            <h6><span class="badge_4">{{__('purchase.No')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('purchase.Yes')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                {{__('common.Select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenu2">
                                                @if ($order->is_paid != 2 && $order->status == 1)
                                                    <a href="{{route('purchase.payment',$order->id)}}"
                                                       class="dropdown-item"
                                                       type="button">{{__('pos.Payment')}}</a>
                                                @endif
                                                @if($order->status == 0)
                                                    <a onclick="approve_modal('{{route('purchase.approve', $order->id)}}')"
                                                       class="dropdown-item edit_brand">{{__('sale.Approve')}}</a>
                                                    @if(permissionCheck('purchase_order.edit'))
                                                    <a href="{{route('purchase_order.edit',$order->id)}}"
                                                       class="dropdown-item" type="button">{{__('common.Edit')}}</a>
                                                    @endif
                                                @endif
                                                @if ($order->return_status == 2 && $order->added_to_stock == 1)
                                                    <a href="{{route('purchase.order.return',$order->id)}}" class="dropdown-item"
                                                       type="button">{{__('purchase.Purchase Return')}}</a>
                                                @endif
                                                @if(permissionCheck('purchase_order.show'))
                                                <a href="{{route('purchase_order.show',$order->id)}}"
                                                   class="dropdown-item"
                                                   type="button">{{__('purchase.Purchase Details')}}</a>
                                                @endif

                                                @if(permissionCheck('purchase.order.destroy') && $order->status == 0)
                                                <a onclick="confirm_modal('{{route('purchase.order.destroy', $order->id)}}')"
                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                @endif

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
    <div id="getDetails">

    </div>
    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')
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
    </script>
@endpush
