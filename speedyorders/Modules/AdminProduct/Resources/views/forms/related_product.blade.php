<div class="row">
    <label class="col-md-2 control-label">Related products</label>

   
    <div class="col-md-10">
        <select class="form-control js-dropdown-select2" name="related_products[]" multiple="multiple">
            <option value="">Select related product</option>
            @foreach($products as $pro)
                <option <?php echo (!empty($relatedProductIds) && (in_array($pro->id, $relatedProductIds))) ? 'selected' : ''; ?> value="{{$pro->id}}">{{$pro->name}}                  
                </option>
            @endforeach
        </select>
    </div>
</div>
