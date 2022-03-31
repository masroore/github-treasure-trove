<div class="form-group">
    <label class="control-label" for="product_id">{{ $option->name }}</label>
    <input type="text" id="[input][{{$productOption->id}}]" class="form-control {{ $productId }}" name="option[{{ $productId }}][input][{{$productOption->id}}]" placeholder="{{$option->name}}" 
    {{ ($option->required)? '':'' }}>
</div>