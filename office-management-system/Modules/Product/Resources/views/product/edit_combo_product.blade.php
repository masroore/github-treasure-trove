@extends('backEnd.master')
@section('mainContent')
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
                        <form action="{{route("add_product.update",$productCombo->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("Patch")
                            <div class="row">
                                <input type="hidden" name="product_type" value="Combo">
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('product.Product Type')}}</label>
                                        <select class="primary_select mb-15 product_type" name="product_type" disabled>
                                            <option >{{__('product.Single')}} </option>
                                            <option >{{__('product.Variable')}} </option>
                                            <option selected>{{__('product.Combo')}}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('product_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__("common.Product Name")}} </label>
                                        <input class="primary_input_field" name="product_name" placeholder="Product Name" type="text" value="{{$productCombo->name}}">
                                        <span class="text-danger">{{$errors->first('product_name')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('product.Barcode Type')}}</label>
                                        <input type="text" name="barcode_type" class="primary_input_field" value="{{ $productCombo->barcode_type }}">
                                        <span class="text-danger">{{$errors->first('barcode_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="select_product">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__('product.Select Product')}}</label>
                                      <select class="primary_select mb-15" id="selected_product_id" name="selected_product_id[]" multiple disabled>
                                         @foreach($productCombo->combo_products as $key => $p_details)
                                         <option value="{{$p_details->id}}" selected>{{$p_details->productSku->product->product_name}} - {{ $p_details->productSku->sku }}</option>
                                         @endforeach
                                      </select>
                                      <span class="text-danger">{{$errors->first('model_id')}}</span>
                                   </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('product.Product Image')}} </label>
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
                                <div class="col-lg-4">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Purchase Price")}}  </label>
                                      <div class="">
                                         <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ $productCombo->total_purchase_price }}" class="primary_input_field" >
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Selling Price")}}  </label>
                                      <div class="">
                                         <input type="number" step="0.01" name="selling_price" id="selling_price" value="{{ $productCombo->total_regular_price }}" class="primary_input_field" >
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Min. Selling Price")}}  </label>
                                      <div class="">
                                         <input type="number" step="0.01" name="min_selling_price" id="selling_price" value="{{ $productCombo->min_selling_price }}" class="primary_input_field" >
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4" id="combo_sell_Price_div">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("common.Combo Selling Price")}}  </label>
                                      <div class="">
                                         <input type="number" step="0.01" name="combo_selling_price" id="combo_selling_price" value="{{ $productCombo->price }}" class="primary_input_field" >
                                      </div>
                                   </div>
                                </div>
                                <div class="col-lg-4" id="showroom_div">
                                   <div class="primary_input mb-15">
                                      <label class="primary_input_label" for="">{{__("sale.Select Branch or WareHouse")}}</label>
                                      <select name="showroom" id="showroom" class="primary_select mb-15" >
                                         @foreach(\Modules\Inventory\Entities\ShowRoom::where('status', 1)->get() as $key => $showroom)
                                             <option value="{{$showroom->id}}-showroom" @if (session()->get('showroom_id') == $showroom->id) selected @endif>{{$showroom->name}} - ({{ __('inventory.Branch') }})</option>
                                         @endforeach
                                      </select>
                                      <span class="text-danger">{{$errors->first('unit_type_id')}}</span>
                                   </div>
                                </div>
                                <div class="col-xl-12">
                                   <div class="primary_input mb-40">
                                      <label class="primary_input_label" for=""> {{__("common.Description")}} </label>
                                      <textarea class="summernote" name="product_description">{{ $productCombo->description }}</textarea>
                                   </div>
                                </div>
                            </div>
                           <div class="row form">
                               <div class="col-lg-4">
                                   <div class="primary_input mb-15">
                                       <label class="primary_input_label" for="">{{ __('product.Name') }}</label>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('product.QTY') }}</label>
                                   </div>
                               </div>
                               <div class="col-lg-3">
                                   <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('product.Price') }}</label>
                                   </div>
                               </div>
                               <div class="col-lg-1">
                                   <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.Tax') }}</label>
                                   </div>
                               </div>
                               @foreach ($productCombo->combo_products as $key => $p_details)
                                   <div class="col-lg-4 row_id_{{ $key }}">
                                       <div class="primary_input mb-15">
                                           <input type="hidden" name="selected_product_id[]" value="{{ $p_details->product_sku_id }}">
                                           <input class="primary_input_field" readonly placeholder="Product Name" type="text" value="{{$p_details->productSku->product->product_name}} - {{$p_details->productSku->sku}}">
                                           <span class="text-danger">{{$errors->first('product_name')}}</span>
                                       </div>
                                   </div>
                                   <div class="col-lg-4 row_id_{{ $key }}">
                                       <div class="primary_input mb-15">
                                           <input class="primary_input_field" name="selected_product_qty[]" id="selected_product_qty" placeholder="QTY" type="number" min="1" onkeyup="calculatePrice()" value="{{$p_details->product_qty}}">
                                           <span class="text-danger">{{$errors->first('product_name')}}</span>
                                       </div>
                                   </div>
                                   <div class="col-lg-3 row_id_{{ $key }}">
                                       <div class="primary_input mb-15">
                                           <input class="primary_input_field" name="selected_product_price[]" id="selected_product_price" readonly type="number" min="0.01" value="{{$p_details->productSku->selling_price}}">
                                           <span class="text-danger">{{$errors->first('product_name')}}</span>
                                       </div>
                                   </div>
                                   <div class="col-lg-1 row_id_{{ $key }}">
                                       <div class="primary_input mb-15">
                                           <input class="primary_input_field" name="selected_product_tax[]" id="selected_product_tax" readonly type="number" min="0.01" value="{{$p_details->productSku->tax}}">
                                           <span class="text-danger">{{$errors->first('product_name')}}</span>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
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
        </div>
    </section>
    @push("scripts")
        <script type="text/javascript">
            $(document).ready(function(){
                $('.summernote').summernote({
                    height: 200
                    });
            });

            $(document).ready(function () {
                $("#selected_product_id").unbind().change(function () {
                     var i = 0;
                     let sku_id = $(this).val();
                     var purchase_price = $("#purchase_price").val();
                     var selling_price = $("#selling_price").val();
                     $.post('{{ route('product_sku.get_product_price') }}', {_token:'{{ csrf_token() }}', sku_id:sku_id, purchase_price:purchase_price, selling_price:selling_price}, function(data){
                        console.log(data.name);
                        $("#purchase_price").val(data.newpurchasePrice);
                        $("#selling_price").val(data.newsellPrice);
                     });
                     $.each(sku_id, function(index, value){
                         $('.row_id_'+index).remove();
                         $( ".form" ).append('<div class="col-lg-4 row_id_'+index+'">'+
                             '<div class="primary_input mb-15">'+
                                 '<div class="primary_input mb-15">'+
                                     '<input class="primary_input_field" name="selected_product_name[]" id="selected_product_name_'+index+'" placeholder="Name" type="text" value="">'+
                                 '</div>'+
                             '</div>'+
                         '</div>'+
                         '<div class="col-lg-4 row_id_'+index+'">'+
                             '<div class="primary_input mb-15">'+
                                 '<input class="primary_input_field" name="selected_product_qty[]" placeholder="Quantity" type="number" min="0" step="0.01" value="">'+
                             '</div>'+
                         '</div>'+
                         '<div class="col-lg-4 row_id_'+index+'">'+
                             '<div class="primary_input mb-15">'+
                                 '<input class="primary_input_field" name="selected_product_price[]" placeholder="Quantity" type="number" min="0" step="0.01" value="">'+
                             '</div>'+
                         '</div>'+
                         '</div>' );
                     });
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

        </script>
    @endpush
@endsection
