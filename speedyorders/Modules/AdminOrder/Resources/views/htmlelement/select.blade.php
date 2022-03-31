<div class="form-group">
    <label> Select {{ $option->name }}</label>
    <select data-option="{{ $option->name }}" id="[select][{{$productOption->id}}]" name="option[{{ $productId }}][select][{{ $productOption->id }}]" class="form-control {{ $productId }}" required>
        @foreach ($productOption->optionValues as $ov)
        <option value="{{ $ov->id }}">{{ $ov->optionValue->name }}</option>           
        @endforeach
    </select>
</div>
