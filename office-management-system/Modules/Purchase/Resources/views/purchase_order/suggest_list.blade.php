@extends('backEnd.master')
@section('mainContent')
    <form action="{{ route('convert.purchase') }}" method="get">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white mb-50 pb-5">
                    <div class="row">
                        <div class="col-3">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('purchase.Purchase Suggest List')}} </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="primary_input mb-15">
                                <select class="primary_select supplier" onchange="supplierProducts()" name="supplier">
                                    <option value="">{{__('purchase.Select Supplier')}}</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-20">
                <ul class="d-flex">
                    <li class="purchase_btn" style="display: none;">
                        <button class="primary-btn radius_30px mb-10 mr-10 fix-gr-bg"
                                type="submit"><i
                                class="ti-plus"></i>{{__('purchase.Purchase Order')}}</button>
                    </li>
                </ul>

                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table class="table Crm_table_active3">
                                <thead>
                                <tr>

                                    <th scope="col">{{__('common.No')}}</th>
                                    <th scope="col">{{__('product.Image')}}</th>
                                    <th scope="col">{{__('common.Supplier')}}</th>
                                    <th scope="col">{{__('product.Products')}}</th>
                                    @if (app('general_setting')->origin == 1)
                                        <th scope="col">{{__('product.Part No.')}}</th>
                                    @endif
                                    <th scope="col">{{__('product.Model')}}</th>
                                    <th scope="col">{{__('product.Brand')}}</th>
                                    <th scope="col">{{__('product.Current QTY')}}</th>
                                    <th scope="col">{{__('product.Alert QTY')}}</th>
                                </tr>
                                </thead>
                                <tbody class="product_list">
                                @foreach($stocks as $key=> $stock)
                                    <tr>

                                        <td>{{$key+1}}</td>
                                        <td><img
                                                src="{{asset(@$stock->productSku->product->image_source ?? 'backEnd/img/no_image.png')}}"
                                                width="50px"
                                                alt="{{@$stock->productSku->product->product_name}}"></td>
                                        <td>{{@$stock->purchase->supplier->name}}</td>
                                        <td>{{@$stock->productSku->product->product_name}}</td>
                                        @if (app('general_setting')->origin == 1)
                                            <td scope="col">{{@$stock->productSku->product->origin}}</td>
                                        @endif
                                        <td>{{@$stock->productSku->product->brand->name}}</td>
                                        <td>{{@$stock->productSku->product->model->name}}</td>
                                        <td>{{@$stock->stock}}</td>
                                        <td>{{@$stock->productSku->alert_quantity}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('backEnd.partials.approve_modal')
@endsection

@push("scripts")
    <script>

        function supplierProducts() {
            let supplier = $('.supplier').val();
            $.ajax({
                url: "{{ route('filter.product.supplier') }}",
                method: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    supplier: supplier
                },
                success: function (data) {
                    $('.product_list').html(data);
                }
            })
        }

        function selectAllProduct() {
            let supplier = $('.supplier').val();

            if ($('.all_product_select').prop('checked') == true) {
                if (supplier)
                    $('.purchase_btn').show();
                $.each($('.product_select'), function () {
                    $(this).prop('checked', true)
                })
            } else {
                $('.purchase_btn').hide();
                $.each($('.product_select'), function () {
                    $(this).prop('checked', false)
                })
            }
        }

        function selectProduct() {
            let supplier = $('.supplier').val();
            if ($('.product_select').prop('checked') == true && supplier) {
                $('.purchase_btn').show();
            } else
                $('.purchase_btn').hide();
        }
    </script>
@endpush
