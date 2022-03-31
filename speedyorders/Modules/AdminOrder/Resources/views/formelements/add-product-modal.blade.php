<div class="modal" id="add-product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add new Product</strong>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="product_id">Choose Product *</label>
                    <select name="product_id" class="form-control js-dropdown-select2" id="product_id">
                        @foreach ($products as $row=>$product)
                        <option value="{{ $product->id }}">{{ $product->name.'('.$product->sku.')' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-product-otion-panel">

                </div>
                <div class="form-group">
                    <label for="order_product_quantity" class="control-label">{{ 'Quantity *' }}</label>
                    <input class="form-control" type="text" name="order_product_quantity" id="order_product_quantity">
                </div>
                
                <?php /*
                <div class="modal-product-package-panel">
                    <label for="order_product_package" class="control-label">{{ 'Package *' }}</label>
                    <select class="form-control js-dropdown-select2"  name="order_product_package" id="order_product_package">
                        <option value="">Select Product Shipping Package</option>
                    </select>
                </div>*/?>

                <div class="validate-msg" style="display: none;">
                    <p class="text-danger" > Fill up the form first </p>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success add-product">Add Products</button>
            </div>
        </div>
    </div>
</div>