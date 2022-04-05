@foreach($stocks as $key=> $stock)
    <tr>
        <td>
            <label data-id="bg_option"
                   class="primary_checkbox d-flex mr-12 ">
                <input name="stocks[]" class="product_select" onchange="selectProduct()" data-id="{{$stock->id}}" value="{{$stock->id}}"
                       type="checkbox">
                <span class="checkmark"></span>
            </label>
        </td>
        <td>{{$key+1}}</td>
        <td><img src="{{asset(@$stock->productSku->product->image_source ?? 'backEnd/img/no_image.png')}}" width="50px"
                 alt="{{@$stock->productSku->product->product_name}}"></td>
        <td>{{$supplier}}</td>
        <td>{{@$stock->productSku->product->product_name}}</td>
    </tr>
@endforeach
