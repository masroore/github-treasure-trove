@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('sale.Edit Transfer')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("stock-transfer.update",$transfer->id)}}" method="POST"
                                  enctype="multipart/form-data">@method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.From')}}</label>
                                            <select class="primary_select mb-15 showroom_from contact_type house" name="from">
                                                @if (Auth::user()->role->type == "system_user")
                                                    <option selected disabled>{{__('common.Select')}}</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option
                                                            value="warehouse-{{$warehouse->id}}" {{$warehouse->sends()->exists() && $warehouse->id == $transfer->sendable->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                                    @endforeach
                                                    @foreach($showrooms as $showroom)
                                                        <option
                                                            value="showroom-{{$showroom->id}}" {{$showroom->sends()->exists() && $showroom->id == $transfer->sendable->id ? 'selected' : ''}}>{{$showroom->name}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="showroom-{{ $transfer->sendable->id }}" selected > {{showroomName()}}</option>
                                                @endif
                                               
                                            </select>
                                            <span class="text-danger">{{$errors->first('from')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.To')}}</label>
                                            <select class="primary_select mb-15 contact_type" name="to">
                                                <option selected disabled>{{__('common.Select')}}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option
                                                        value="warehouse-{{$warehouse->id}}" {{$warehouse->receives()->exists() && $warehouse->id == $transfer->receivable->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                                @endforeach
                                                @foreach($showrooms as $showroom)
                                                    <option
                                                        value="showroom-{{$showroom->id}}" {{$showroom->receives()->exists() && $showroom->id == $transfer->receivable->id ? 'selected' : ''}}>{{$showroom->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('to')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('sale.Date') }}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text"
                                                                   name="date" value="{{$transfer->date}}"
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
                                </div>
                                <div class="row">
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md- col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Attach Document')}} <span class="text-muted">({{__('quotation.pdf,csv,jpg,png,doc,docx,xlsx,zip')}})</span></label>
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
                                    <div class="col-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Select Product')}}</label>
                                            <select class="primary_select mb-15 product_info" id="product_info"
                                                    name="product">
                                                <option value="1">{{__('quotation.Select Product')}}</option>
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
                                        <th scope="col">{{__('quotation.Product Name')}}</th>
                                        <th scope="col">{{__('product.SKU')}}</th>
                                        <th scope="col">{{__('quotation.Price')}}</th>
                                        <th scope="col">{{__('quotation.Quantity')}}</th>
                                        <th scope="col">{{__('quotation.SubTotal')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product_details">
                                    @foreach($transfer->items as $item)
                                        @php
                                            $v_name = [];
                                            $v_value = [];
                                            $variantName = variantName($item);
                                        $type =$item->product_sku_id.",'sku'" ;
                                        @endphp
                                        <tr>
                                            <td><input type="hidden" name="items[]" class="sku_id" value="{{$item->product_sku_id}}">
                                                {{$item->productSku->product->product_name}} <br>
                                                @if ($variantName)
                                                    ({{ $variantName }})
                                                @endif
                                            </td>
                                            <td>{{$item->productSku->sku}}</td>
                                            <td><input min="{{$item->productSku->purchase_price}}"
                                                   onkeyup="priceCalc({{$type}})"
                                                   class="primary_input_field product_price product_price_sku{{$item->product_sku_id}}"
                                                   type="number"
                                                   value="{{$item->price}}" name="item_price[]"></td>
                                            <td>
                                                <input type="number" onfocusout="addQuantity({{$type}})"
                                                       name="item_quantity[]" value="{{$item->quantity}}"
                                                       class="primary_input_field quantity quantity_sku{{$item->product_sku_id}}">
                                            </td>
                                            <td style="text-align: center;" class="product_subtotal product_subtotal_sku{{$item->product_sku_id}}">{{$item->sub_total}}</td>
                                            <td><a data-id="{{$item->id}}" data-product="{{$item->id}}"
                                                   class="delete_product primary-btn primary-circle fix-gr-bg" href="javascript:void(0)">
                                                    <i class="ti-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" style="text-align: right">
                                            <ul>
                                               
                                                <li>Quantity: <span class="total_quantity">{{number_format($transfer->items->sum('quantity'),2)}}</span>
                                                </li>

                                                <li>Total Amount: <span class="total_amount">{{number_format($transfer->items->sum('sub_total'),2)}}</span>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                   for="">{{__("product.Transfer Note")}} </label>

                                            <textarea class="summernote3"
                                                      name="notes">{{$transfer->notes}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-20">
                                    <div class="submit_btn text-center">
                                        <button class="primary-btn semi_large2 fix-gr-bg"><i
                                                class="ti-check"></i>{{__('quotation.Submit')}}
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" data-id="{{$transfer->id}}" value="{{urlShortener()}}" class="url">
        <div class="view_modal">

        </div>
    </div>
@endsection
@push("scripts")
    <script type="text/javascript">
        var baseUrl = $('#app_base_url').val();

        $(document).ready(function () {
            $(document).on('change', '.product_info', function () {
                let id = $(this).val();
                $.post('{{ route('stock.product_modal_for_select') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function (data) {
                    if (data.product_type == "Variable") {
                        $('.view_modal').html(data.html);
                        $('#Item_Details').modal('show');
                    }
                    if (data.product_type == "Single") {
                        selectProduct(data.product_id);
                    } else {
                        selectComboProduct(data.product_id);
                    }
                });
            });

            $(document).on('click', '.delete_product', function () {
                var whichtr = $(this).closest("tr");
                var id = $(this).data('id');
                var item_id = $(this).data('item');
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

                let delete_selector = $('.delete_product');

                if (delete_selector.length > 1) {
                    delete_selector.show();
                } else {
                    delete_selector.hide();
                }
                $.ajax({
                    method: 'POST',
                    url: '{{url('/purchase/product_delete_model')}}',
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}",
                    },
                    success: function (result) {
                        $("#product_info option[value='" + id + "']").removeAttr('disabled');
                        $('select').niceSelect('update');
                    }
                })
            });
        });

        function selectProduct(el) {
            let currentUrl = $('.url').val();

            let id = $('.url').data('id');
            let url = 'purchase/product_add';
            if (currentUrl == baseUrl+'/inventory/stock-transfer/create' || currentUrl == baseUrl+'/inventory/stock-transfer/' + id + '/edit') {
                url = 'inventory/stock-products';
            }
            if (currentUrl == baseUrl+'/pos/pos-order-products') {
                url = 'pos/pos-find-products';
            }

            $.ajax({
                method: 'POST',
                url: "{{url('/')}}" + '/' + url,
                data: {
                    id: el,
                    url: currentUrl,
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
                    $('.total_price').val(total_amount);
                    $('.total_amount').text(total_amount);
                    $('.total_amount').val(total_amount);
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
                    if (total_quantity > 0 || !isNaN(total_quantity)) {
                        $('.total_quantity').text(total_quantity);
                        $('.total_quantity').val(total_quantity);
                    } else {
                        $('.total_quantity').text(0);
                        $('.total_quantity').val(0);
                    }
                }
            })
        }
        function priceCalc(id, type) {
            let price = $(".product_price_" + type + id).val();
            let sku_id = $('.sku_id_' + type + id).val();
            let quantity = $('.quantity_' + type + id).val();
            let house = $('.house').val();

            let sub_total = (price * quantity);
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
            $('.total_price').val(total_amount);
            $('.total_amount').text(total_amount);
        }
        function addQuantity(id,type) {
            let product = $('.product_info').val();
            let datatype = $('.quantity_'+type+id).data('type');
            let price = $(".product_price_"+type + id).val();
            let sku_id = $('.sku_id_'+type + id).val();
            let quantity = $('.quantity_'+type + id).val();
            let house = $('.house').val();

            $.ajax({
                method: 'POST',
                url: "{{route('check.quantity')}}",
                data: {
                    id: id,
                    type: datatype,
                    house: house,
                    quantity: quantity
                },
                success: function (result) {
                    if (result)
                        toastr.warning(result);
                    else {
                       
                        let sub_total = (price * quantity)
                        $('.product_subtotal_'+type + id).text(sub_total);

                        let total_quantity = 0;
                        $.each($('.quantity'), function (index, value) {
                            let amount = $(this).val();
                            total_quantity += parseInt(amount);
                        });

                        if (total_quantity > 0 || !isNaN(total_quantity))
                        {
                            $('.total_quantity').text(total_quantity);
                            $('.total_quantity').val(total_quantity);
                        }
                        else {
                            total_quantity = $('.total_quantity').text();
                            $('.total_quantity').text(total_quantity);
                            $('.total_quantity').val(total_quantity);
                        }

                        let total_amount = 0;


                        $.each($('.product_subtotal'), function (index, value) {
                            let amount = $(this).text();
                            total_amount += parseFloat(amount);
                        });
                        $('.total_price').val(total_amount);
                        $('.total_amount').text(total_amount);

                    }
                }
            })
        }
        $(document).on('change', '.showroom_from', function () {
                let id = $(this).val();

                $.ajax({
                    method: 'POST',
                    url: '{{route('stock.product')}}',
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}",

                    },
                    success: function (data) {
                        $('.product_info').empty();
                        $('.product_info').append(data);
                        $('select').niceSelect('update'); // add this
                    }
                })
            });
    </script>
@endpush
