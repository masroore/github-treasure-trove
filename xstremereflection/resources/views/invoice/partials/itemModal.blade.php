<!-- Modal -->
<div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packageModalLabel">Add New Package To Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newPackageForm" action="/estimate/{{$estimate->id}}/addPackage" method="POST">
                    @csrf

                    <div class="form-group mb-2">
                        <label for="packageId"> Package <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="packageId" id="packageId" style="width:100%" onchange="listPriceUpdate()" required>
                            <option selected>Select Package Here</option>
                            @foreach($packages as $package)
                            <option value="{{$package->id}}">{{$package->description}} ({{$package->cost}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="discountType"> Discount Type <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="discountType" style="width:100%" onchange="discountUpdate()" required>
                            <option value="0">No Discount</option>
                            <option value="1">Percent</option>
                            <option value="2">Cash</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="discount"> Discount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="discount" id="discount" value="0.00" required/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="deposit"> Deposit <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="deposit" id="deposit" value="0.00" required/>
                    </div>

                    <div class="form-group mb-2" id="packageTotals">
                        <label for="discount"> Total Cost </label>

                        <p>List Price: $ <span id="listPrice"></span></p>
                        <p>Discount Total: $<span id="discountTotal"></span></p>
                        <p>Price Charged: $<span id="priceCharged"></span></p>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
