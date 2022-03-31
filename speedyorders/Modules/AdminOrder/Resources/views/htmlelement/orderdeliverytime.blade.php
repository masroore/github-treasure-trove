<div class="form-group">
    <select data-option="DeliveryTime" name="{{$selectnamedeliverytime}}" class="form-control {{ $productId }}" required>
        <option value="">Select Delivery Time</option>
        @foreach ($productDeliveryTimes as $timedetails)
            
           <option {{(($selectedId) && $selectedId==$timedetails->shipping_delivery_times_id) ? 'selected' : ''}} value="{{$timedetails->shipping_delivery_times_id}}">{{ucfirst($timedetails->delivery_time_name->name)}}</option>
            
        @endforeach
    </select>
</div>
