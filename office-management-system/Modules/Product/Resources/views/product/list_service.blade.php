@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.Services')}}</h3>
                    @if(permissionCheck('add_product.index'))
                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                   href="{{route("add_product.index")}}"><i
                                        class="ti-plus"></i>{{__('product.New Product')}}</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Start Sms Details -->
        <div class="col-lg-12 student-details">

                <div class="white-box mt-2">
                    <div class="row">
                        <div class="col-12 select_sms_services">
                            <div class="QA_section QA_section_heading_custom check_box_table mt-50">
                                <div class="QA_table ">
                                    <table class="table Crm_table_active3">
                                        <thead>
                                        <tr>

                                            <th scope="col">{{__('product.Sl')}}</th>
                                            <th scope="col">{{__('product.Image')}}</th>
                                            <th scope="col">{{__('product.Name')}}</th>
                                            @if (app('general_setting')->origin == 1)
                                                <th scope="col">{{__('common.Part Number')}}</th>
                                            @else
                                                <th scope="col">{{__('sale.SKU')}}</th>
                                            @endif

                                            <th scope="col">{{__('product.Hourly Rate')}}</th>

                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $key => $productSku)
                                            <tr>

                                                <th>{{$key+1}}</th>
                                                <td>
                                                    @if (@$productSku->product->product_type == "Single" && @$productSku->product->image_source != null)
                                                        <img style="height: 36px;"
                                                             src="{{asset(@$productSku->product->image_source ?? 'public/backEnd/img/no_image.png')}}"
                                                             alt="{{@$productSku->product->product_name}}">
                                                    @elseif(@$productSku->product->product_type == "Variable" && @$productSku->product->image_source != null)
                                                        <img style="height: 36px;"
                                                             src="{{asset(@$productSku->product_variation->image_source ?? 'public/backEnd/img/no_image.png')}}"
                                                             alt="{{@$productSku->product->product_name}}">
                                                    @else
                                                        <img style="height: 36px;"
                                                             src="{{asset('public/backEnd/img/no_image.png')}}"
                                                             alt="{{@$productSku->product->product_name}}">
                                                    @endif
                                                </td>
                                                <td><a href="#" data-toggle="modal"
                                                       onclick="product_detail({{ $productSku->product_id }} , 'null')">{{@$productSku->product->product_name}}</a>
                                                </td>
                                                <td>
                                                    @if (app('general_setting')->origin == 1)
                                                        {{$productSku->product->origin}}
                                                    @else
                                                        {{ $productSku->sku }}
                                                    @endif
                                                </td>

                                                @if ($productSku->product->product_type == 'Variable')
                                                    <td>{{single_price($productSku->selling_price)}}</td>
                                                @else
                                                    <td>{{single_price($productSku->selling_price)}}</td>
                                                @endif

                                                <td>
                                                    <!-- shortby  -->

                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle"
                                                                type="button" id="dropdownMenu2"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"> {{__('common.select')}}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">
                                                            @if(permissionCheck('add_product.edit'))
                                                                <a href="{{route('add_product.edit',$productSku->product_id)}}"
                                                                   class="dropdown-item"
                                                                   type="button">{{__('common.Edit')}}</a>


                                                            @endif

                                                            @if(permissionCheck('add_product.index'))
                                                                <a href="#" data-toggle="modal"
                                                                   class="dropdown-item"
                                                                   onclick="product_detail({{ $productSku->product_id }} , 'null')">{{__('common.View')}}</a>
                                                            @endif
                                                            @if(permissionCheck('add_product.destroy') && $productSku->sku_products->count() == 0)
                                                                <a onclick="confirm_modal('{{route('add_product.destroy',$productSku->product_id)}}');"
                                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
                                                </td>
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
    <div class="product_info">

    </div>
    <div class="modal fade admin-query" id="generate_barcode">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('product.Information to show in Labels') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <form action="{{route('print.labels')}}" method="GET">@csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="pl-5">{{__('product.Image')}}</td>
                                <td><img class="product_image" src="" width="50px" alt=""></td>
                            </tr>
                            <tr>
                                <td class="pl-5">{{__('product.Products')}} :</td>
                                <td class="product_name"></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="pl-5">{{__('product.SKU')}} :</td>
                                <td class="product_sku"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="row">
                            <input type="hidden" name="id" class="sku_id" value="">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="primary_input">
                                    <label class="primary_input_label"
                                           for="">{{ __('common.Type') }}</label>
                                    <ul id="theme_nav" class="permission_list sms_list ">
                                        <li>
                                            <label data-id="bg_option"
                                                   class="primary_checkbox d-flex mr-12 ">
                                                <input name="name" id="name" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>Product Name</p>
                                        </li>
                                        <li>
                                            <label data-id="color_option"
                                                   class="primary_checkbox d-flex mr-12">
                                                <input name="variation" id="variation" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>Product Variation (recommended)</p>
                                        </li>
                                        <li>
                                            <label data-id="color_option"
                                                   class="primary_checkbox d-flex mr-12">
                                                <input name="business_name" value="business_name" id="business_name"
                                                       type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>Business name</p>
                                        </li>
                                        <li>
                                            <label
                                                class="primary_checkbox d-flex mr-12">
                                                <input name="product_price" value="price" id="price" type="checkbox"
                                                       checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>Product Price</p>
                                        </li>
                                        <li>
                                            <select class="primary_select mb-15 price_tax" id="tax" name="tax">
                                                <option value="1">Inc. Tax</option>
                                                <option value="0">Ex. Tax</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <label class="primary_input_label" for="">{{__('product.Barcode Setting')}}</label>
                                <select class="primary_select mb-15 per_sheet" name="page">
                                    <option value="20">20 {{__('product.Labels Per Sheet')}}</option>
                                    <option value="30">30 {{__('product.Labels Per Sheet')}}</option>
                                    <option value="32">32 {{__('product.Labels Per Sheet')}}</option>
                                    <option value="40">40 {{__('product.Labels Per Sheet')}}</option>
                                    <option value="50">50 {{__('product.Labels Per Sheet')}}</option>
                                    <option value="0">{{__('product.Continuous Rolls')}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for=""> {{__("product.No. of Label")}} </label>
                                    <input class="primary_input_field no_of_label" name="label"
                                           placeholder="{{__("product.No. of Label")}}" type="number"
                                           value="{{old('label')}}">
                                    <span class="text-danger">{{$errors->first('label')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">

                                <button type="submit"
                                        class="primary-btn semi_large2 mr-2 fix-gr-bg">{{__('product.Preview')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')

@endsection
@push("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('change', '#price', function () {
                if (!$(this).is(':checked'))
                    $('.price_tax').hide();
                else
                    $('.price_tax').show();
            });
            $(document).on('click', '.generate_barcode', function () {
                let id = $(this).data('id');

                $('.id').val(id);
            })


        });

        function product_detail(el, type, range) {
            $.post('{{ route('add_product.product_Detail') }}', {
                _token: '{{ csrf_token() }}',
                id: el,
                type: type,
                range: range,
            }, function (data) {
                $('.product_info').html(data);
                $('#Item_Details').modal('show');
            });
        }

        function update_active_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('combo_product.update_active_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    toastr.success("Successfully Updated", "Success");
                } else {
                    toastr.warning("Something went wrong");
                }
            });
        }

        function barcodeGenerator(image, name, sku, sku_id,stock) {
            if (!stock || isNaN(stock))
                stock = 0;
            $('.product_image').attr("src", image);
            $('.product_name').text(name);
            $('.product_sku').text(sku);
            $('.sku_id').val(sku_id);
            $('.no_of_label').val(parseInt(stock));
        }
    </script>
@endpush
