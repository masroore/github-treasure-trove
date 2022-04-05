@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('sale.Sales List')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active4">
                            <thead>
                            <tr>
                                <th scope="col">{{__('sale.Sl')}}</th>
                                <th scope="col">{{__('sale.Date')}}</th>
                                <th scope="col">{{__('sale.Invoice')}}</th>
                                <th scope="col">{{__('sale.User')}}</th>
                                <th scope="col">{{__('common.Customer')}}</th>
                                <th scope="col">{{__('common.Amount')}}</th>
                                <th scope="col">{{__('purchase.Paid Amount')}}</th>
                                <th scope="col">{{__('purchase.Due Amount')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $key=> $sale)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                    <td><a href="javascript:void(0)" onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                    <td>{{@$sale->user->name}}</td>
                                    <td>
                                        @if ($sale->customer_id)
                                            {{@$sale->customer->name}}
                                        @else
                                            {{@$sale->agentuser->name}}
                                        @endif
                                    </td>
                                    <td>{{single_price($sale->payable_amount)}}</td>
                                    @php
                                        $paid = $sale->payments->sum('amount') - $sale->payments->sum('return_amount');
                                    @endphp
                                    <td>{{single_price($paid)}}</td>
                                    <td>{{single_price($sale->payable_amount - $paid)}}</td>
                                    <td>
                                        @if ($sale->is_approved == 0)
                                            <h6><span class="badge_4">{{__('sale.Unapproved')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('sale.Approved')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"> {{__('common.select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenu2">
                                                 @if(permissionCheck('return.sale.approve') && $sale->return_status == 0 && $sale->items->sum('return_quantity') > 0)
                                                     <a onclick="approve_modal('{{route('return.sale.approve', $sale->id)}}')"
                                                        class="dropdown-item edit_brand">{{__('sale.Return Approve')}}</a>
                                                 @endif
                                                 @if ((permissionCheck('sale.return') or permissionCheck('sale.return.index')) && $sale->return_status != 1)
                                                     <a href="{{route('sale.return',$sale->id)}}" class="dropdown-item"
                                                        type="button">{{__('sale.Sale Return')}}</a>
                                                 @endif

                                                @if (!permissionCheck('sale.return') or !permissionCheck('sale.return.index') or !permissionCheck('return.sale.approve'))
                                                 <a href="#" class="dropdown-item" type="button">{{__('common.No Action')}}</a>
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
    <div class="modal fade admin-query" id="shipping_details">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('sale.Shipping Info')}}</h4>
                    <button type="button" class="close " data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="">
                        <div class="row shipping_info">
                            <div class="col-12">
                                <h6>{{__('sale.Shipping Name')}} : <span class="view_shipping_name"></span></h6>
                                <h6>{{__('sale.Shipping Reference No')}} : <span class="view_shipping_ref"></span></h6>
                                <h6>{{__('sale.Date')}} : <span class="view_date"></span></h6>
                                <h6>{{__('sale.Received By')}} : <span class="view_received_by"></span></h6>
                                <h6>{{__('sale.Received Date')}} : <span class="view_received_date"></span></h6>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div id="getDetails">
    </div>
    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')
@endsection
@push('scripts')
    <script>
        function saleInfo(id) {
            let input = '<input type="hidden" name="id" value="' + id + '" "> ';
            $('#delivery_info').append(input);
        }

        function shippingInfo(id) {
            $.ajax({
                method: 'POST',
                url: '{{route('sale.shipping_info')}}',
                data: {
                    id: id,
                    _token: "{{csrf_token()}}",
                },
                success: function (result) {
                    $('.view_shipping_name').text(result.shipping_name);
                    $('.view_shipping_ref').text(result.shipping_ref);
                    $('.view_date').text(result.date);
                    $('.view_received_by').text(result.received_by);
                    $('.view_received_date').text(result.received_date);
                }
            })
        }

        function getDetails(el){
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
