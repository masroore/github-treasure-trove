
<div class="hpanel col-md-12" style="margin-top: 10px;">
    <div class="panel-heading">
        <table class="table-responsive table">
            <tr>
                <th>Delivery Time</th>
                <th>Price</th>
            </tr>

             @foreach($zone_prices as $zone_price)
             <tr>
               
                    <td><input <?php echo ($deliverArr && in_array($zone_price->id,$deliverArr)) ? 'checked' : '';?>   type="checkbox" name="delivery_time[]" value="{{$zone_price->id}}">&nbsp;{{ ucfirst($zone_price->name)}} </td>
                    <td>{{ $zone_price->price}} </td>
               </tr>
            @endforeach

            
              
        </table>
        
       
       
    </div>
</div>
