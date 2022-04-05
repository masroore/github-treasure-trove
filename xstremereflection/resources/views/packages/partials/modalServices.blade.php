<!-- Modal -->
<div class="modal fade" id="servicesModal" tabindex="-1" role="dialog" aria-labelledby="servicesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="servicesModalLabel">Add Services Included in Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="services">
                <form action="/package/storeService/{{$package->id}}" id="addPackageForm" method="post">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label>Select services which are included in this package.</label>
                            <select class="js-example-basic-multiple" name="package_items[]" multiple="multiple" style="width:100%">
                                @foreach($services as $service)
                                    <option value="{{$service->id}}" >{{$service->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </fieldset>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>

            </div>
        </div>
    </div>
</div>
