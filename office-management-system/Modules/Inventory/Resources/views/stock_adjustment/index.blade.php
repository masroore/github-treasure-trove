@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.Stock Adjustments')}} </h3>
                    @if(permissionCheck('stock_adjustment.store'))
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("stock_adjustment.create")}}"><i class="ti-plus"></i>{{__('product.Add Stock Adjustments')}}</a>
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
                                <th scope="col">{{__('product.Branch/Warehouse')}}</th>
                                <th scope="col">{{__('product.Reference No')}}</th>
                                <th scope="col">{{__('product.Recovery Amount')}}</th>
                                <th scope="col">{{__('product.Created User')}}</th>
                                <th scope="col">{{__('product.Updated User')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{date(app('general_setting')->dateFormat->format, strtotime($item->date))}}</td>
                                    <td>{{@$item->adjustable->name}}</td>
                                    <td>{{$item->ref_no}}</td>
                                    <td>{{single_price($item->recovery_amount)}}</td>
                                    <td>{{ userName($item->created_by) }}</td>
                                    <td class="text-center">{{ ($item->updated_by) ? userName($item->updated_by) : "X" }}</td>
                                    <td>
                                        @if (@$item->status != 1)
                                            <h6><span class="badge_4">{{__('product.Pending')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('product.Approved')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{__('common.Select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                @if ($item->status != 1)
                                                     @if(permissionCheck('stock_adjustment.approve'))
                                                    <a onclick="approve_modal('{{route('stock_adjustment.approve', $item->id)}}')" class="dropdown-item edit_brand">{{__('sale.Approve')}}</a>
                                                    @endif
                                                     @if(permissionCheck('stock_adjustment.edit'))
                                                    <a href="{{route('stock_adjustment.edit',$item->id)}}" class="dropdown-item" type="button">{{__('common.Edit')}}</a>
                                                    @endif
                                                     @if(permissionCheck('stock_adjustment.destroy'))
                                                    <a onclick="confirm_modal('{{route('stock_adjustment.destroy', $item->id)}}')" class="dropdown-item">{{__('common.Delete')}}</a>
                                                    @endif
                                                @endif
                                                 @if(permissionCheck('stock_adjustment.show'))
                                                <a href="{{route('stock_adjustment.show',$item->id)}}" class="dropdown-item" type="button">{{__('common.View')}}</a>
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
