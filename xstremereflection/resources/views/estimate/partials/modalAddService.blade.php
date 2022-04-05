<!-- Modal -->
<div class="modal fade" id="addServicesModal" tabindex="-1" role="dialog" aria-labelledby="addServicesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServicesModalLabel">Add Service To Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="addServices">
                <form id="serviceForm" action="#" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="discountType"> Select Service  <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="serviceId" id="serviceId" style="width:100%" onchange="serviceUpdate()" required>
                            <option selected >Select Service</option>
                            <option value="0">Custom Service</option>
                            @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->description}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="addCustomServiceForm">
                        <div class="form-group mb-2">
                            <label for="description"> Service Description <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="description" id="description" />
                        </div>

                        <div class="form-group mb-2">
                            <label for="price"> Service Price <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="price" id="price" />
                        </div>

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
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="show" id="inlineRadio1" value="0">
                            <label class="form-check-label" for="inlineRadio1">Dont Show on Estimate</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="show" id="inlineRadio2" value="1" checked>
                            <label class="form-check-label" for="inlineRadio2">Show on Estimate</label>
                        </div>
                    </div>


                    <button type="submit" id="serviceButton" class="btn btn-primary btn-lg btn-block">Add Service To Package</button>
                </form>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
