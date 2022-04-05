<!-- Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleModalLabel">Add Vehicle to Estimate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/estimate/addVehicle/{{$customer->id}}/{{$estimate->id}}" id="vehicleForm" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="vehicleId"> Customer Vehicle <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="vehicleId" id="vehicleId" style="width:100%" onchange="vehicleUpdate()">
                            <option selected>Select Customers Vehicle Here</option>
                            <option value="0">Vehicle Not Listed</option>
                            @foreach($customer->vehicles as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->year}} {{$vehicle->make}} ({{$vehicle->model}} )</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" id="addCustomerVehicle" class="btn btn-primary">Add Vehicle</button>
                </form>

                <form id="new" action="/estimate/addVehicle/{{$customer->id}}/{{$estimate->id}}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="discount">Enter Vehicle VIN </label>
                        <input type="text" class="form-control" name="vin" id="vin" placeholder="Type VIN Here" onchange="vinUpdate()" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="year">Vehicle Year <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="year" id="year" placeholder="Vehicle Year" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="make">Vehicle Make <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="make" id="make" placeholder="Vehicle Make" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="model">Vehicle Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="model" id="model" placeholder="Vehicle Model" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="trim">Vehicle Trim </label>
                        <input type="text" class="form-control" name="trim" id="trim" placeholder="Vehicle Trim"  />
                    </div>
                    <div class="form-group mb-2">
                        <label for="condition">Vehicle Style </label>
                        <input type="text" class="form-control" name="style" id="style" placeholder="Vehicle Style"  />
                    </div>
                    <div class="form-group mb-2">
                        <label for="color">Vehicle Color <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="color" id="color" style="width:100%" >
                            <option selected>Select Vehicle Color</option>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}">{{$color->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="condition">Vehicle Condition <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="condition" id="condition" style="width:100%">
                            <option selected>Select Vehicle Color</option>
                            @foreach($conditions as $condition)
                                <option value="{{$condition->id}}">{{$condition->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"  class="btn btn-primary">Add Vehicle</button>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
