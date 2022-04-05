@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('sale.Add New Conditional Sale') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("sale.store")}}" id="sale_form" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Select Customer *</label>
                                            <select class="primary_select mb-15 contact_type" name="customer_id">
                                                <option selected disabled>Select</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Select Warehouse *</label>
                                            <select class="primary_select mb-15 contact_type" name="warehouse_id" required="1">
                                                <option selected disabled>Select</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Reference No *</label>
                                            <input type="text" name="ref_no" class="primary_input_field"
                                                   value="{{old('ref_no')}}" placeholder="Reference No" required="1">
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('sale.Date') }}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text"
                                                                   name="date" value="" autocomplete="off" required="1">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Status *</label>
                                            <select id="" name="status" class="primary_select mb-15">
                                                <option value="1">Paid</option>
                                                <option value="0">Unpaid</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('status')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label class="primary_input_label" for="">Invoice No *</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"
                                                      id="basic-addon1">{{$setting->invoice_prefix}}</span>
                                            </div>
                                            <input type="text" class="form-control primary_input_field"
                                                   name="invoice_no" value="{{old('invoice_no')}}"
                                                   placeholder="Invoice No"
                                                   aria-label="Username" aria-describedby="basic-addon1" required="1">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Type *</label>
                                            <select id="sale_type" name="type" required="1" onchange="deliveryInfo()"
                                                    class="primary_select mb-15">
                                                <option value="1">Regular</option>
                                                <option value="0">Conditional</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('type')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Select Product *</label>
                                            <select class="primary_select mb-15 product_info" id="product_info"
                                                    name="product">
                                                <option value="1">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('product_id')}}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="delivery_info" style="display: none">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">Shipping Name</label>
                                                <input type="text" name="shipping_name" class="primary_input_field"
                                                       value="{{old('shipping_name')}}"
                                                       placeholder="Shipping Name">
                                                <span class="text-danger">{{$errors->first('shipping_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">Shipping Reference
                                                    No</label>
                                                <input type="text" name="shipping_ref" class="primary_input_field"
                                                       value="{{old('shipping_ref')}}"
                                                       placeholder="Shipping Reference No">
                                                <span class="text-danger">{{$errors->first('shipping_ref')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('sale.Date') }}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="startDate" type="text"
                                                                       name="shipping_date" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Tax</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">SubTotal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product_details">


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" style="text-align: right">
                                            <ul>
                                                <li>SubTotal: <span class="total_price"></span></li>
                                                <li>Quantity: <span class="total_quantity"></span></li>
                                                <li>Tax: <span class="total_tax">0</span>%</li>
                                                <li>Discount: <span class="total_discount">0</span>%</li>
                                                <li>Total Amount: <span class="total_amount"></span></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">User</label>
                                            <input type="text" name="user_id" class="primary_input_field"
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->name}}" readonly>
                                            <span class="text-danger">{{$errors->first('user_id')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                   for="">{{__("common.Order Note")}} </label>

                                            <textarea class="lms_summernote" name="notes"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg"><i
                                                class="ti-check"></i>Submit
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('change', '.product_info', function () {
                let id = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: '{{route('order.product.add')}}',
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}",

                    },
                    success: function (data) {
                        console.log(data);
                        $('#product_details').append(data);
                        $('select').niceSelect();

                        let total_quantity = 0;
                        let total_amount = 0;
                        $.each($('.quantity'), function (index, value) {
                            let amount = $(this).val();
                            total_quantity += parseFloat(amount);
                        });
                        $.each($('.product_subtotal'), function (index, value) {
                            let amount = $(this).text();
                            total_amount += parseFloat(amount);
                        });
                        $('.total_price').text(total_amount);
                        $('.total_amount').text(total_amount);

                        if (total_quantity > 0 || !isNaN(total_quantity))
                            $('.total_quantity').text(total_quantity);
                        else
                            $('.total_quantity').text(0);

                        $(".product_info option[value='" + id + "']").attr("disabled", "disabled");
                    }
                })
            });

            $(document).on('click', '.delete_product', function () {
                var whichtr = $(this).closest("tr");
                var id = $(this).data('id');
                whichtr.remove();
                $(".product_info option[value='" + id + "']").attr("disabled", false)
            });

        });

        function addQuantity(id) {
            let price = $(".product_price" + id).text();
            let discount = $('.discount' + id).val();
            let tax = $('.tax' + id).val();
            let quantity = $('.quantity' + id).val();
            let calculated_tax = 0;
            if (tax > 0)
                calculated_tax = ((price * quantity) * tax) / 100;

            let sub_total = ((price * quantity + calculated_tax) - discount)
            $('.product_subtotal' + id).text(sub_total);

            let total_quantity = 0;
            $.each($('.quantity'), function (index, value) {
                let amount = $(this).val();
                total_quantity += parseInt(amount);
            });

            if (total_quantity > 0 || !isNaN(total_quantity))
                $('.total_quantity').text(total_quantity);
            else {
                total_quantity = $('.total_quantity').text();
                $('.total_quantity').text(total_quantity);
            }

            let total_amount = 0;

            $.each($('.product_subtotal'), function (index, value) {
                let amount = $(this).text();
                total_amount += parseFloat(amount);
            });
            $('.total_price').text(total_amount);
            $('.total_amount').text(total_amount);
        }

        function addDiscount(id) {
            let price = $('.product_price' + id).text();
            let discount = $('.discount' + id).val();
            let tax = $('.tax' + id).val();
            let quantity = $('.quantity' + id).val();
            let calculated_tax = 0;
            if (tax > 0)
                calculated_tax = ((price * quantity) * tax) / 100;
            let sub_total = ((price * quantity + calculated_tax) - discount);
            $('.product_subtotal' + id).text(sub_total);

            let total_discount = 0;
            $.each($('.discount'), function (index, value) {
                let amount = $(this).val();
                total_discount += parseInt(amount);
            });

            if (total_discount > 0 || !isNaN(total_discount))
                $('.total_discount').text(total_discount);
            else {
                total_discount = $('.total_discount').text();
                $('.total_discount').text(total_discount);
            }

            let total_amount = 0;

            $.each($('.product_subtotal'), function (index, value) {
                let amount = $(this).text();
                total_amount += parseFloat(amount);
            });
            $('.total_price').text(total_amount);
            $('.total_amount').text(total_amount);
        }

        function addTax(id) {
            let price = $('.product_price' + id).text();
            let discount = $('.discount' + id).val();
            let tax = $('.tax' + id).val();
            let quantity = $('.quantity' + id).val();
            let calculated_tax = 0;
            if (tax > 0)
                calculated_tax = ((price * quantity) * tax) / 100;
            let sub_total = ((price * quantity + calculated_tax) - discount);
            $('.product_subtotal' + id).text(sub_total);

            let total_tax = 0;
            $.each($('.tax'), function (index, value) {
                let amount = $(this).val();
                if (amount)
                    total_tax += parseInt(amount);
            });

            if (total_tax > 0 || !isNaN(total_tax)) {
                $('.total_tax').text(total_tax);
            } else {
                total_tax = $('.total_tax').text();
                $('.total_tax').text(total_tax);
            }

            let total_amount = 0;

            $.each($('.product_subtotal'), function (index, value) {
                let amount = $(this).text();
                total_amount += parseFloat(amount);
            });
            $('.total_price').text(total_amount);
            $('.total_amount').text(total_amount);
        }

        function deliveryInfo() {
            let value = $('#sale_type').val();
            if (value == '0') {
                $('.delivery_info').show();
            } else
                $('.delivery_info').hide();
        }

    </script>
@endpush
