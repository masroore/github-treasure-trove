@extends('backEnd.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('backEnd/css/custom.css')}}"/>
@endpush
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('sale.Conditional Sales')}} </h3>
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("conditional-sale.create")}}"><i
                                    class="ti-plus"></i>{{__('sale.New Conditional Sale')}}</a>
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
                                <th scope="col">{{__('sale.Sl')}}</th>
                                <th scope="col">{{__('sale.Date')}}</th>
                                <th scope="col">{{__('sale.Invoice')}}</th>
                                <th scope="col">{{__('sale.Reference No')}}</th>
                                <th scope="col">{{__('sale.Branch')}}</th>
                                <th scope="col">{{__('sale.Biller')}}</th>
                                <th scope="col">{{__('sale.Customer')}}</th>
                                <th scope="col">{{__('common.Total Amount')}}</th>
                                <th scope="col">{{__('sale.Paid')}}</th>
                                <th scope="col">{{__('sale.Due')}}</th>
                                <th scope="col">{{__('common.Status')}}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $key=> $sale)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                    <td><a href="javascript:void(0)"
                                           onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                    <td><a href="javascript:void(0)"
                                           onclick="getDetails({{ $sale->id }})">{{$sale->ref_no}}</a></td>
                                    <td>{{@$sale->saleable->name}}</td>
                                    <td>{{@$sale->user->name}}</td>
                                    <td>{{@$sale->customer->name}}</td>
                                    <td class="nowrap">{{single_price($sale->payable_amount)}}</td>
                                    @php
                                        $paid = $sale->payments->sum('amount') - $sale->payments->sum('return_amount');
                                    @endphp
                                    <td class="nowrap">{{single_price($paid)}}</td>
                                    <td class="nowrap">{{ (($sale->payable_amount - $paid) > 0) ? single_price($sale->payable_amount - $paid) : single_price(0)}}</td>
                                    <td>
                                        @if ($sale->is_approved == 1)
                                            <h6><span class="badge_1">{{__('sale.Approved')}}</span></h6>
                                        @else
                                            <h6><span class="badge_4">{{__('sale.Unapproved')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"> {{__('sale.Select')}} </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenu2">
                                                @if ($sale->is_delivered == 0)
                                                    <a href="{{route('sale.return',$sale->id)}}" class="dropdown-item"
                                                       type="button">{{__('sale.Sale Return')}}</a>
                                                @endif
                                                @if ($sale->is_approved == 0)
                                                    <a href="{{route('conditional-sale.edit',$sale->id)}}" class="dropdown-item"
                                                       type="button">{{__('common.Edit')}}</a>
                                                @endif
                                                @if ($sale->is_approved == 1)
                                                    <a href="{{route('sale.payment',$sale->id)}}" class="dropdown-item"
                                                       type="button">{{__('pos.Payment')}}</a>
                                                @endif
                                                @if($sale->return_status == 0 && $sale->items->sum('return_quantity') > 0)
                                                    <a onclick="approve_modal('{{route('return.sale.approve', $sale->id)}}')"
                                                       class="dropdown-item edit_brand">{{__('sale.Return Approve')}}</a>
                                                @endif
                                                <a href="{{route('conditional-sale.show',$sale->id)}}" class="dropdown-item"
                                                   type="button">{{__('sale.Order Details')}}</a>
                                                @if ($sale->is_approved != 1)
                                                    <a onclick="approve_modal('{{route('conditional.sale.approve', $sale->id)}}')"
                                                       class="dropdown-item edit_brand">{{__('sale.Approve')}}</a>
                                                @endif
                                                @if (permissionCheck('sale.delete') && $sale->is_approved != 1)
                                                    <a onclick="confirm_modal('{{route('sale.delete', $sale->id)}}')"
                                                       class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                @endif
                                                @php
                                                    $sale_id = $sale->id;
                                                    if($sale->shipping){
                                                        $shpping_details = $sale->shipping;
                                                        $shpping_details['date'] = $shpping_details['date'] ? Carbon\Carbon::parse($sale->shipping['date'])->format('m/d/Y') :  Carbon\Carbon::now()->format('m/d/Y') ;
                                                        $shpping_details['received_date'] = $shpping_details['received_date'] ? Carbon\Carbon::parse($sale->shipping['received_date'])->format('m/d/Y') : '';
                                                    }else{
                                                        $shpping_details = 1 ;
                                                    }
                                                @endphp
                                                <a href="javascript:void(0)"
                                                   onclick="saleId({{ $sale_id }},{{ $shpping_details }})"
                                                   data-toggle="modal" data-target="#add_shipping" class="dropdown-item"
                                                   type="button">{{__('sale.Update Shipping')}} </a>
                                                @if ($sale->shipping)
                                                    <a href="javascript:void(0)" onclick="shippingInfo({{$sale->id}})"
                                                       data-toggle="modal" data-target="#shipping_details"
                                                       class="dropdown-item"
                                                       type="button">{{__('sale.Shipping Details')}}</a>
                                                    @if (empty($sale->shipping->received_by))
                                                        <a href="javascript:void(0)" onclick="saleInfo({{$sale->id}})"
                                                           data-toggle="modal" data-target="#order_recieve"
                                                           class="dropdown-item">{{__('sale.Mark as Delivered')}}</a>
                                                    @endif
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

    {{--    Order Receive--}}
    <div class="modal fade admin-query" id="order_recieve">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sale.Mark as Received') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sale.order.receive') }}" method="POST" id="delivery_info">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('sale.Received By') }}</label>
                                    <input name="name" class="primary_input_field name"
                                           placeholder="{{ __('sale.Received By') }}" type="text">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('sale.Received Date') }}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Delivery Date"
                                                           class="primary_input_field primary-input date form-control"
                                                           id="startDate" type="text" name="delivery_date"
                                                           value="{{date('m/d/Y')}}"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                            id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Modal Item_Details -->
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
                        <div class="row">
                            <div class="col-12">
                                <table class="table-modal table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="30%">{{__('sale.Shipping Name')}}: </td>
                                            <td> <span class="view_shipping_name"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">{{__('sale.Shipping Reference No')}}  : </td>
                                            <td><span class="view_shipping_ref"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">{{__('sale.Date')}}  : </td>
                                            <td><span class="view_date"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">{{__('sale.Received By')}} : </td>
                                            <td><span class="view_received_by"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">{{__('sale.Received Date')}} :</td>
                                            <td><span class="view_received_date"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="add_shipping">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sale.Shipping Info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST" id="shipping_addForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" class="id">
                            <input type="hidden" name="sale_id" class="sale_id">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('sale.Shipping Name') }}</label>
                                    <input name="shipping_name" class="primary_input_field shipping_name"
                                           placeholder="{{ __('sale.Shipping Name') }}" type="text" required>
                                    <span class="text-danger" id="shipping_name_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{ __('sale.Shipping Reference No') }}</label>
                                    <input name="shipping_ref" class="primary_input_field shipping_ref"
                                           placeholder="{{ __('sale.Shipping Reference No') }}" type="text" required>
                                    <span class="text-danger" id="shipping_ref_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                           class="primary_input_field primary-input date form-control shipping_date"
                                                           id="startDate" type="text" name="shipping_date"
                                                           value="{{date('d/m/Y')}}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('sale.Booking Slip')}} <span class="text-danger">*</span> </label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="placeholderFileOneName"
                                               placeholder="Browse file">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg"
                                                   for="booking_slip">Browse </label>
                                            <input type="file" class="d-none" name="booking_slip" id="booking_slip">
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <h6 class="receive_info">{{__('sale.Received Information')}}</h6>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('sale.Received By') }}</label>
                                    <input name="received_by" class="primary_input_field received_by"
                                           placeholder="{{ __('sale.Received By') }}" type="text">
                                    <span class="text-danger" id="received_by_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('sale.Received Date') }} </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                           class="primary_input_field primary-input date form-control received_date"
                                                           id="startDate" type="text" name="received_date"
                                                           value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('sale.Prove Of Delivery')}} </label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="placeholderFileOneName"
                                               placeholder="Browse file">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg"
                                                   for="prove_of_delivery">Browse </label>
                                            <input type="file" class="d-none" name="prove_of_delivery"
                                                   id="prove_of_delivery">
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                            id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}
                                    </button>
                                </div>
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

            function getDetails(el) {
                $.post('{{ route('get_sale_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                    $('#getDetails').html(data);
                    $('#sale_info_modal').modal('show');
                    $('select').niceSelect();
                });
            }

            function saleId(id,shipping) {
                console.log(shipping)
                if( shipping != '1' || shipping != 1 ){
                    $('.id').val(shipping.id);
                    $('.sale_id').val(id);
                    $('.shipping_name').val(shipping.shipping_name);
                    $('.shipping_ref').val(shipping.shipping_ref);
                    $('.shipping_date').val(shipping.date);
                    $('.received_by').val(shipping.received_by);
                    $('.received_date').val(shipping.received_date);
                }else{
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();

                    today = mm + '/' + dd + '/' + yyyy;
                    $('.id').val('');
                    $('.sale_id').val(id);
                    $('.shipping_name').val('');
                    $('.shipping_ref').val('');
                    $('.shipping_date').val(today);
                    $('.received_by').val('');
                    $('.received_date').val('');
                }
            }

            $("#shipping_addForm").on("submit", function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                console.log(formData)
                $.ajax({
                    url: "{{route("store.shipping")}}",
                    data: formData,
                    type: "POST",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#add_shipping").modal("hide");
                        $("#shipping_addForm").trigger("reset");
                        toastr.success("Shipping Info has Been Changed");
                        location.reload();
                    },
                    error: function (error) {
                        if (error) {
                            $.each(error.responseJSON.errors, function (key, message) {
                                $("#" + key + "_error").html(message[0]);
                            });
                        }
                    }

                });
            });
        </script>
    @endpush
@endsection
