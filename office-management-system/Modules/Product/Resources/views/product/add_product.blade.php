@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__("common.Add New Product")}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("add_product.store")}}" method="POST" enctype="multipart/form-data" id="content_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.Product Type')}} *</label>
                                            <select class="primary_select mb-15 product_type" name="product_type" data-parsley-errors-container="#product_type_error_container" id="product_type">
                                                <option value="Single">{{__('product.Single')}}</option>
                                                <option value="Variable">{{__('product.Variant')}}</option>
                                                <option value="Combo">{{__('product.Combo')}}</option>
                                                <option value="Service">{{__('product.Service')}}</option>
                                            </select>
                                            <span id="product_type_error_container" ></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="product_name"> {{__("common.Product Name")}} *</label>
                                            <input class="primary_input_field" name="product_name" placeholder="{{__("common.Product Name")}}" type="text" value="{{old('product_name')}}" required id="product_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="product_sku_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="product_sku">{{__("common.Product SKU")}}</label>
                                            <input type="text" name="product_sku" id="product_sku" class="primary_input_field" value="{{old('product_sku')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none" id="product_origin_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="origin">{{__("common.Part Number")}}</label>
                                            <input type="text" name="origin" id="origin" class="primary_input_field" value="{{old('origin')}}">
                                            <span class="text-danger">{{$errors->first('origin')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="unit_type_div">
                                        <div class="primary_input mb-15">
                                            <div class="double_label d-flex justify-content-between">
                                                <label class="primary_input_label" for="">{{__("common.Unit")}}</label>
                                                <label class="primary_input_label green_input_label" for="">
                                                    <a href="#" data-toggle="modal" data-target="#new_unit">{{__('product.New Unit')}}<i class="fas fa-plus-circle"></i></a></label>
                                            </div>


                                            <select name="unit_type_id" id="unit_type_id" class="primary_select mb-15 unit" >
                                                <option>{{__('product.Select Unit')}}</option>
                                                @foreach($units as $key=>$unit_value)
                                                    <option value="{{$unit_value->id}}">{{$unit_value->name}}
                                                        {{$unit_value->description}}(s)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('unit_type_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="barcode_type_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.Barcode Type')}}</label>
                                            <select name="barcode_type" id="unit_type_id" class="primary_select mb-15">
                                                <option value="">{{__('product.Select Barcode')}}</option>
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
                                    <div class="col-lg-4" id="brand_div">
                                        <div class="primary_input mb-15">
                                            <div class="double_label d-flex justify-content-between">
                                                <label class="primary_input_label" for="">{{__("common.Brand")}} </label>
                                                <label class="primary_input_label green_input_label" for="">
                                                    <a href="#" data-toggle="modal" data-target="#new_barnd">{{__('product.New Brand')}}<i class="fas fa-plus-circle"></i></a></label>
                                            </div>
                                            <select name="brand_id" id="brand_id" class="primary_select mb-15 brand" >
                                                <option>{{__('product.Select Brand')}}</option>
                                                @foreach($brands as $key=>$brand_value)
                                                    <option value="{{$brand_value->id}}">{{$brand_value->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('brand_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="category_div">
                                        <div class="primary_input mb-15">
                                            <div class="double_label d-flex justify-content-between">
                                                <label class="primary_input_label" for="">{{__("common.Category")}} </label>
                                                <label class="primary_input_label green_input_label" for="">
                                                    <a href="#" data-toggle="modal" data-target="#Item_Details">{{__('product.New Category')}}<i class="fas fa-plus-circle"></i></a></label>
                                            </div>
                                            <select name="category_id" id="category_id" class="primary_select mb-15 category">
                                                <option value="">{{__('product.Select Category')}}</option>
                                                @foreach($categories as $key=>$category_value)
                                                    <option value="{{$category_value->id}}">{{$category_value->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('category_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="sub_category_div">
                                        <div class="primary_input mb-15">

                                            <div class="double_label d-flex justify-content-between">
                                                <label class="primary_input_label" for="">{{__("common.Sub Category")}} </label>
                                                <label class="primary_input_label green_input_label" for="">
                                                    <a href="#" data-toggle="modal" data-target="#new_sub_cat">{{__('product.New Sub Category')}}<i class="fas fa-plus-circle"></i></a></label>
                                            </div>
                                            <select class="primary_select mb-15 sub_category" id="sub_category_list" name="sub_category_id" >
                                                <option>{{__('product.Select Sub Category')}}</option>
                                                @foreach($sub_categories as $key=>$sub_category_value)
                                                    <option value="{{$sub_category_value->id}}">{{$sub_category_value->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('sub_category_id')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" id="model_div">
                                        <div class="primary_input mb-15">
                                            <div class="double_label d-flex justify-content-between">
                                                <label class="primary_input_label" for="">{{__('product.Model')}}</label>
                                                <label class="primary_input_label green_input_label" for="">
                                                    <a href="#" data-toggle="modal" data-target="#new_model">{{__('product.New Model')}}<i class="fas fa-plus-circle"></i></a></label>
                                            </div>
                                            <select class="primary_select mb-15 model" id="model_id" name="model_id" >
                                                <option>{{__('product.Select Model')}}</option>
                                                @foreach($models as $key=>$model_value)
                                                    <option value="{{$model_value->id}}">{{$model_value->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('model_id')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" id="select_product">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="selected_product_id">{{__('product.Select Product')}}</label>
                                            <select class="primary_select mb-15" id="selected_product_id" name="selected_product_id[]" multiple data-parsley-errors-container="#selected_product_id_error_container">
                                                @foreach($productSkus as $key => $productSku)
                                                    <option value="{{$productSku->id}}">{{$productSku->product->product_name}} - {{ $productSku->sku }}</option>
                                                @endforeach
                                            </select>
                                            <span id="selected_product_id_error_container" ></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" id="alert_quantity_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Alert Quantity")}} </label>
                                            <div class="">
                                                <input type="number" min="1" step="0.01" name="alert_quantity" id="alert_quantity" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="product_image_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('product.Product Image')}}</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" name="file" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" id="purchase_price_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Purchase Price")}}</label>
                                            <div class="">
                                                <input type="number" name="purchase_price" id="purchase_price" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="selling_price_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Selling Price")}} *</label>
                                            <div class="">
                                                <input type="number" step="0.01" name="selling_price" required="required" id="selling_price" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="hourly_rate_div" style="display:none;">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Hourly Rate")}} *</label>
                                            <div class="">
                                                <input type="number" step="0.01" name="hourly_rate" id="hourly_rate" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="min_selling_price_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Min. Selling Price")}} </label>
                                            <div class="">
                                                <input type="number" name="min_selling_price" id="min_selling_price" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="combo_sell_Price_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Combo Selling Price")}}  </label>
                                            <div class="">
                                                <input type="number" step="0.01" name="combo_selling_price" id="combo_selling_price" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="other_currency_price">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Price of Other Currency")}}  </label>
                                            <div class="">
                                                <input type="text" name="price_of_other_currency" id="price_of_other_currency" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3" id="tax_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__("common.Tax")}}</label>
                                            <div class="">
                                                <input type="number" min="0" max="99" name="tax" id="tax" value="0" class="primary_input_field" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1" id="tax_type_div">
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
                                            <textarea class="summernote" name="product_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form">

                                </div>
                                <div class="row">
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
                                </div>
                                <div class="col-lg-12 choose_variant" style="display: none;">
                                    <div class="QA_section2 QA_section_heading_custom check_box_table">
                                        <div class="QA_table mb_15">
                                            <!-- table-responsive -->
                                            <div class="">
                                                <table class="table variant_table" >
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
                                    <div class="add_items_button pt-10" style="display: none">
                                        <button type="button"
                                                class="primary-btn radius_30px add_variant_row  fix-gr-bg"><i
                                                class="ti-plus"></i>{{__("common.Add Variation")}}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg submit"><i class="ti-check"></i>{{__("common.Add Product")}} </button>
                                        <button class="primary-btn semi_large2 fix-gr-bg submitting" disabled style="display: none;"><i class="ti-check"></i>{{__("common.Adding Product")}} </button>
                                    </div>
                                </div>
                            </form>

                            <!-- new Category Model -->
                            <div class="modal fade admin-query" id="Item_Details">
                                <div class="modal-dialog modal_800px modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('common.Add Category') }}</h4>
                                            <button type="button" class="close " data-dismiss="modal">
                                                <i class="ti-close "></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="categoryForm">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                                            <input name="name" class="primary_input_field" placeholder="Category Name" required="1" type="text" >
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Code') }} *</label>
                                                            <input name="code" class="primary_input_field" placeholder="Category Code" type="text">
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                                            <input name="description" class="primary_input_field" placeholder="{{__('product.Put Some Description')}}" type="text">
                                                            <span class="text-danger" id="description_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                                                                        <input name="status" value="1" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.Active')}}</p>
                                                                </li>
                                                                <li>
                                                                    <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="0" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.DeActive')}}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="status_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Add Category') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new categoty Model end -->

                            <!-- new unit modal -->
                            <div class="modal fade admin-query" id="new_unit">
                                <div class="modal-dialog modal_800px modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('common.Add Unit Type') }}</h4>
                                            <button type="button" class="close " data-dismiss="modal">
                                                <i class="ti-close "></i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="unitTypeForm">
                                                <div class="row">

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.Name') }} *</label>
                                                            <input name="name" class="primary_input_field"
                                                                   placeholder="Unit Type Name"
                                                                   type="text" required>
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.Description') }}</label>
                                                            <input name="description" class="primary_input_field"
                                                                   placeholder="{{__('product.Put Some Description')}}" type="text">
                                                            <span class="text-danger" id="description_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.Status') }}</label>
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option"
                                                                           class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="1" class="active" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.Active')}}</p>
                                                                </li>
                                                                <li>
                                                                    <label data-id="color_option"
                                                                           class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="0" class="de_active"
                                                                               type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.DeActive')}}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="status_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                                    id="save_button_parent"><i
                                                                    class="ti-check"></i>{{ __('common.Add') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- new unit modal and -->

                            <!-- new sub Category Model -->
                            <div class="modal fade admin-query" id="new_sub_cat">
                                <div class="modal-dialog modal_800px modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('common.Sub Category') }}</h4>
                                            <button type="button" class="close " data-dismiss="modal">
                                                <i class="ti-close "></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="subcategoryForm">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                                            <input name="name" class="primary_input_field" placeholder="Category Name" type="text" >
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Code') }} *</label>
                                                            <input name="code" class="primary_input_field" placeholder="Category Code" type="text">
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                                            <input name="description" class="primary_input_field" placeholder="{{__('product.Put Some Description')}}" type="text">
                                                            <span class="text-danger" id="description_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                                                                        <input name="status" value="1" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.Active')}}</p>
                                                                </li>
                                                                <li>
                                                                    <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="0" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.DeActive')}}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="status_error"></span>
                                                        </div>
                                                    </div>

                                                    <input name="as_sub_category" value="1" class="as_sub_category d-none"
                                                           type="checkbox" checked>

                                                    <div class="col-xl-12 parent_category">
                                                        <div class="primary_input mb-15">
                                                            <label class="primary_input_label" for="">{{ __('common.Select parent Category') }} </label>
                                                            <select name="parent_id" id="parent_id" class="primary_select mb-15 category" >
                                                                @foreach($categories as $key=>$category_value)
                                                                    <option value="{{$category_value->id}}">{{$category_value->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Add Category') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new new categoty Model end -->

                            <!-- new Model modal -->
                            <div class="modal fade admin-query" id="new_model">
                                <div class="modal-dialog modal_800px modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('product.New Model') }}</h4>
                                            <button type="button" class="close " data-dismiss="modal">
                                                <i class="ti-close "></i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="POST" id="modelTypeForm">
                                                <div class="row">

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Name') }}*</label>
                                                            <input name="name" class="primary_input_field" placeholder="Model Name"
                                                                   type="text" required>
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                                            <input name="description" class="primary_input_field"
                                                                   placeholder="{{__('product.Put Some Description')}}" type="text">
                                                            <span class="text-danger" id="description_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option"
                                                                           class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="1" class="active" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.Active')}}</p>
                                                                </li>
                                                                <li>
                                                                    <label data-id="color_option"
                                                                           class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="0" class="de_active"
                                                                               type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.DeActive')}}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="status_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                                    id="save_button_parent"><i
                                                                    class="ti-check"></i>{{ __('common.Add Model') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- new Model modal and -->

                            <!-- new Brnad modal -->
                            <div class="modal fade admin-query" id="new_barnd">
                                <div class="modal-dialog modal_800px modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('common.Add Brand') }}</h4>
                                            <button type="button" class="close " data-dismiss="modal">
                                                <i class="ti-close "></i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="POST" id="brandForm">
                                                <div class="row">

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                                            <input name="name" class="primary_input_field" placeholder="Brand Name"
                                                                   type="text" required>
                                                            <span class="text-danger" id="name_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                                            <input name="description" class="primary_input_field"
                                                                   placeholder="{{__('product.Put Some Description')}}" type="text">
                                                            <span class="text-danger" id="description_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option"
                                                                           class="primary_checkbox d-flex mr-12 ">
                                                                        <input name="status" value="1" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.Active')}}</p>
                                                                </li>
                                                                <li>
                                                                    <label data-id="color_option"
                                                                           class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" value="0" type="radio">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{__('common.DeActive')}}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="status_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center pt_20">
                                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                                    id="save_button_parent"><i
                                                                    class="ti-check"></i>{{ __('common.Add Brand') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- new Brand modal and -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">
        var variant_table;
        _formValidation();
        var baseUrl = $('#app_base_url').val();
        $(document).ready(function () {
            var i = 2;

            $("#select_product").hide();
            $("#combo_sell_Price_div").hide();
            $("#combo_selling_price").attr('disabled', true);
            $("#select_product").attr('disabled', true);
            $('.summernote').summernote({
                height: 200,
                tooltip: false
            });
            $(".selected_variant").unbind().change(function () {
                $(".add_items_button").show();
                let variant = $(this).val();
                var head = "<tr>";
                var row_list = "";

                $.each(variant, function (key, value) {
                    $.ajax({
                        url: "{{url('/')}}"+ "/product/variant_with_values/" + value,
                        type: "GET",
                        async: false,
                        success: function (response) {
                            head += "<th scope=\"col\">" + response.name + "</th>";
                            row_list += "<td>";
                            row_list += `<input name='variation_type[]'  hidden value="${response.id}">`;
                            row_list += "<select class='primary_select mb-15 variant_select' name='variation_value_id[]'>";
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
                   <th scope="col">{{__('common.Min. Selling Price')}}</th>
                   <th scope="col">Selling Price</th>
                   <th scope="col">Product Images</th>
                   <th>&nbsp;</th>`;
                head += "</tr>";
                row_list += `<td>
                           <input name='variation_sku[]' type="text" class="primary_input_field w_100px" />
                        </td>
                        <td>
                           <input type="number" min="0" step="1" class="primary_input_field w_100px" name='alert_quantities[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field w_100px" name='purchase_prices[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field w_100px" name='min_selling_prices[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field w_100px" name='selling_prices[]'/>
                        </td>
                        <td>
                           <div class="primary_file_uploader w_210px">
                              <input class="primary-input " type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                              <button class="" type="button">
                              <label class="primary-btn small fix-gr-bg" for="document_file_2">Browse</label>
                              <input type="file" class="d-none" name="variation_file[]" id="document_file_2">
                              </button>
                           </div>
                        </td>
                        <td></td>`;
                $("#variant_section_head").html(head);
                $(".variant_row_lists").html(row_list);
                $('select').niceSelect();
                if(typeof (variant_table) != 'undefined'){
                    variant_table.fnDestroy();
                }
                variant_table = startDataTable();

            });

            $(".product_type").unbind().change(function () {
                let type = $(this).val();
                $("#product_image_div").show();
                $("#barcode_type_div").show();
                $('#hourly_rate_div').hide();
                $('#hourly_rate').attr('required', false);
                $('#selling_price').attr('required', true);
                if (type === "Variable") {
                    $(".choose_variant").show();
                    $("#unit_type_div").show();
                    $("#tax_div").show();
                    $("#tax_type_div").show();
                    $("#brand_div").show();
                    $("#category_div").show();
                    $("#model_div").show();
                    $("#sub_category_div").show();
                    $("#product_sku_div").hide();
                    $("#product_origin_div").show();
                    $("#select_product").hide();
                    $("#stock_quantity_div").hide();
                    $("#alert_quantity_div").hide();
                    $("#combo_sell_Price_div").hide();
                    $("#showroom_div").show();
                    $("#combo_sell_Price_div").attr('disabled', true);
                    $("#product_sku").attr('disabled', true);
                    $("#stock_quantity").attr('disabled', true);
                    $("#alert_quantity").attr('disabled', true);
                    $("#purchase_price").attr('disabled', true);
                    $("#selling_price").attr('disabled', true);
                    $('#purchase_price').removeAttr('readonly');
                    $('#selling_price').removeAttr('readonly');
                    $('#purchase_price_div').hide();
                    $('#selling_price_div').hide();
                    $('#min_selling_price_div').hide();
                    $("#other_currency_price").show();
                }
                else if (type === "Combo") {
                    $(".choose_variant").hide();
                    $("#tax_div").hide();
                    $("#showroom_div").hide();
                    $("#tax_type_div").hide();
                    $("#select_product").show();
                    $("#product_sku_div").hide();
                    $("#product_origin_div").hide();
                    $("#product_sku").attr('disabled', true);
                    $("#unit_type_div").hide();
                    $("#brand_div").hide();
                    $("#category_div").hide();
                    $("#sub_category_div").hide();
                    $("#model_div").hide();
                    $("#stock_quantity_div").hide();
                    $("#alert_quantity_div").hide();
                    $("#combo_sell_Price_div").hide();
                    $("#combo_sell_Price_div").show();
                    $("#other_currency_price").hide();
                    $("#combo_sell_Price_div").removeAttr("disabled");
                    $('#purchase_price').attr('readonly', true);
                    $('#selling_price').attr('readonly', true);
                    $('#purchase_price_div').show();
                    $('#min_selling_price_div').show();
                    $('#selling_price_div').show();
                    $("#purchase_price").removeAttr("disabled");
                    $("#selling_price").removeAttr("disabled");
                    $("#stock_quantity").attr('disabled', true);
                    $("#combo_selling_price").removeAttr("disabled");
                    $("#alert_quantity").attr('disabled', true);
                } else if(type === "Service"){
                    $(".choose_variant").hide();
                    $('#hourly_rate').attr('required', true);
                    $("#tax_div").hide();
                    $("#showroom_div").hide();
                    $("#tax_type_div").hide();
                    $("#select_product").hide();
                    $("#product_sku_div").hide();
                    $("#product_origin_div").hide();
                    $("#product_sku").attr('disabled', true);
                    $("#unit_type_div").hide();
                    $("#brand_div").hide();
                    $("#category_div").hide();
                    $("#sub_category_div").hide();
                    $("#model_div").hide();
                    $("#stock_quantity_div").hide();
                    $("#alert_quantity_div").hide();
                    $("#combo_sell_Price_div").hide();
                    $("#other_currency_price").hide();
                    $('#selling_price').attr('readonly', false);
                    $('#purchase_price_div').hide();
                    $('#min_selling_price_div').hide();
                    $('#hourly_rate_div').show();
                    $('#selling_price').attr('required', false);
                    $('#selling_price_div').hide();
                    $("#product_image_div").hide();
                    $("#barcode_type_div").hide();
                    $("#barcode_type_div").hide();
                } else {
                    $("#showroom_div").show();
                    $(".choose_variant").hide();
                    $("#select_product").hide();
                    $("#tax_div").show();
                    $("#tax_type_div").show();
                    $("#unit_type_div").show();
                    $("#model_div").show();
                    $("#brand_div").show();
                    $("#category_div").show();
                    $("#sub_category_div").show();
                    $("#product_sku_div").show();
                    $("#product_origin_div").show();
                    $('#purchase_price_div').show();
                    $('#selling_price_div').show();
                    $("#stock_quantity_div").show();
                    $("#alert_quantity_div").show();
                    $("#product_sku").removeAttr("disabled");
                    $("#stock_quantity").removeAttr("disabled");
                    $("#alert_quantity").removeAttr("disabled");
                    $("#purchase_price").removeAttr("disabled");
                    $("#selling_price").removeAttr("disabled");
                    $('#purchase_price').removeAttr('readonly');
                    $('#selling_price').removeAttr('readonly');
                    $("#combo_sell_Price_div").hide();
                    $("#combo_sell_Price_div").attr('disabled', true);
                    $("#other_currency_price").show();
                }
            });

            $(".as_sub_category").unbind().click(function () {
                $(".parent_category").toggle();
            });


            function getCategory(){
                $.ajax({
                    url: "{{route("category.all")}}",
                    type: "GET",
                    success: function (response) {

                        $.each(response, function (key, item) {
                            $(".category").append(`<option value="${item.id}">${item.name}</option>`);
                        });
                        $('select').niceSelect('update');
                    },
                    error: function (error) {
                        console.log(error)
                    }

                });
            }

            $("#categoryForm").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("category.store")}}",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#Item_Details").modal("hide");
                        $("#categoryForm").trigger("reset");
                        $(".parent_category").hide();
                        $('.category').html('')

                        getCategory();
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

            $(".note-codable").attr("name", "description");
            $(document).on('click', '.remove_variant_row', function () {
                variant_table.fnDestroy();
                $(this).parents('.variant_row_lists').fadeOut();
                $(this).parents('.variant_row_lists').remove();
                variant_table = startDataTable();
            });


            $(document).on("click", '.add_variant_row', function () {
                variant_table.fnDestroy();
                let variant = $(".selected_variant").val();
                var row_list = "";
                i++;
                row_list += "<tr class='variant_row_lists'>";
                $.each(variant, function (key, value) {
                    $.ajax({
                        url: baseUrl + "/product/variant_with_values/" + value,
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
                    '<input type="number" min="0" step="1" class="primary_input_field w_100px" name="alert_quantities[]"/>'+
                    '</td>'+
                    '<td>'+
                    '<input type="number" min="0" step="0.01" class="primary_input_field w_100px" name="purchase_prices[]"/>'+
                    '</td>'+
                    '<td>'+
                    '<input type="number" min="0" step="0.01" class="primary_input_field w_100px" name="min_selling_prices[]"/>'+
                    '</td>'+
                    '<td>'+
                    '<input type="number" min="0" step="0.01" class="primary_input_field w_100px" name="selling_prices[]"/>'+
                    '</td>'+
                    '<td>'+
                    '<div class="primary_file_uploader w_210px">'+
                    '<input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">'+
                    '<button class="" type="button">'+
                    '<label class="primary-btn small fix-gr-bg" for="document_file_'+i+'">Browse</label>'+
                    '<input type="file" class="d-none" name="variation_file[]" id="document_file_'+i+'">'+
                    '</button>'+
                    '</div>'+
                    '</td>'+
                    '<td class="pl-0 pb-0 pr-0 remove_variant_row" style="border:0">'+
                    '<a class="primary-btn primary-circle fix-gr-bg mr-2" href="javascript:void(0)"> <i class="ti-trash"></i></a>' +
                    '</div>'+
                    '</td>';
                row_list += "</tr>";

                $(".variant_row_lists:last").after(row_list);
                $('select').niceSelect();
               variant_table = startDataTable();
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

            $("#selected_product_id").unbind().change(function () {
                var i = 0;
                let sku_id = $(this).val();
                var purchase_price = $("#purchase_price").val();
                var selling_price = $("#selling_price").val();
                $.post('{{ route('product_sku.get_product_price') }}', {_token:'{{ csrf_token() }}', sku_id:sku_id, purchase_price:purchase_price, selling_price:selling_price}, function(data){

                    $.each(data.name, function(index, value){
                        $('.row_id_'+index).remove();
                        $( ".form" ).append('<div class="col-lg-4 row_id_'+index+'">'+
                            '<div class="primary_input mb-15">'+
                            '<div class="primary_input mb-15">'+
                            '<input class="primary_input_field" readonly id="selected_product_name_'+index+'" placeholder="Name" type="text" value="'+value.sku+'">'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="col-lg-4 row_id_'+index+'">'+
                            '<div class="primary_input mb-15">'+
                            '<input class="primary_input_field" name="selected_product_qty[]" placeholder="Quantity" type="number" min="0" onkeyup="calculatePrice()" step="1" value="1">'+
                            '</div>'+
                            '</div>'+
                            '<div class="col-lg-3 row_id_'+index+'">'+
                            '<div class="primary_input mb-15">'+
                            '<input class="primary_input_field" name="selected_product_price[]" placeholder="Price" type="number" min="0" step="0.01" value="'+value.selling_price+'">'+
                            '</div>'+
                            '</div>'+
                            '<div class="col-lg-1 row_id_'+index+'">'+
                            '<div class="primary_input mb-15">'+
                            '<input class="primary_input_field" name="selected_product_tax[]" placeholder="Quantity" type="number" min="0" step="0.01" value="'+value.tax+'">'+
                            '</div>'+
                            '</div>'+
                            '</div>' );
                    });
                    $("#purchase_price").val(data.newpurchasePrice);
                    $("#selling_price").val(data.newsellPrice);
                });

               variant_table = startDataTable();
                $('select').niceSelect();
            });

        });
        function calculatePrice(){
            var qtys = $("input[name='selected_product_qty[]']").map(function(){return $(this).val();}).get();
            var prices = $("input[name='selected_product_price[]']").map(function(){return $(this).val();}).get();
            var tax = $("input[name='selected_product_tax[]']").map(function(){return $(this).val();}).get();
            var sum = 0;
            for (var i = 0; i < qtys.length; i++) {
                sum = parseInt(sum) + parseInt(qtys[i]) * (parseInt(prices[i]) + (parseInt(prices[i]) * parseInt(tax[i]) / 100));
            }
            $('#selling_price').val(sum);
        }


        function getUnit()
        {
            $.ajax({
                url: "{{route("unit.all")}}",
                type: "GET",
                success: function (response) {

                    console.log(response)

                    $.each(response, function (key, item) {
                        $(".unit").append(`<option value="${item.id}">${item.name}(${item.description})</option>`);
                    });
                    $('select').niceSelect('update');
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }


        $("#unitTypeForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("unit_type.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#new_unit").modal("hide");
                    $("#unitTypeForm").trigger("reset");
                    $('.unit').html('')
                    getUnit();
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


        function getSubCategory(){
            $.ajax({
                url: "{{route("sub_category.all")}}",
                type: "GET",
                success: function (response) {

                    console.log(response)

                    $.each(response, function (key, item) {
                        $(".sub_category").append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $('select').niceSelect('update');
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }



        $("#subcategoryForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("category.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#new_sub_cat").modal("hide");
                    $("#categoryForm").trigger("reset");
                    $(".parent_category").hide();
                    $('.sub_category').html('')

                    getSubCategory();

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


        function getModel(){
            $.ajax({
                url: "{{route("model.all")}}",
                type: "GET",
                success: function (response) {

                    console.log(response)

                    $.each(response, function (key, item) {
                        $(".model").append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $('select').niceSelect('update');
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }


        $("#modelTypeForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("model.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#new_model").modal("hide");
                    $("#modelTypeForm").trigger("reset");
                    $('.model').html('')
                    getModel();
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


        function getBrand(){
            $.ajax({
                url: "{{route("brand.all")}}",
                type: "GET",
                success: function (response) {

                    console.log(response)

                    $.each(response, function (key, item) {
                        $(".brand").append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $('select').niceSelect('update');
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }


        $("#brandForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("brand.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#new_barnd").modal("hide");
                    $("#brandForm").trigger("reset");
                    $('.brand').html('')
                    getBrand();
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
        function startDataTable(){

           return  $('.variant_table').dataTable({
                bLengthChange: false,
               retrieve: true,
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });
        }
    </script>
@endpush
