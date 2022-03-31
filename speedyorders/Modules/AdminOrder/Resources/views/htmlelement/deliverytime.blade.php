<div class="form-group">
    <select data-option="Package" id="[select][{{$productId}}]" name="{{$selectname}}" class="form-control {{ $productId }}" required>
        <option value="">Select Delivery Time</option>
        @foreach ($deliveryTimes as $ov)
        <option value="{{ $ov->id }}">{{ ucfirst($ov->name) }}</option>           
        @endforeach
    </select>
</div>
