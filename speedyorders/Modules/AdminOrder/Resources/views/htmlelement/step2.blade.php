<h5>Single</h5>
<br>

<table class="table table-bordered">
  <thead>
     <tr>
        <td style="width:10%"><b>Product ID</b></td>
        <td style="width:20%"><b>Product</b></td>
        <td style="width:10%"><b>Product Price Total</b></td>
        <td style="width:25%"><b>Package</b></td>
        <td style="width:25%"><b>Delivery Time</b></td>
        <td style="width:25%"><b>Shipping Price</b></td>
     </tr>
  </thead>
  <tbody>    
    @if(!empty($singalarr))
        <?php $total_product_price = 0?>
        <?php $total_shipping_price = 0?>

        @foreach($singalarr as $singleproduct)     
             <tr>
                <td>{{ $singleproduct["id"] }}</td>
                <td>{{ $singleproduct["name"] }}</td> 
                <td>${{ $singleproduct["product_price"] }} <?php $total_product_price += $singleproduct["product_price"] ?></td>                                  
                <td>{{ $singleproduct["package"] }}</td>                               
                <td>{{ $singleproduct["deliverytime"] }}</td>                          
                <td>${{ $singleproduct["deliverytimeprice"] }} <?php $total_shipping_price += $singleproduct["deliverytimeprice"]?>
                </td>
             </tr>
        @endforeach

        <tr>
            <th colspan="2">Product Price Total</th>
            <th>${{$total_product_price}}</th>                                  
            <th colspan="2">Shipping Price Total</th>                               
            <th>${{$total_shipping_price}}</th>
         </tr>

         <tr>
            <th colspan="5">Grand Total</th>
            <th>${{$total_product_price + $total_shipping_price}}</th>
         </tr>

    @else
        <tr>
            <td colspan="7" class="text-center">No Product Selected</td>
        </tr>
    @endif    
     
  </tbody>
</table>



<h5>Combo</h5>
    <br>
<table class="table table-bordered">
  <thead>
     <tr>
        <th style="width:30%">Product ID</th>
        <th style="width:40%">Product</th>
        <th style="width:30%">Product Price</th>
     </tr>
  </thead>
  <tbody>    

    <?php $total_product_price_combo = 0?>
    @if(!empty($comboarr))
        @foreach($comboarr as $comboproduct)     
             <tr>
                <td>{{ $comboproduct["id"] }}</td>
                <td>{{ $comboproduct["name"] }}</td>  
                <td>${{ $comboproduct["product_price"] }}<?php $total_product_price_combo += $comboproduct["product_price"] ?></td>                   
             </tr>
        @endforeach

         <tr>
            <th colspan="2">Grand Total</th>
            <th>${{$total_product_price_combo}}</th>
         </tr>
    @else
        <tr>
            <td colspan="7" class="text-center">No Combo Product Selected</td>
        </tr>
    @endif      
     
  </tbody>
</table>


<h5>Size for Combo</h5>

<div class="form-group">
    <label class="col-md-1 control-label">Length</label>
    <div class="col-md-1">
        <input type="number" placeholder="Length" min="0" id="package_length" name="package_length" class="form-control">
    </div>

    <label class="col-md-1 control-label">Width</label>
    <div class="col-md-1">
        <input type="number" placeholder="Width" min="0" id="package_width" name="package_width" class="form-control">
    </div>

    <label class="col-md-1 control-label">Height</label>
    <div class="col-md-1">
        <input type="number" min="0" placeholder="Height" id="package_height" name="package_height" class="form-control">
    </div>

    <div class="col-md-1">
       <select class="form-control m-b js-dropdown-select2" id="package_size_unit" name="package_size_unit" required>
            <option value="cm" >CM</option>
            <option value="inch" selected>INCH</option>
        </select>
    </div>

    <label class="col-md-1 control-label">Weight</label>

    <div class="col-md-1">
        <input type="text" name="package_weight" id="package_weight" placeholder="Weight" class="form-control">
    </div>


    <div class="col-md-1">
       <select class="form-control m-b js-dropdown-select2" id="package_weight_unit" name="package_weight_unit">
            <option value="kg" >KG</option>
            <option value="lb" selected>LB</option>
        </select>
    </div>

</div>

