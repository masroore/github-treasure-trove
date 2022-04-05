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
                                    <a href="javascript:void(0)" onclick="selectProduct({{ $sku->id }})"><img src="{{ asset($product->image_source  ?? 'public/backEnd/img/no_image.png') }}" alt="{{$sku->sku}}" id="view_product_image" style="height:200px;"></a>
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
                                            $variantName .= $v_name[$i] . ' : ' . $v_value[$i] .' ; ';
                                        }
                                    }
                                @endphp
                                <div class="col-xl-6 text-center">
                                    <a href="javascript:void(0)" onclick="selectProduct({{ $sku->id }})"><img src="{{ asset($sku->product_variation->image_source  ?? 'public/backEnd/img/no_image.png') }}" id="view_product_image" style="height:150px;"></a>
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
    function selectProduct(el){
        let currentUrl =$('.url').val();
        let id =$('.url').data('id');
        let url = 'stock-adjustment/product-add';

        $.ajax({
            method: 'POST',
            url: "{{route('stock_adjustment.product_add')}}",
            data: {
                id: el,
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                if (data == 1)
                    toastr.warning('this item is already added','Info!');
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
                    $('.total_price').text(total_amount);
                    $('.total_amount').text(total_amount);
                    if (total_quantity > 0 || !isNaN(total_quantity))
                        $('.total_quantity').text(total_quantity);
                    else
                        $('.total_quantity').text(0);
                }
            }
        })
        $(".modal .close").click();
    }
</script>
