<div class="form-group">
    <select data-option="DeliveryTime" name="{{$selectname}}" class="form-control {{ $productId }}" required>
        @foreach ($productPackage as $ov)
            @if(in_array($ov->id, $product_packages_array))
                <option value="{{ $ov->id }}">{{ $ov->package_name }}</option> 
            @endif          
        @endforeach
    </select>
</div>
