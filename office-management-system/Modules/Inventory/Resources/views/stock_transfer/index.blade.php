@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.Transferred Products')}} </h3>
                    @if(permissionCheck('stock-transfer.store'))
                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                   href="{{route("stock-transfer.create")}}"><i
                                        class="ti-plus"></i>{{__('product.Transfer Product')}}</a>
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
                                <th scope="col">{{ __('common.Sl') }}</th>
                                <th scope="col">{{__('quotation.Date')}}</th>
                                <th scope="col">{{__('product.From')}}</th>
                                <th scope="col">{{__('product.To')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transfers as $key=> $transfer)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{\Carbon\Carbon::parse($transfer->date)->isoformat('Do MMMM Y H:ss a')}}</td>
                                    <td>{{@$transfer->sendable->name}}</td>
                                    <td>{{@$transfer->receivable->name}}</td>
                                    <td>
                                        @if ($transfer->status == 1)
                                            <h6><span class="badge_1">{{__('product.Approved')}}</span></h6>
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
                                                @if (permissionCheck('stock-transfer.status') && $transfer->status == 0)
                                                    <a onclick="approve_modal('{{route('stock-transfer.status', $transfer->id)}}')"
                                                       class="dropdown-item" type="button">{{__('sale.Approve')}}</a>
                                                @endif
                                                @if (permissionCheck('stock-transfer.receive') && $transfer->status == 1 && !$transfer->received_at)
                                                    <a onclick="approve_modal('{{route('stock-transfer.receive', $transfer->id)}}')"
                                                       class="dropdown-item" type="button">{{__('product.Receive')}}</a>
                                                @endif
                                                @if(permissionCheck('stock-transfer.edit') && $transfer->status == 0)
                                                    <a href="{{route('stock-transfer.edit',$transfer->id)}}"
                                                       class="dropdown-item" type="button">{{__('common.Edit')}}</a>
                                                @endif
                                                @if(permissionCheck('stock-transfer.delete'))
                                                    <a onclick="confirm_modal('{{route('stock-transfer.delete', $transfer->id)}}')"
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
    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')

@endsection
