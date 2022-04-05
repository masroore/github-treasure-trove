@extends('backEnd.master')
@section('mainContent')
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-25" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__("common.Edit Product")}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <!-- Prefix  -->
                        <form action="{{route("add_product.update",$product->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("Patch")
                            <div class="row">
                                <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('product.Product Type')}}</label>
                                        <select class="primary_select mb-15 product_type" name="product_type" disabled>
                                            <option @if($product->product_type=="Single") selected @endif>{{__('product.Single')}} </option>
                                            <option @if($product->product_type=="Variable") selected @endif>{{__('product.Variable')}} </option>
                                            <option @if($product->product_type=="Combo") selected @endif>{{__('product.Combo')}}</option>
                                            <option value="Service" @if($product->product_type=="Service") selected @endif>{{__('product.Service')}}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('product_type')}}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Product Name")}} </label>
                                        <input class="primary_input_field" name="product_name" placeholder="Product Name" type="text" value="{{$product->product_name}}">
                                        <span class="text-danger">{{$errors->first('product_name')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}"  >
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Product SKU")}} </label>
                                        <input type="text" name="product_sku" id="product_sku" class="primary_input_field" value="{{($product->product_type == "Single" or $product->product_type == 'Service') ? $product->skus->first()->sku : ""}}">
                                        <span class="text-danger">{{$errors->first('product_sku')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none" id="product_origin_div">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Part Number")}}</label>
                                      <input type="text" name="origin" id="origin" class="primary_input_field" value="{{$product->origin}}">
                                      <span class="text-danger">{{$errors->first('origin')}}</span>
                                   </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">

                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Unit")}}</label>
                                        <select name="unit_type_id" class="primary_select mb-15">
                                            <option>{{__('product.Select Unit')}}</option>
                                        @foreach($units as $key=>$unit_value)
                                                <option value="{{$unit_value->id}}" @if($product->unit_type_id == $unit_value->id) selected @endif>{{$unit_value->name}} (s) </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('unit_type_id')}}</span>
                                    </div>

                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}" id="barcode_type_div">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('product.Barcode Type')}}</label>
                                        <select name="barcode_type" id="unit_type_id" class="primary_select mb-15">
                                            <option value="">{{__('product.Select Barcode')}}</option>
                                            <option value="{{@$product->skus->first()->barcode_type}}" selected>{{@$product->skus->first()->barcode_type}}</option>
                                            <option value="C39">C39</option>
                                            <option value="PHARMA2T">PHARMA2T</option>
                                            <option value="C39+">C39+</option>
                                            <option value="C39E">C39E</option>
                                            <option value="C39E+">C39E+</option>
                                            <option value="C93">C93</option>
                                            <option value="S25">S25</option>
                                            <option value="I25">I25</option>
                                            <option value="EAN2">EAN2</option>
                                            <option value="EAN5">EAN5</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('barcode_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}" >
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Brand")}}</label>
                                        <select name="brand_id" class="primary_select mb-15">
                                            <option>{{__('product.Select Brand')}}</option>
                                        @foreach($brands as $key=>$brand_value)
                                                <option value="{{$brand_value->id}}" @if($product->brand_id == $brand_value->id) selected @endif>{{$brand_value->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('brand_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Category")}}</label>
                                        <select name="category_id" class="primary_select mb-15 category">
                                            <option value="">{{__('product.Select Category')}}</option>
                                        @foreach($categories as $key=>$category_value)
                                                <option value="{{$category_value->id}}" @if($product->category_id == $category_value->id) selected @endif>{{$category_value->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('category_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Sub Category")}}</label>
                                        <select class="primary_select mb-15" id="sub_category_list" name="sub_category_id">
                                            <option value="{{$product->sub_category_id}}">{{@$product->subcategory->name}}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('sub_category_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">

                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('product.Model')}}</label>
                                        <select class="primary_select mb-15" id="sub_category_list" name="model_id">
                                            <option>{{__('product.Select Model')}}</option>
                                        @foreach($models as $key=>$model_value)
                                                <option value="{{$model_value->id}}" @if($product->model_id == $model_value->id) selected @endif>{{$model_value->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('model_id')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Alert Quantity")}}  </label>
                                      <div class="">
                                         <input type="number" name="alert_quantity" id="alert_quantity" value="{{ $product->product_type == "Single" ? $product->skus->first()->alert_quantity : "" }}" class="primary_input_field">
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('common.Image')}} </label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName"
                                                   placeholder="Browse file" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="document_file_1">{{__("common.Browse")}} </label>
                                                <input type="file" class="d-none" name="file" id="document_file_1">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Purchase Price")}}  </label>
                                      <div class="">
                                         <input type="number" name="purchase_price" id="purchase_price" value="{{ $product->product_type == "Single" ? $product->skus->first()->purchase_price : "" }}" class="primary_input_field">
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Selling Price")}}  </label>
                                      <div class="">
                                         <input type="number"  step="0.01" name="selling_price" id="selling_price" value="{{ ($product->product_type == "Single" or $product->product_type == "Service") ? $product->skus->first()->selling_price : "" }}" class="primary_input_field" {{ $product->product_type != 'Service' ? 'required' : '' }}>
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4 {{ $product->product_type != 'Service' ? 'd-none' : '' }}" id="hourly_rate_div" >
                                    <div class="primary_input mb-15">
                                       <label class="primary_input_label" for="">{{__("common.Hourly Rate")}} *</label>
                                       <div class="">
                                          <input type="number"  step="0.01" name="hourly_rate" id="hourly_rate" value="{{ ($product->product_type == "Single" or $product->product_type == "Service") ? $product->skus->first()->selling_price : "" }}" class="primary_input_field" >
                                       </div>
                                    </div>
                                 </div>
                                @if($product->product_type == "Single" )
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Min. Selling Price")}} </label>
                                        <div class="">
                                            <input type="number" name="min_selling_price" id="selling_price" value="{{$product->skus->first()->min_selling_price}}" class="primary_input_field" >
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-4 {{ $product->product_type == 'Service' ? 'd-none' : '' }}" id="other_currency_price">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Price of Other Currency")}}  </label>
                                        <div class="">
                                            <input type="number" name="price_of_other_currency" id="price_of_other_currency" value="{{$product->price_of_other_currency}}" class="primary_input_field" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 {{ $product->product_type == 'Service' ? 'd-none' : '' }}">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Tax")}}  </label>
                                      <div class="">
                                         <input type="number" name="tax" value="{{ $product->skus->first()->tax }}" id="tax" class="primary_input_field">
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-1 {{ $product->product_type == 'Service' ? 'd-none' : '' }}" id="tax_type_div">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Tax Type")}}  </label>
                                      <div class="">
                                          <input type="text" name="tax_type" id="tax_type" class="primary_input_field tax_type" value="%" readonly>
                                      </div>
                                   </div>
                                </div>

                                <div class="col-xl-12">
                                   <div class="primary_input mb-40">
                                      <label class="primary_input_label" for=""> {{__("common.Description")}} </label>
                                      <textarea class="summernote" name="product_description">{{ $product->description }}</textarea>
                                   </div>
                                </div>

                                @if ($product->product_type =="Variable")
                                    <div class="col-lg-4 choose_variant">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.Choose Variant')}}</label>
                                            <select class="primary_select mb-15 selected_variant" name="selected_variant[]" multiple>
                                                @foreach($variants as $key => $variant_value)
                                                    <option value="{{$variant_value->id}}" @if(in_array($variant_value->id,$product_variant_type)) selected @endif>{{$variant_value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-4 choose_variant" style="display: none;">
                                       <div class="primary_input mb-15">
                                          <label class="primary_input_label" for="">{{__('product.Choose Variant')}}</label>
                                          <select class="primary_select mb-15 selected_variant" name="selected_variant[]" multiple>
                                             @foreach($variants as $key=>$variant_value)
                                                 <option value="{{$variant_value->id}}">{{$variant_value->name}}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                @endif

                            </div>
                            @if($product_variant_type == null)
                                <div class="col-lg-12 choose_variant" style="display: none;">
                                    <div class="QA_section2 QA_section_heading_custom check_box_table">
                                        <div class="QA_table mb_15">
                                            <!-- table-responsive -->
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead id="variant_section_head">
                                                    </thead>
                                                    <tbody>
                                                        <tr class="variant_row_lists">
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @if($product->product_type =="Variable")
                                        <div class="add_items_button pt-10">
                                            <button type="button" class="primary-btn radius_30px add_variant_row  fix-gr-bg"><i class="ti-plus"></i>{{__("common.Add Variation")}}
                                            </button>
                                        </div>
                                     @endif
                                </div>
                            @else
                                <div class="col-lg-12 choose_variant">
                                    <div class="QA_section2 QA_section_heading_custom check_box_table">
                                        <div class="QA_table mb_15">
                                            <!-- table-responsive -->
                                            <div class="">
                                                <table class="table">
                                                    <thead id="variant_section_head">
                                                    <tr>
                                                        @foreach($variants as $key => $variant_value)
                                                            @if(in_array($variant_value->id,$product_variant_type))
                                                                <th scope="col">{{$variant_value->name}}</th>
                                                            @endif
                                                        @endforeach
                                                        <th scope="col">{{__('product.SKU')}}</th>

                                                        <th scope="col">{{__('product.Alert Qty')}}</th>
                                                        <th scope="col">{{__('product.Purchase Price')}}</th>
                                                        <th scope="col">{{__('common.Min. Selling Price')}}</th>
                                                        <th scope="col">{{__('product.Selling Price')}}</th>
                                                        <th scope="col">{{__('product.Product Images')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 2;
                                                        @endphp
                                                    @foreach($product->variations as $key => $product_variation_value)
                                                        <tr class="variant_row_lists">
                                                            @foreach($variant_values as $key=>$variant_value)
                                                                @if(in_array($variant_value['id'],json_decode($product_variation_value->variant_value_id)))
                                                                    <td>
                                                                        <input readonly value="{{$variant_value['value']}}" type="text" class="primary_input_field"/>
                                                                        <input name='variation_type[]' hidden value="{{$variant_value['variant_id']}}" type="text" class="primary_input_field"/>
                                                                        <input name='variation_value_id[]' hidden value="{{$variant_value['id']}}" type="text" class="primary_input_field"/>
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                                <input type="hidden" name="product_sku_ids[]" value="{{$product_variation_value->product_sku_id}}">
                                                            <td>
                                                                <input name='variation_sku[]' value="{{$product_variation_value->product_sku->sku}}" readonly="readonly" type="text" class="primary_input_field"/>
                                                            </td>

                                                            <td>
                                                               <input type="number" min="0" step="1" value="{{$product_variation_value->product_sku->alert_quantity}}" class="primary_input_field" name="alert_quantities[]">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="primary_input_field" name='purchase_prices[]' value="{{$product_variation_value->product_sku->purchase_price}}"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="primary_input_field" name='min_selling_prices[]' value="{{$product_variation_value->product_sku->min_selling_price}}"/>
                                                            </td>
                                                                <td>
                                                                <input type="text" class="primary_input_field" name='selling_prices[]' value="{{$product_variation_value->product_sku->selling_price}}"/>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="old_image[]" value="{{$product_variation_value->image_source}}">
                                                                <div class="primary_file_uploader">
                                                                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg" for="document_file_{{$i}}">Browse</label>
                                                                        <input type="file" class="d-none" name="variation_file[]" id="document_file_{{$i}}">
                                                                    </button>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    <input type="hidden" name="doc_id" id="doc_id" value="{{ $i - 1 }}">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add_items_button pt-10" style="@if($product->product_type !="Variable") display: none; @endif">
                                        <button type="button" class="primary-btn radius_30px add_variant_row  fix-gr-bg"><i class="ti-plus"></i>{{__("common.Add Variation")}}
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="submit_btn text-center ">
                                    <button class="primary-btn semi_large2 fix-gr-bg"><i
                                            class="ti-check"></i> {{__("common.Update")}}
                                    </button>
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
         var baseUrl = $('#app_base_url').val();

            $(document).ready(function(){
                $('.summernote').summernote({
                    height: 200,
                    tooltip: false
                    });
                    makeDisable();
            });

            function makeDisable(){
                var productType = $('.product_type').val();
                if (productType == "Variable" || productType == "Single")
                    $("#other_currency_price").show();
                else
                    $("#other_currency_price").hide();

                if (productType === "Variable") {
                    $(".choose_variant").show();
                    $("#product_sku").attr('disabled', true);
                    $("#stock_quantity").attr('disabled', true);
                    $("#alert_quantity").attr('disabled', true);
                    $("#purchase_price").attr('disabled', true);
                    $("#selling_price").attr('disabled', true);
                } else {
                    $(".choose_variant").hide();
                    $("#product_sku").removeAttr("disabled");
                    $("#stock_quantity").removeAttr("disabled");
                    $("#alert_quantity").removeAttr("disabled");
                    $("#purchase_price").removeAttr("disabled");
                    $("#selling_price").removeAttr("disabled");
                }
            }

            $(document).ready(function () {
                var i = $('#doc_id').val();
                $(".selected_variant").unbind().change(function () {
                    $(".add_items_button").show();
                    let variant = $(this).val();
                    var head = "<tr>";
                    var row_list = "";

                    $.each(variant, function (key, value) {
                        $.ajax({
                            url: "{{url('/')}}"+"/product/variant_with_values/" + value,
                            type: "GET",
                            async: false,
                            success: function (response) {
                                head += "<th scope=\"col\">" + response.name + "</th>";
                                row_list += "<td>";
                                row_list += `<input name='variation_type[]'  hidden value="${response.id}">`;
                                row_list += "<select class='primary_select mb-15' name='variation_value_id[]'>";
                                $.each(response.values, function (i_key, i_value) {
                                    row_list += `<option value="${i_value.id}">${i_value.value}</option>`;
                                });
                                row_list += "</select>";
                                row_list += "</td>";
                            }
                        });
                    });
                    head += `<th scope="col">SKU</th>
                            <th scope="col">Alert Qty</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Min. Selling Price</th>
                            <th scope="col">Selling Price</th>
                            <th scope="col">Product Images</th>`;
                    head += "</tr>";
                    row_list += `<td>
                                    <input name='variation_sku[]' type="text" class="primary_input_field"/>
                                 </td>
                                 <td>
                                    <input type="number"  step="1" class="primary_input_field" name='alert_quantities[]'/>
                                 </td>
                                 <td>
                                    <input type="number"  step="0.01" class="primary_input_field" name='purchase_prices[]'/>
                                 </td>
                                    <td>
                                    <input type="number"  step="0.01" class="primary_input_field" name='min_selling_prices[]'/>
                                 </td>
                                 <td>
                                    <input type="number" min="0" step="0.01" class="primary_input_field" name='selling_prices[]'/>
                                 </td>

                                 <td><input type="hidden" name="old_image[]">

                                    <div class="primary_file_uploader">
                                       <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                                       <button class="" type="button">
                                       <label class="primary-btn small fix-gr-bg" for="document_file_2">Browse</label>
                                       <input type="file" class="d-none" name="variation_file[]" id="document_file_2">
                                       </button>
                                    </div>
                                 </td>`;
                    $("#variant_section_head").html(head);
                    $(".variant_row_lists").html(row_list);
                    $('select').niceSelect();
                });


                $(".product_type").unbind().change(function () {
                    let type = $(this).val();
                    if (type == "Variable" || type == "Single")
                        $("#other_currency_price").show();
                    else
                        $("#other_currency_price").hide();

                    if (type === "Variable") {
                        $(".choose_variant").show();
                        $("#product_sku").attr('disabled', true);
                        $("#stock_quantity").attr('disabled', true);
                        $("#alert_quantity").attr('disabled', true);
                        $("#purchase_price").attr('disabled', true);
                        $("#selling_price").attr('disabled', true);
                    } else {
                        $(".choose_variant").hide();
                        $("#product_sku").removeAttr("disabled");
                        $("#stock_quantity").removeAttr("disabled");
                        $("#alert_quantity").removeAttr("disabled");
                        $("#purchase_price").removeAttr("disabled");
                        $("#selling_price").removeAttr("disabled");
                        $("#other_currency_price").hide();
                    }
                });

                $(".note-codable").attr("name", "description");
                $(document).on('click', '.remove_variant_row', function () {
                    $(this).parents('.variant_row_lists').fadeOut();
                    $(this).parents('.variant_row_lists').remove();
                });
                //variationList();
                $(document).on("click", '.add_variant_row', function () {
                    i++;
                    let variant = $(".selected_variant").val();
                    var row_list = "";
                    row_list += "<tr class='variant_row_lists'>";
                    $.each(variant, function (key, value) {
                        $.ajax({
                            url: "{{url('/')}}"+"/product/variant_with_values/" + value,
                            type: "GET",
                            async: false,
                            success: function (response) {
                                row_list += "<td>";
                                row_list += `<input name='variation_type[]' hidden value="${response.id}">`;
                                row_list += "<select class='primary_select mb-15' name='variation_value_id[]'>";
                                $.each(response.values, function (i_key, i_value) {
                                    row_list += `<option value="${i_value.id}">${i_value.value}</option>`;
                                });
                                row_list += "</select>";
                                row_list += "</td>";
                            }
                        });
                    });

                    row_list += '<td>'+
                                     '<input name="variation_sku[]" type="text" class="primary_input_field"/>'+
                                   '</td>'+
                                    '<td>'+
                                        '<input type="number"  step="1" class="primary_input_field" name="alert_quantities[]"/>'+
                                    '</td>'+
                                     '<td>'+
                                         '<input type="number"  step="0.01" class="primary_input_field" name="purchase_prices[]"/>'+
                                     '</td>'+
                                     '<td>'+
                                         '<input type="number"  step="0.01" class="primary_input_field" name="min_selling_prices[]"/>'+
                                     '</td>'+
                                        '<td>'+
                                         '<input type="number" min="0" step="0.01" class="primary_input_field" name="selling_prices[]"/>'+
                                     '</td>'+
                                    '<td>'+'<input type="hidden" name="old_image[]">'+
                                        '<div class="primary_file_uploader">'+
                                            '<input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">'+
                                            '<button class="" type="button">'+
                                                '<label class="primary-btn small fix-gr-bg" for="document_file_'+i+'">Browse</label>'+
                                                '<input type="file" class="d-none" name="variation_file[]" id="document_file_'+i+'">'+
                                            '</button>'+
                                        '</div>'+
                                    '</td>'+
                                     '<td class="pl-0 pb-0 pr-0 remove_variant_row" style="border:0">'+
                                       '<a href="javascript:void(0)" class="primary-btn primary-circle fix-gr-bg">' +
                        '<i class="ti-trash"></i></a>'+
                                     '</td>';
                    row_list += "<tr>";

                    $(".variant_row_lists:last").after(row_list);
                    $('select').niceSelect();
                });

                $(".manage_stock").click(function () {
                    $("#alert_quantity").toggle();
                });
                $("#sub_category_list").addClass("primary_select");
                $(".category").unbind().change(function () {
                    let category = $(this).val();
                    $.ajax({
                        url: baseUrl + "/product/category_wise_subcategory/" + category,
                        type: "GET",
                        success: function (response) {
                            $("#sub_category_list").addClass("primary_select");
                            $.each(response, function (key, item) {
                                $("#sub_category_list").append(`<option value="${item.id}">${item.name}</option>`);
                            });
                        },
                        error: function (error) {
                            console.log(error)
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
