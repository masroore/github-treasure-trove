@extends('backEnd.master')
@section('mainContent')
   <section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
         <div class="row justify-content-center">
            <div class="col-12">
               <div class="box_header">
                  <div class="main-title d-flex">
                     <h3 class="mb-0 mr-30">{{__('common.Add Opening Stock')}}</h3>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="white_box_50px box_shadow_white">
                  <form action="{{route("purchase_order.add_to_stock")}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row">

                         <div class="col-lg-6">
                            <div class="primary_input mb-15">
                               <label class="primary_input_label" for="">{{__('product.Product')}} *</label>
                               <select class="primary_select mb-15" name="product_sku_id" id="product_sku_id" onchange="getProductDetails()">
                                   <option value="">{{ __('common.Select One') }}</option>
                                     @foreach($products as $key => $productSku)
                                         <option value="{{ $productSku->id }}">{{ @$productSku->product->product_name }} @if (variantNameFromSku($productSku)) - ({{ variantNameFromSku($productSku) }}) @endif  @if (app('general_setting')->origin == 1 && $productSku->product->origin) > {{ __('common.Part Number') }} : {{ $productSku->product->origin }} @endif @if (@$productSku->product->brand_name) > {{ __('product.Brand') }} : {{ @$productSku->product->brand_name }} @endif @if (@$productSku->product->model_name) > {{ __('product.Model') }} : {{ @$productSku->product->model_name }} @endif</option>
                                     @endforeach
                               </select>
                               <span class="text-danger">{{$errors->first('product_sku_id')}}</span>
                            </div>
                         </div>

                          <div class="col-lg-6">
                              <div class="primary_input mb-15">
                                  <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                  <div class="primary_datepicker_input">
                                      <div class="no-gutters input-right-icon">
                                          <div class="col">
                                              <div class="">
                                                  <input placeholder="Date"
                                                         class="primary_input_field primary-input date form-control"
                                                         id="startDate" type="text" name="stock_date"
                                                         value="{{date('m/d/Y')}}" autocomplete="off">
                                              </div>
                                          </div>
                                          <button class="" type="button">
                                              <i class="ti-calendar" id="start-date-icon"></i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>


                         <div class="col-lg-6">
                            <div class="primary_input mb-15">
                               <label class="primary_input_label" for="">{{__("common.Stock Quantity")}} *</label>
                               <div class="">
                                  <input type="number" min="0" step="0.01" name="stock_quantity" id="stock_quantity" required="1" class="primary_input_field" >
                               </div>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <div class="primary_input mb-15">
                               <label class="primary_input_label" for="">{{__("sale.Select Branch or WareHouse")}} *</label>
                               <select name="showroom" id="showroom" class="primary_select mb-15" >
                                   @if (Auth::user()->role->type == "system_user")
                                   <option selected disabled>{{__('common.Select')}}</option>
                                   @foreach($wareHouses as $warehouse)
                                       <option value="warehouse-{{$warehouse->id}}">{{$warehouse->name}}</option>
                                   @endforeach
                                   @foreach($showrooms as $showroom)
                                       <option value="showroom-{{$showroom->id}}" {{session()->get('showroom_id') == $showroom->id ? 'selected' : ''}}> {{$showroom->name}}</option>
                                   @endforeach
                                   @else
                                       <option value="showroom-{{ Auth::user()->staff->showroom_id }}" selected > {{showroomName()}}</option>
                                   @endif
                               </select>
                               <span class="text-danger">{{$errors->first('unit_type_id')}}</span>
                            </div>
                         </div>
                     </div>
                     <div class="row details">
                         <div class="col-lg-6">
                            <div class="primary_input mb-15">
                               <label class="primary_input_label" for="">{{__("common.Purchase Price")}} *</label>
                               <div class="">
                                  <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="" class="primary_input_field" >
                               </div>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__("common.Selling Price")}} *</label>
                                <div class="">
                                   <input type="number" min="0" step="0.01" name="selling_price" id="selling_price" value="" class="primary_input_field" >
                                </div>
                            </div>
                         </div>
                     </div>
                     <div class="row d-none">
                         <div class="col-xl-6 col-lg-6 col-md-6">
                             <div class="primary_input mb-25">
                                 <label class="primary_input_label" for="">{{ __('common.Serial No') }} <small>({{ __('common.Manually') }})</small> </label>
                                 <div class="tagInput_field">
                                     <input class="sr-only" type="text" id="serial_no" name="serial_no" data-role="tagsinput" class="sr-only">
                                 </div>
                             </div>
                         </div>
                         <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="primary_input mb-15">
                               <label class="primary_input_label" for="">{{ __('common.Serial No') }} <small>({{ __('common.Automated via excel file') }}) <a href="{{ asset('uploads/sample.xlsx') }}" download>Sample File Download</a> </label>
                               <div class="primary_file_uploader">
                                  <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                                  <button class="" type="button">
                                  <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.Browse")}} </label>
                                  <input type="file" class="d-none" accept=".xlsx, .xls, .csv" name="file" id="document_file_1">
                                  </button>
                               </div>
                            </div>
                         </div>
                     </div>
                     <div class="row">
                          <div class="col-12">
                             <div class="submit_btn text-center ">
                                <button class="primary-btn semi_large2 fix-gr-bg"><i
                                   class="ti-check"></i>{{__("common.Add Product")}}
                                </button>
                             </div>
                          </div>
                       </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0 mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Opening Stock List') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <table class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('sale.Sl')}}</th>
                                <th scope="col">{{__('sale.Date')}}</th>
                                <th scope="col">{{__('common.Name')}}</th>
                                @if (app('general_setting')->origin == 1)
                                    <th scope="col">{{__('common.Part Number')}}</th>
                                @else
                                    <th scope="col">{{__('sale.SKU')}}</th>
                                @endif
                                <th scope="col">{{__('product.Model')}}</th>
                                <th scope="col">{{__('product.Brand')}}</th>
                                <th scope="col">{{__('inventory.Branch')}}</th>
                                <th scope="col">{{__('product.Purchase Price')}}</th>
                                <th scope="col">{{__('product.Selling Price')}}</th>
                                <th scope="col">{{__('product.Stock')}}</th>
                                <th scope="col">{{__('common.Created User')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stockProducts as $key=> $stockProduct)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($stockProduct->date)) }}</td>
                                    <td>{{ @$stockProduct->productSku->product->product_name }}</td>
                                    <td>
                                        @if (app('general_setting')->origin == 1)
                                            {{ @$stockProduct->productSku->product->origin }}
                                        @else
                                            {{ @$stockProduct->productSku->sku }}
                                        @endif
                                    </td>
                                    <td>{{ @$stockProduct->productSku->product->model->name }}</td>
                                    <td>{{ @$stockProduct->productSku->product->brand->name }}</td>
                                    <td>{{ @$stockProduct->itemable->name }}</td>
                                    <td>{{ single_price(@$stockProduct->productSku->purchase_price) }} / <small>{{ @$stockProduct->productSku->product->unit_type->name }}</small> </td>
                                    <td>{{ single_price(@$stockProduct->productSku->selling_price) }} / <small>{{ @$stockProduct->productSku->product->unit_type->name }}</small> </td>
                                    <td>{{ $stockProduct->in_out }}</td>
                                    <td>{{ userName($stockProduct->created_by) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("scripts")
<script type="text/javascript">
    function getProductDetails(){
        var sku_id = $('#product_sku_id').val();
        $.post('{{ route('product-details-for-stock') }}', {_token:'{{ csrf_token() }}', id:sku_id}, function(data){
            $('.details').html(data);
        });
    }
</script>
@endpush
