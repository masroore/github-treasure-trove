@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Stock Report</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Start Sms Details -->
        <div class="col-lg-12 student-details">
            <ul class="nav nav-tabs tab_column" role="tablist">
                @foreach($stocks as $key=> $stock)
                    <li class="nav-item">
                        <a class="nav-link {{$key == 0 ? 'active' : ''}}" href="#house{{$stock->houseable_id}}" role="tab" data-toggle="tab">{{$stock->houseable->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($stocks as $key => $stock)
                <div role="tabpanel" class="tab-pane fade {{$key == 1 ? 'active show' : ''}}" id="house{{$stock->houseable_id}}">
                        <div class="white-box mt-2">
                            <div class="row">
                                <div class="col-12 select_sms_services">
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table ">
                                            <!-- table-responsive -->
                                            <div class="">
                                                @php
                                                    $total = 0;
                                                @endphp
                                                <table class="table Crm_table_active3">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <label class="primary_checkbox d-flex ">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </th>
                                                        <th scope="col">Sl</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">SKU</th>
                                                        <th scope="col">Product Type</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Brand</th>
                                                        <th scope="col">In Stock</th>
                                                        <th scope="col">Stock Alert</th>
                                                        <th scope="col">Sale Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                    $product_stocks = stockList($stock->houseable_id,$stock->houseable_type);
                                                    @endphp
                                                    @foreach($product_stocks as $key => $product_stock)

                                                        <tr>
                                                            <th scope="col">
                                                                <label class="primary_checkbox d-flex">
                                                                    <input name="sms1" type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </th>
                                                            <th>{{$key+1}}</th>
                                                            <td>
                                                                <img style="height: 36px;" src="{{asset(@$product_stock->productSku->product->image_source)}}">
                                                            </td>
                                                            <td>{{@$product_stock->productSku->product->product_name}}</td>
                                                            <td>{{@$product_stock->productSku->sku}}</td>
                                                            <td>{{@$product_stock->productSku->product->product_type}}</td>
                                                            <td>{{@$product_stock->productSku->product->category->name}}</td>
                                                            <td>{{@$product_stock->productSku->product->brand->name}}</td>
                                                            <td>{{@$product_stock->stock}}</td>
                                                            <td>{{@$product_stock->productSku->alert_quantity}}</td>
                                                            <td>{{@$product_stock->productSku->selling_price}} / <small>{{ @$product_stock->productSku->product->unit_type->name }}</small></td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    @push("scripts")
        <script type="text/javascript">
         var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {
                $(".table").dataTable();
                $(".product_view").unbind().click(function () {
                    let product_id = $(this).data("value");
                    $.ajax({
                        url: baseUrl + "/product/add_product/" + product_id,
                        type: "GET",
                        success: function (response) {
                            console.log(response);
                            $(".view_product_name").html(response.data.product_name);
                            $("#view_product_sku").html(response.data.product_sku);
                            $("#view_product_type").html(response.data.product_type);
                            $("#view_product_category").html(response.data.category.name);
                            $("#view_product_brand").html(response.data.brand.name);
                            $("#view_product_model").html(response.data.model.name);
                            $("#view_barcode_type").html(response.data.barcode_type);
                            $("#view_alert_quantity").html(response.data.alert_quantity);
                            $("#view_product_unit").html(response.data.unit_type.name);
                            $("#view_product_description").html(response.data.description);
                            $("#view_product_image").attr("src", "/" + response.data.image_source);
                            let variant = `<div class="col-lg-12 choose_variant">
                                            <div class="QA_section2 QA_section_heading_custom check_box_table">
                                                <div class="QA_table mb_15">
                                                    <div class="table-responsive">
                                                    <table class="table">
                                                        <thead id="variant_section_head">
                                                        <tr>`;
                            let product_variant_type = response.product_variant_type.map(function (value, key) {
                                return parseInt(value);
                            });
                            variant += `<th scope="col">Product Image</th>`;
                            $.each(response.variants, function (v_key, v_value) {
                                if (product_variant_type.includes(v_value.id)) {
                                    variant += `<th>${v_value.name}</th>`;
                                }
                            });
                            variant += `<th scope="col">SKU</th>
                                        <th scope="col">Default Purchase Price</th>
                                        <th scope="col">Default Selling Price</th>
                                        </tr></thead><tbody>`;
                            $.each(response.data.variations, function (v_i_key, v_i_value) {
                                console.log(v_i_value);
                                variant += `<tr>`;
                                variant += `<td>
                                                <img  style="height:70px;" src="/${response.data.image_source}">
                                            </td>`;
                                $.each(response.variant_values, function (v_key, v_value) {
                                    if (v_i_value.variation_value.includes(v_value.id)) {
                                        variant += `<td>${v_value.value}</td>`;
                                    }
                                });
                                variant += `<td>${v_i_value.variation_sku}</td>
                                            <td>
                                                 <input value="${v_i_value.default_purchase_price_exc_tax}" type="text" style="width: 70%;"class="primary_input_field"/>
                                                 <input value="${v_i_value.default_purchase_price_inc_tax}" type="text" style="margin-top: 5%;width: 70%;" class="primary_input_field"/>
                                            </td>
                                            <td>
                                                 <input value="${v_i_value.default_selling_price_exc_tax}" type="text" style="width: 70%;" class="primary_input_field"/>
                                                 <input value="${v_i_value.default_selling_price_inc_tax}"  type="text" style="margin-top: 5%;width: 70%;"class="primary_input_field"/>
                                            </td>

                                           </tr>`;
                            });


                            variant += `</tbody></table></div></div></div>`;
                            $("#view_product_variant").html(variant);

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
