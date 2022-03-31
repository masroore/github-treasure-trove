
<div class="col-md-12">
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-5">
                <label for="option">Zone</label>
                <select name="shipping_zone_groups_id" id="shipping_zone_groups_id"  class="form-control js-dropdown-select2">
                    <option value="">Select Zone</option>
                    @foreach ($groups as $group)
                        <option {{(isset($productDeliveryTimeGroup) && $productDeliveryTimeGroup==$group->id) ? 'selected' : ''}} value="{{ $group->id }}">{{ $group->group_name }}</option>
                    @endforeach
                </select>
            </div>   
            <div class="col-md-5">
                <label for="option">Package</label>
                <select name="shipping_packages_id" id="shipping_packages_id"  class="form-control js-dropdown-select2">
                    <option value="">Select Package</option>
                    @foreach ($packages as $package)
                        <option {{(isset($productDeliveryTimePackage) && $productDeliveryTimePackage==$package->id) ? 'selected' : ''}} value="{{ $package->id }}">{{ $package->package_name }}</option>
                    @endforeach
                </select>
            </div>  

            <div class="col-md-2">
                <label for="option " class="rows"></label>
                <button type='button' class='btn btn-info' onclick='showDeliveryTimes()'>Show Delivery Times</button>
             </div>          
        </div>    

    </div>
    <div class="col-md-12">
        <div class="card card-info" id="delivery_times_info">         

        
        </div>
    </div>
</div>

<input type="hidden" name="deliveryTimes" id="deliveryTimes" value="<?php echo (isset($deliveryTimes) && !empty($deliveryTimes)) ? json_encode($deliveryTimes) : '';?>">

<style type="text/css">
    label.rows {
    height: 15px;
}
</style>


<script type="text/javascript">
    
    setTimeout(function(){
        showDeliveryTimes();
    },500);
    
        
    function showDeliveryTimes(){

        var url = '{{ route('admin.products.ajax.package.deliverytime') }}';

        $('#delivery_times_info').empty();
            var zone_data_id = $("#shipping_zone_groups_id").val();
            var package_data_id = $("#shipping_packages_id").val();  
            var deliveryTimes = $("#deliveryTimes").val();        
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "package_id": package_data_id,
                "zone_id" : zone_data_id,
                "deliveryTimes":deliveryTimes
            },
            dataType: 'JSON',
            success: function(data) {
               $('#delivery_times_info').empty().append(data.html);
            }
        });
  }
</script>


      