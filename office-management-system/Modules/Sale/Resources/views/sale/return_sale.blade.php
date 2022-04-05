@extends('backEnd.master')

@section('mainContent')
    <style>
        .QA_section .QA_table tbody th, .QA_section .QA_table tbody td {
            padding: 3px;
        }
    </style>
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('sale.Sale Return')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <form action="{{route("sale.return.update",$sale->id)}}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('sale.Select Customer')}}</label>
                                            <select class="primary_select mb-15 contact_type" name="customer_id">
                                                @foreach($customers as $customer)
                                                    @if ($sale->customer_id == $customer->id)
                                                        <option value="{{$customer->id}}"
                                                                selected>{{$customer->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('sale.Select Warehouse or Showroom')}}</label>
                                            <select class="primary_select mb-15 contact_type" name="warehouse_id">
                                                @foreach($warehouses as $warehouse)
                                                    @if ($sale->ware_house_id == $warehouse->id)
                                                        <option value="{{$warehouse->id}}-warehouse"
                                                                selected>{{$warehouse->name}}</option>
                                                    @endif
                                                @endforeach
                                                @foreach($showrooms as $showroom)
                                                    @if ($showroom->name == $sale->saleable->name)
                                                        <option value="{{$showroom->id}}-showroom"
                                                                selected>{{$showroom->name}} ({{__('sale.Showroom')}})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('sale.Reference No')}}</label>
                                            <input type="text" name="ref_no" class="primary_input_field"
                                                   value="{{$sale->ref_no}}" placeholder="Reference No" readonly>
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Date')}}</label>
                                            <input type="text" name="date" class="primary_input_field"
                                                   value="{{date('m/d/Y', strtotime($sale->date))}}" placeholder="Date"
                                                   readonly>
                                            <span class="text-danger">{{$errors->first('date')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6 col-md- col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Attach Document')}}
                                                <span
                                                    class="text-muted">(pdf,csv,jpg,png,doc,docx,xlxs,zip)</span></label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="Browse file" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" name="documents[]"
                                                           id="document_file_1" multiple="multiple">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.User')}}</label>
                                            <input type="text" name="ref_no" class="primary_input_field"
                                                   value="{{$sale->user->name}}" readonly>
                                            <span class="text-danger">{{$errors->first('user_id')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                </div>

                                <div class="row mt-50">
                                    <div class="col-12">
                                        <div class="QA_section QA_section_heading_custom check_box_table">
                                            <div class="QA_table ">
                                                <table class="table Crm_table_active3">
                                                    <tr>
                                                        <th width="15%">{{__('sale.Product')}}</th>
                                                        @if (app('general_setting')->origin == 1)
                                                            <th scope="col">{{__('product.Part No.')}}</th>
                                                        @endif
                                                        <th scope="col">{{__('product.Model')}}</th>
                                                        <th scope="col">{{__('product.Brand')}}</th>
                                                        <th>{{__('sale.Unit Price')}} ($)</th>
                                                        <th>{{__('sale.Quantity')}}</th>
                                                        <th>{{__('sale.Tax')}} (%)</th>
                                                        <th>{{__('sale.Discount')}} ($)</th>
                                                        <th>{{__('sale.SubTotal')}} ($)</th>
                                                        <th>{{__('sale.Return Quantity')}}</th>
                                                        <th width="10%" class="d-none">{{__('common.Serial No')}}</th>
                                                        <th>{{__('sale.Return Value')}} ($)</th>
                                                    </tr>

                                                    @foreach($sale->items as $item)
                                                        @php
                                                            $v_name = [];
                                                            $v_value = [];
                                                            $variantName = null;
                                                            $subtotal = 0;
                                                            if ($item->productSku->product_variation) {
                                                                foreach (json_decode($item->productSku->product_variation->variant_id) as $key => $value) {
                                                                    array_push($v_name , Modules\Product\Entities\Variant::find($value)->name);
                                                                }
                                                                foreach (json_decode($item->productSku->product_variation->variant_value_id) as $key => $value) {
                                                                    array_push($v_value , Modules\Product\Entities\VariantValues::find($value)->value);
                                                                }

                                                                for ($i=0; $i < count($v_name); $i++) {
                                                                    $variantName .= $v_name[$i] . ' : ' . $v_value[$i] . ' ; ';
                                                                }
                                                            }
                                                            $price_after_discount = $item->price - ($item->price/100 * $item->discount);
                                                            $subtotal = $price_after_discount + ($price_after_discount/100 * $item->tax)
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                @if ($item->productable_type == "Modules\Product\Entities\ComboProduct")
                                                                    {{ $item->productable->name }}
                                                                @else
                                                                    {{@$item->productSku->product->product_name}}
                                                                    <br>
                                                                    {{ $variantName }}
                                                                @endif
                                                            </td>
                                                            @if (app('general_setting')->origin == 1)
                                                                <td>
                                                                    {{@$item->productSku->product->origin}}
                                                                </td>
                                                            @endif
                                                            <td>{{@$item->productSku->product->model->name}}</td>
                                                            <td>{{@$item->productSku->product->brand->name}}</td>
                                                            <td>{{single_price($item->price)}} </td>
                                                            <td class="text-center">{{@$item->quantity}}</td>
                                                            <td>{{@$item->tax}}</td>
                                                            <td>{{@$item->discount}}</td>
                                                            <td><span
                                                                    class="product_price{{$item->id}}">{{$subtotal}}</span>
                                                            </td>
                                                            <td><input type="hidden" name="items[]"
                                                                       value="{{$item->id}}">
                                                                <input type="number"
                                                                       onkeyup="addQuantity({{$item->id}})"
                                                                       name="quantity[]" max="{{$item->quantity}}"
                                                                       value="{{$item->return_quantity}}"
                                                                       class="primary_input_field quantity quantity{{$item->id}}">
                                                                <span
                                                                    class="text-danger quantity_validate{{$item->id}}"></span>
                                                            </td>
                                                            <td class="d-none">
                                                                <select class="primary_select" id="item_serial_no"
                                                                        name="item_serial_no[]" multiple>
                                                                    @foreach ($item->part_number_details as $part_number)
                                                                        <option
                                                                            value="{{ $part_number->part_number->id }}-{{ $item->id }}"
                                                                            @if ($item->part_number_details->where('part_number_id', $part_number->part_number_id)->where('is_returned', 1)->first()) selected @endif>{{ $part_number->part_number->seiral_no }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="product_subtotal[]"
                                                                       value="{{$item->return_amount}}"
                                                                       class="primary_input_field product_subtotal text-center product_subtotal{{$item->id}}"
                                                                       step="0.01">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row pb-30">
                                            <div class="col-xl-6">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                           for="">{{__("sale.Return Note")}} </label>

                                                    <textarea class="summernote3"
                                                              name="return_notes">{{$sale->return_note}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                           for="">{{__("sale.Staff Note")}} </label>

                                                    <textarea class="summernote3"
                                                              name="notes">{{$sale->notes}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <div class="submit_btn text-center">
                                                <button class="primary-btn semi_large2 fix-gr-bg"><i
                                                        class="ti-check"></i>Save
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @push("scripts")
            <script type="text/javascript">
                function addQuantity(id) {
                    let price = $(".product_price" + id).text();
                    let item_quantity = $('.quantity' + id).val();
                    let sub_total = (price * item_quantity).toFixed(2);
                    $('.product_subtotal' + id).val(sub_total);
                }

                $(document).ready(function () {
                    $(".table").dataTable();
                });
            </script>
    @endpush

@endsection
