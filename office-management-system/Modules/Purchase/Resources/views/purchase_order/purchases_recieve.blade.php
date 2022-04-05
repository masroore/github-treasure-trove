@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('purchase.Recieve Purchase Orders')}} </h3>
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
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('common.No')}}</th>
                                <th scope="col">{{__('quotation.Date')}}</th>
                                <th scope="col">{{__('quotation.Supplier')}} {{__('common.Name')}}</th>
                                <th scope="col">{{__('quotation.Reference No')}}</th>
                                <th scope="col">{{__('purchase.Is Approved')}}</th>
                                <th scope="col">{{__('purchase.Is Added to Stock')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key=> $order)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($order->created_at)) }}</td>
                                    <td>{{@$order->supplier->name}}</td>
                                    <td><a href="javascript:void(0)"
                                           onclick="getDetails({{ $order->id }})">{{$order->ref_no}}</a></td>
                                    </td>
                                    <td>
                                        @if ($order->status == 0)
                                            <h6><span class="badge_4">{{__('purchase.No')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('purchase.Yes')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->added_to_stock == 1)
                                            <h6><span class="badge_1">{{__('purchase.Added to Stock')}}</span></h6>
                                        @else
                                            <h6><span class="badge_4">{{__('common.Pending')}}</span></h6>
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
                                                @if (permissionCheck('purchase.add.stock') && $order->status ==1 && $order->added_to_stock != 1)
                                                    <a href="{{route('purchase.add.stock', $order->id)}}"
                                                       class="dropdown-item"
                                                       type="button">{{__('purchase.Add to Stock')}}</a>
                                                @endif
                                                @if($order->added_to_stock == 1)
                                                    <span
                                                        class="success dropdown-item">{{__('purchase.Already Added')}}</span>
                                                @endif
                                                @if($order->added_to_stock != 0)
                                                    <a href="{{route('purchase.receive.products', $order->id)}}"
                                                       class="dropdown-item"
                                                       type="button">{{__('purchase.Receive History')}}</a>
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
@endsection
@push("scripts")
    <script type="text/javascript">
        function getDetails(el) {
            $.post('{{ route('get_purchase_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#purchase_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
