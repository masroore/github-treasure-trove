<div class="modal fade admin-query" id="Item_Details">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('product.Details') }}<span class="view_product_name"></span></h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">
                        @if ($product->product_type == "Single")
                            @foreach ($product->skus as $key => $sku)
                                <div class="col-xl-4 text-center">
                                    <a href="javascript:void(0)" onclick="selectProduct({{ $sku->id }})"><img src="{{ asset($product->image_source ?? 'public/backEnd/img/no_image.png') }}" alt="{{$sku->sku}}" id="view_product_image" style="height:200px;width:200px;"></a>
                                    <h5 class="mt-2 sku_name">{{ $sku->sku }}</h5>
                                </div>
                            @endforeach
                        @else
                            @foreach ($product->skus as $key => $sku)
                                @php
                                    $v_name = [];
                                    $v_value = [];
                                    $p_name = [];
                                    $p_qty = [];
                                    $variantName = null;
                                    if ($sku->product && $sku->product_variation) {
                                        foreach (json_decode($sku->product_variation->variant_id) as $key => $value) {
                                            array_push($v_name , Modules\Product\Entities\Variant::find($value)->name);
                                        }
                                        foreach (json_decode($sku->product_variation->variant_value_id) as $key => $value) {
                                            array_push($v_value , Modules\Product\Entities\VariantValues::find($value)->value);
                                        }

                                        for ($i=0; $i < count($v_name); $i++) {
                                            if (count($v_name) > 1) {
                                                $variantName .= $v_name[$i] . ' : ' . $v_value[$i] .' ; ';
                                            }else {
                                                $variantName .= $v_name[$i] . ' : ' . $v_value[$i];
                                            }

                                        }
                                    }
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-md-6 text-center">
                                    <a href="javascript:void(0)" onclick="selectProduct({{ $sku->id }})"><img src="{{ asset($sku->product_variation->image_source ?? 'public/backEnd/img/no_image.png') }}" id="view_product_image" style="height:150px;width:150px;"></a>
                                    <h5 class="mt-2">{{ $variantName }}</h5>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var baseUrl = $('#app_base_url').val();

    function selectProduct(el){
        let currentUrl =$('.url').val();
        let id =$('.url').data('id');
        let purpose = null;
        let url = 'purchase/product_add';
        let customer = $('.customer').val();
        let sku_quantity = parseInt($('.quantity_sku'+el).val());
        let sale_customer = $('.contact_type').val();

        if (currentUrl == baseUrl+'/inventory/stock-transfer/create' || currentUrl == baseUrl+'/inventory/stock-transfer/'+id+'/edit')
        {
            url = 'inventory/stock-products';
        }
        if (currentUrl == baseUrl+'/pos/pos-order-products')
        {
            url = 'pos/pos-find-products';
        }
        if (currentUrl == baseUrl+'/sale/sale/create' || currentUrl == baseUrl+'/sale/sale/'+id+'/edit' || currentUrl == baseUrl+'/sale/sale-clone/'+id)
        {
            url = 'sale/product_add';
            purpose = 'sale';
        }
        if (currentUrl == baseUrl+'/conditional-sale/create' || currentUrl == baseUrl+'/sale/sale/'+id+'/edit')
        {
            url = 'sale/product_add';
            purpose = 'sale';
        }

        if (currentUrl == baseUrl+'/quotation/quotation/create' || currentUrl == baseUrl+'/quotation/quotation/'+id+'/edit' || currentUrl == baseUrl+'sale/sale-quotation-convert/'+id)
        {
            url = 'quotation/add-product';
        }

        $.ajax({
            method: 'POST',
            url: "{{url('/')}}"+'/'+url,
            data: {
                id: el,
                purpose:purpose,
                customer : customer,
                sale_customer : sale_customer,
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                if (data == 1)
                {
                //   $('.quantity_sku'+el).val(sku_quantity+1);
                    let totalQTY = sku_quantity + 1;
                    let productPrice = parseFloat($(".product_price_sku"+ el).val());
                    $('.quantity_sku' + el).val(totalQTY);
                    let totalBillAmount = totalQTY * productPrice;
                    $('.product_subtotal_sku' + el).text(totalBillAmount.toFixed(2)  );
                }
                else {
                    $('#product_details').append(data);
                    $('select').niceSelect();
                    $('.last_price_td').show();
                    $('.last_price').show();
                    if (url == 'pos/pos-find-products')
                    {
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
                        $('.payable_price').text(total_amount);
                        $('.total_amount').val(total_amount);
                        let vat = parseFloat($('.total_vat').val());
                        let discount = parseFloat($('.total_discount').val());
                        let calculated_discount = 0;
                        let calculated_vat = 0;
                        if (vat > 0)
                            calculated_vat = (total_amount * vat) / 100;
                        if (discount > 0)
                            calculated_discount = (total_amount * discount) / 100;
                        let final_amount = (total_amount + calculated_vat) - calculated_discount;
                        $('.total_amount_tr').text((final_amount).toFixed(2));
                        $('.amount').val(total_amount);
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
                    else{

                        totalQuantity();
                        productDiscount();
                        totalQuantity();
                        SubTotal();
                        grandTotal();
                        billingInfo();
                        $('.last_price_td').show();

                    }
                }
                // $(".product_info option[value='" + id + "']").attr("disabled", "disabled");
                addTotalDiscount();
                productTax();
            }
        })
        $(".modal .close").click();
    }
</script>
