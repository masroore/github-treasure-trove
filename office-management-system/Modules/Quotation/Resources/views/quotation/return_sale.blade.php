@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">Sale Return</h3>
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
                                            <label class="primary_input_label" for="">Select Customer</label>
                                            <select class="primary_select mb-15 contact_type" name="customer_id">
                                                <option selected disabled>Select</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}} {{$sale->customer_id == $customer->id ? 'selected' : ''}}" disabled>{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Select Warehouse</label>
                                            <select class="primary_select mb-15 contact_type" name="warehouse_id">
                                                <option selected disabled>Select</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{$warehouse->id}}" {{$sale->ware_house_id == $warehouse->id ? 'selected' : ''}} disabled>{{$warehouse->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Reference No</label>
                                            <input type="text" name="ref_no" class="primary_input_field"
                                                   value="{{$sale->ref_no}}" placeholder="Reference No" readonly>
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Date</label>
                                            <input type="datetime-local" name="date" class="primary_input_field"
                                                   value="{{date('Y-m-d\TH:i', strtotime($sale->date))}}" placeholder="Date">
                                            <span class="text-danger">{{$errors->first('date')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  
                                    <div class="col-lg-6 col-md- col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">Attach Document <span class="text-muted">(pdf,csv,jpg,png,doc,docx,xlxs,zip)</span></label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="Browse file" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" name="documents[]" id="document_file_1" multiple="multiple">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">User</label>
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
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="p-2">Product</th>
                                                <th class="p-2">Category</th>
                                                <th class="p-2">Color</th>
                                                <th class="p-2">Size</th>
                                                <th class="p-2">Unit Price ($)</th>
                                                <th class="p-2">Quantity</th>
                                                <th class="p-2">Tax (%)</th>
                                                <th class="p-2">Discount ($)</th>
                                                <th class="p-2">Subtotal ($)</th>
                                                <th class="p-2">Return Quantity</th>
                                                <th class="p-2">Return Value ($)</th>
                                            </tr>

                                            @foreach($sale->items as $item)
                                                <tr>
                                                    <td class="p-2">{{@$item->product->product_name}}</td>
                                                    <td class="p-2">{{@$item->product->category->name}}</td>
                                                    <td class="p-2">{{@$item->color}}</td>
                                                    <td class="p-2">{{@$item->size}}</td>
                                                    <td class="p-2 product_price{{$item->id}}">{{@$item->price}}</td>
                                                    <td class="p-2">{{@$item->quantity}}</td>
                                                    <td class="p-2">{{@$item->tax}}</td>
                                                    <td class="p-2">{{@$item->discount}}</td>
                                                    <td class="p-2">{{@$item->sub_total}}</td>
                                                    <td class="p-2"><input type="hidden" name="items[]"
                                                                           value="{{$item->id}}">
                                                        <input type="number" onkeyup="addQuantity({{$item->id}})"
                                                               name="quantity[]" max="{{$item->quantity}}"
                                                               value="{{$item->return_quantity}}"
                                                               class="primary_input_field quantity quantity{{$item->id}}">
                                                        <span class="text-danger quantity_validate{{$item->id}}"></span>
                                                    </td>

                                                    <td class="p-2 product_subtotal product_subtotal{{$item->id}}">{{$item->return_amount}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>

                                    <div class="row pb-30">
                                        <div class="col-xl-6">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{__("common.Return Note")}} </label>

                                                <textarea class="summernote3" name="return_notes">{{$sale->return_note}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{__("common.Staff Note")}} </label>

                                                <textarea class="summernote3" name="notes">{{$sale->notes}}</textarea>
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
                                    </form>
                                </div>
                            </div>

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
                    let sub_total = (price * item_quantity);
                    $('.product_subtotal' + id).text(sub_total);
                }

                $(document).ready(function () {
                    $(".table").dataTable();
                });
            </script>
    @endpush

@endsection
