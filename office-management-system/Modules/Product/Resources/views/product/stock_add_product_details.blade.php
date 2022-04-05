
    <div class="col-lg-6">
       <div class="primary_input mb-15">
          <label class="primary_input_label" for="">{{__("common.Purchase Price")}} *</label>
          <div class="">
             <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ $product->purchase_price }}" class="primary_input_field" >
          </div>
       </div>
    </div>
    <div class="col-lg-6">
       <div class="primary_input mb-15">
           <label class="primary_input_label" for="">{{__("common.Selling Price")}} *</label>
           <div class="">
              <input type="number" min="1" step="0.01" name="selling_price" id="selling_price" value="{{ $product->selling_price }}" class="primary_input_field" >
           </div>
       </div>
    </div>
