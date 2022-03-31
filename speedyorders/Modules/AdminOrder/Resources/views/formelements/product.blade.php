@include('adminorder::formelements.add-product-modal')
<a href="javascript:void(0);" id="openProductModal"
            class="btn btn-primary">
            <i class="fa fa-plus"></i>
        </a>
        <input type="hidden" name="deletedProductId" id="deletedProductId" value="">

        @if(old('product_id') || ( isset($order) && $order->products->count() > 0))
            <?php $display = false ?>
        @else
            <?php $display = true ?>
        @endif

        <div id="product_table" class="form-group {{ ($display) ? 'hidden':'' }}">
            <h4>Products</h4>
            <table id="option-values-table"
                class="footable table table-stripped table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
                data-page-size="8" data-filter="#filter">
                <thead>
                    <tr>
                        <th class="footable-visible"><span>Name</span></th>
                        <th class="footable-visible footable-sortable"><span>Quantity</span></th>
                        <th class="footable-visible"><span>Variant Value</span></th>
                        <th class="footable-sortable"><span>Action</span></th>
                    </tr>
                </thead>
                <tbody>
          
                    @if(old('product_id')!=null)
                    @foreach(old('product_id') as $key => $productId)
                           @php
                               $oldRow ='';
                           @endphp 
                            
                            @if(isset(old('option')[$key])){
                                @foreach (old('option')[$key] as $optionType=>$options)
                                
                                    @foreach ($options as $optionId => $optionValue)
                                            @php
                                            $productOption = App\Models\ProductOption::where('id', $optionId)->with('option')->first();
                                            $productOptionValue = App\Models\ProductOptionValue::where('id', $optionValue)->first();
                                            if(isset($productOptionValue->option)){
                                                if(isset($productOption->option)){
                                                 $oldRow .= 'option['.$productId.']['.$productOption->option->type.']['.$optionId.']['.$optionValue.']' ;
                                                }
                                            }
                                                
                                            @endphp
                                            
                                          
                                    @endforeach
                                @endforeach
                            @endif
                           
                        <tr style='display: table-row;' class='footable-even' id='{{$oldRow}}'>

                            <td class='footable-visible footable-first-column'>
                                 <input type='hidden' name='product_id[]' value="{{$productId}}">
                                @foreach ($products as $row=>$product)
                                    @if($productId == $product->id )
                                        {{ $product->name.'('.$product->sku.')' }}
                                    @endif
                                @endforeach 
                            </td>

                            <td class='footable-visible'>
                                <input type='text' name='product_quantity[]' value="{{old('product_quantity')[$key]}}">
                            </td>

                            <td>
                                @if (old('option') && isset(old('option')[$key]))
                                    @foreach (old('option')[$key] as $optionType=>$options)
                                       
                                            @foreach ($options as $optionId => $optionValue)
                                                @php
                                                    $productOption = App\Models\ProductOption::where('id', $optionId)->with('option')->first();
                                                    $value = App\Models\ProductOptionValue::where('id', $optionValue)->first();
                                                    if($value){
                                                        $productOptionValue  = $value;
                                                    }
                                                    else{
                                                        $productOptionValue = $optionValue;
                                                    }
                                               @endphp
                                                <p>{{(isset($productOption->option) && $productOption->option->name)}} : {{$productOptionValue->optionValue->name ?? $productOptionValue}} </p>
                                            @endforeach
                                            
                                                                             
                                    @endforeach
                                @endif
                            </td>

                            <td class='footable-visible footable-last-column'>
                                <button type='button' class='btn btn-danger dlt-product'><i class='fa fa-trash'></i></button>
                            </td>
                            
                          
                            <td class="hidden">
                                @if (old('option') && isset(old('option')[$key]))
                                    @foreach (old('option')[$key] as $optionType=>$options)
                                       
                                            @foreach ($options as $optionId => $optionValue)
                                            <input type="text" data-id="[{{$optionType}}][{{$optionId}}]" class="hiddenInput"  name="option[{{ $key }}][{{$optionType}}][{{$optionId}}]" value="{{$optionValue}}">
                                                      
                                            @endforeach
                                            
                                                                            
                                    @endforeach
                                @endif
                            </td>

                     </tr>

                    @endforeach
                    @else
                    @foreach($order->orderedProducts ??[] as  $key=>$orderProduct)
                    
                    @php
                           $rowId = '';
                         
                           if(count($orderProduct->orderProductOptions)>0){
                               foreach($orderProduct->orderProductOptions ??[] as $orderProductOption)
                                {
                                    $value = "";
                                    if(isset($orderProductOption->productOption) && !empty($orderProductOption->productOption) && isset($orderProductOption->productOption->option)){

                                        if(isset($orderProductOption->productOption->id)){
                                            $value =($orderProductOption->productOption->option->type == "select" && isset($orderProductOption->productOptionValue->id))?$orderProductOption->productOptionValue->id:$orderProductOption->value;

                                        
                                            $rowId.='option['.$orderProduct->product_id.']['.$orderProductOption->productOption->option->type.']['.$orderProductOption->productOption->id.']['.$value.']' ;
                                        }
                                    }
                                }
                        }
                        else{
                            $rowId = $orderProduct->product_id;
                        }
                    @endphp                     
                    <tr style='display: table-row;' class='footable-even' id="{{$rowId}}">
                        <td class='footable-visible footable-first-column'>
                            <input type="hidden" name="product_id[]" value="{{ $orderProduct->product_id }}">
                            {{ $orderProduct->product->name }}
                        </td>
                        <td class='footable-visible'>
                            <input type="text" name="product_quantity[]" value="{{ $orderProduct->quantity }}">
                        </td>
                        <td>
                           @if(isset($orderProduct->orderProductOptions) && !empty($orderProduct->orderProductOptions))
                                @foreach($orderProduct->orderProductOptions ??[] as $orderProductOption)

                                    @if(isset($orderProductOption->productOption) && !empty($orderProductOption->productOption))
                                        <p>{{$orderProductOption->productOption->option->name}} :{{($orderProductOption->productOption->option->type == "select" && isset($orderProductOption->productOptionValue->optionValue->name))?$orderProductOption->productOptionValue->optionValue->name:$orderProductOption->value}}  </p>
                                    @endif    
                               
                                 @endforeach
                           @endif  
                        </td>
                        <td class='footable-visible footable-last-column'>
                            <button type='button' class='btn btn-danger dlt-product'><i class='fa fa-trash'></i></button>
                        </td>
                        <td class="hidden">
                            @foreach($orderProduct->orderProductOptions ??[] as $orderProductOption)
                                @if(isset($orderProductOption->productOption) && !empty($orderProductOption->productOption) && isset($orderProductOption->productOption->id))
                                    <input type="text" data-id="[{{$orderProductOption->productOption->option->type}}][{{$orderProductOption->productOption->id}}]" class="hiddenInput"  name="option[{{ $key }}][{{$orderProductOption->productOption->option->type}}][{{$orderProductOption->productOption->id}}]" value="{{($orderProductOption->productOption->option->type == "select" && isset($orderProductOption->productOptionValue->id)) ? $orderProductOption->productOptionValue->id:$orderProductOption->value}}">
                                @endif    
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>