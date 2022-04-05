@extends('backEnd.master')
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('product.New Stock Adjustments')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("stock_adjustment.store")}}" id="sale_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Reference No')}}*</label>
                                            <input type="text" name="ref_no" class="primary_input_field" value="{{old('ref_no')}}" placeholder="Reference No">
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('sale.Date') }}*</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="date" type="text" name="date" value="{{date('m/d/Y')}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.Recovery Amount')}}*</label>
                                            <input type="number" min="0" step="0.01" name="recovery_amount" id="recovery_amount" class="primary_input_field" value="{{old('amount')}}" placeholder="Amount" required>
                                            <span class="text-danger">{{$errors->first('amount')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Select Warehouse or Branch')}}*</label>
                                            <select class="primary_select mb-15 house" onchange="house()" name="warehouse_id">
                                                <option selected disabled>{{__('sale.Select')}}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="warehouse-{{$warehouse->id}}">{{$warehouse->name}}({{__('sale.Warehouse')}})</option>
                                                @endforeach
                                                @foreach($showrooms as $showroom)
                                                    <option value="showroom-{{$showroom->id}}"  @if (session()->get('showroom_id') == $showroom->id) selected @endif>{{$showroom->name}}({{__('sale.Branch')}})</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Select Product')}}*</label>
                                            <select class="primary_select mb-15 product_info" id="product_info" name="product">
                                                <option value="1">{{__('sale.Select Product')}}</option>
                                                @foreach ($products as $product)
                                                    <option value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('product_id')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('sale.Product Name')}}</th>
                                        <th scope="col">{{__('sale.SKU')}}</th>
                                        <th scope="col">{{__('sale.Price')}}</th>
                                        <th scope="col">{{__('sale.Quantity')}}</th>
                                        <th scope="col">{{__('sale.SubTotal')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                        <tbody id="product_details">

                                        </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" style="text-align: right">
                                            <ul>
                                                <li>{{__('sale.Quantity')}}: <span class="total_quantity"></span></li>
                                                <li>{{__('sale.Total Amount')}}: <span class="total_amount"></span></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.User')}}</label>
                                            <input type="text" name="user_id" class="primary_input_field" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" readonly>
                                            <span class="text-danger">{{$errors->first('user_id')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">{{__("product.Reason")}} </label>
                                            <textarea class="summernote3" name="notes"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 mt-3">
                                        <div class="submit_btn text-center ">
                                            <button class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i>{{__('sale.Submit')}} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" value="{{urlShortener()}}" class="url">
        <div class="view_modal">

        </div>
    </div>
    @push("scripts")
        <script type="text/javascript">
            var baseUrl = $('#app_base_url').val();

            function priceCalc(id, type) {
                let product = $('.product_info').val();
                let price = $(".product_price_" + type + id).val();
                let sku_id = $('.sku_id_' + type + id).val();
                let quantity = $('.quantity_' + type + id).val();
                let house = $('.house').val();
                let calculated_tax = 0;
                let calculated_discount = 0;

                let sub_total = (price * quantity)
                $('.product_subtotal_' + type + id).text(sub_total);

                let total_quantity = 0;
                $.each($('.quantity'), function (index, value) {
                    let amount = $(this).val();
                    total_quantity += parseInt(amount);
                });

                if (total_quantity > 0 || !isNaN(total_quantity)) {
                    $('.total_quantity').text(total_quantity);
                    $('.total_quantity').val(total_quantity);
                } else {
                    total_quantity = $('.total_quantity').text();
                    $('.total_quantity').text(total_quantity);
                    $('.total_quantity').val(total_quantity);
                }

                let total_amount = 0;

                $.each($('.product_subtotal'), function (index, value) {
                    let amount = $(this).text();
                    total_amount += parseFloat(amount);
                });

                let final_amount = total_amount;
                $('.total_price').val(total_amount);
                $('.total_amount').text(final_amount);
                $('.total_amount').val(final_amount);
            }

            function house()
            {
                let val = $('.house').val();

                $.ajax({
                    method : 'POST',
                    url : "{{route('check.existence')}}",
                    data : {
                      _token : "{{csrf_token()}}",
                      val : val,
                    },
                    success : function (resutl){
                        $('.product_info').html(resutl);
                        $('select').niceSelect('update');
                    }
                })
            }

            $(document).ready(function () {
                $(document).on('change', '.product_info', function () {
                    let id = $(this).val();
                    $.post('{{ route('stock_adjustment.product_modal_for_select') }}', {
                        _token: '{{ csrf_token() }}',
                        id: id
                    }, function (data) {
                        if (data.product_type == "Variable") {
                            $('.view_modal').html(data.html);
                            $('#Item_Details').modal('show');
                        }
                        else if (data.product_type == "Single") {
                            selectProduct(data.product_id);
                        } else {
                            selectComboProduct(data.product_id);
                        }
                        $('.charging_infos').show();
                    });
                });

                $(document).on('click', '.delete_product', function () {
                    var whichtr = $(this).closest("tr");
                    var id = $(this).data('id');
                    var product = $(this).data('product');
                    let quantity = $('.quantity' + id).val();
                    whichtr.remove();
                    let total_amount = 0;
                    $.each($('.product_subtotal'), function (index, value) {
                        let amount = $(this).text();
                        total_amount += parseFloat(amount);
                    });
                    $('.total_price').text(total_amount);
                    $('.total_amount').text(total_amount);

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

                    $.ajax({
                        method: "POST",
                        url: "{{route('item.delete')}}",
                        data: {
                            product: product,
                            quantity: quantity,
                            _token: "{{csrf_token()}}"
                        },
                        success: function (result) {
                            toastr.success(result,'Success!');
                        }
                    })
                });

                $(document).on('change', '#paying_method', function () {
                    let value = $(this).val();

                    if (value == 'cheque')
                        $('.cheque').show()
                    else
                        $('.cheque').hide()
                })
            });

            function addQuantity(id, type) {
                let product = $('.product_info').val();
                let price = $(".product_price_" + type + id).val();
                let sku_id = $('.sku_id_' + type + id).val();
                let quantity = $('.quantity_' + type + id).val();
                let house = $('.house').val();
                let calculated_tax = 0;
                let calculated_discount = 0;

                let sub_total = (price * quantity)
                $('.product_subtotal_' + type + id).text(sub_total);

                let total_quantity = 0;
                $.each($('.quantity'), function (index, value) {
                    let amount = $(this).val();
                    total_quantity += parseInt(amount);
                });

                if (total_quantity > 0 || !isNaN(total_quantity)) {
                    $('.total_quantity').text(total_quantity);
                    $('.total_quantity').val(total_quantity);
                } else {
                    total_quantity = $('.total_quantity').text();
                    $('.total_quantity').text(total_quantity);
                    $('.total_quantity').val(total_quantity);
                }

                let total_amount = 0;

                $.each($('.product_subtotal'), function (index, value) {
                    let amount = $(this).text();
                    total_amount += parseFloat(amount);
                });

                let final_amount = total_amount;
                $('.total_price').val(total_amount);
                $('.total_amount').text(final_amount);
                $('.total_amount').val(final_amount);
            }


            function selectProduct(el) {
                $.ajax({
                    method: 'POST',
                    url: "{{route('stock_adjustment.product_add')}}",
                    data: {
                        id: el,
                        _token: "{{csrf_token()}}",
                    },
                    success: function (data) {
                        if (data == 1)
                            toastr.error('this item is already added')
                        else {
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
                            $('.total_price').val(total_amount);
                            $('.total_amount').text(total_amount);
                            $('.total_amount').val(total_amount);

                            if (total_quantity > 0 || !isNaN(total_quantity)) {
                                $('.total_quantity').text(total_quantity);
                                $('.total_quantity').val(total_quantity);
                            } else {
                                $('.total_quantity').text(0);
                                $('.total_quantity').val(0);
                            }

                        }
                    }
                });
            }


            function selectComboProduct(el) {
                let currentUrl = $('.url').val();
                let id = $('.url').data('id');
                let url = 'purchase/combo_product_add';

                $.ajax({
                    method: 'POST',
                    url: "{{url('/')}}" + '/' + url,
                    data: {
                        id: el,
                        _token: "{{csrf_token()}}",
                    },
                    success: function (data) {
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
                        if (total_quantity > 0 || !isNaN(total_quantity))
                            $('.total_quantity').text(total_quantity);
                        else
                            $('.total_quantity').text(0);
                    }
                })
            }
        </script>
    @endpush
@endsection
