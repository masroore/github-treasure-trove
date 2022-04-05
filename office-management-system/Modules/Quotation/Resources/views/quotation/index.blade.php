@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title .' | Quotations List')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('quotation.Quotations')}}</h3>
                    @if(permissionCheck('quotation.store'))
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                               href="{{route("quotation.create")}}"><i
                                    class="ti-plus"></i>{{__('quotation.New Quotation')}}</a>
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
                                <th scope="col">{{__('quotation.Reference No')}}</th>
                                <th scope="col">{{__('quotation.Customer')}}</th>
                                <th scope="col">{{__('quotation.Branch')}}</th>
                                <th scope="col">{{__('quotation.User')}}</th>
                                <th scope="col">{{__('common.Convert Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotations as $key=> $quotation)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($quotation->created_at)) }}</td>
                                    <td>{{$quotation->invoice_no}}</td>
                                    <td>{{@$quotation->customer->name}}</td>
                                    <td>{{@$quotation->quotationable->name}}</td>
                                    <td>{{@$quotation->user->name}}</td>
                                    <td>
                                        @if ($quotation->convert_status == 0)
                                            <h6><span class="badge_4">{{__('common.Pending')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('quotation.Converted To Sale')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{__('common.Select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                            @if ($quotation->status != 1)
                                                @if(permissionCheck('quotation.edit'))
                                                    <a href="{{route('quotation.edit',$quotation->id)}}" class="dropdown-item" type="button">{{__('common.Edit')}}</a>
                                                @endif
                                            @else
                                                <a href="#" class="dropdown-item" type="button">{{__('quotation.Mail Sent')}}</a>
                                            @endif
                                            <a href="{{route('quotation.show',$quotation->id)}}" class="dropdown-item" type="button">{{__('quotation.Details View')}}</a>
                                            @if ($quotation->convert_status == 0)
                                                <a href="{{route('quotation.convert', $quotation->id)}}" class="dropdown-item" type="button">{{__('quotation.Convert To Sale')}}</a>
                                            @else
                                                <a class="dropdown-item" type="button">{{__('quotation.Converted To Sale')}}</a>
                                            @endif

                                            <a href="{{route('quotation.order.pdf',$quotation->id)}}" class="dropdown-item" type="button">{{__('quotation.Download')}}</a>
                                            <a href="{{route('quotation.clone',$quotation->id)}}" class="dropdown-item" type="button">{{__('quotation.Clone to Quotation')}}</a>
                                            @if(permissionCheck('quotation.delete'))
                                                <a onclick="confirm_modal('{{route('quotation.delete', $quotation->id)}}')" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
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
