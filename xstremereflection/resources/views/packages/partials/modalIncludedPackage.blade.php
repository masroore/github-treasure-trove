<!-- Modal -->
<div class="modal fade" id="includedPackageModal" tabindex="-1" role="dialog" aria-labelledby="includedPackageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="servicesModalLabel">Add Included Packages</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/package/storeIncludedPackage/{{$package->id}}" id="addIncludedPackageForm" method="post">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label>Select packages which are included in this package.</label>
                            <select class="js-example-basic-multiple" name="packages_included[]" multiple="multiple" style="width:100%">
                                @foreach($availablePackages as $row)
                                    <option value="{{$row->id}}" >{{$row->description}} @if($row->companyId == 0) XR Package  @endif</option>
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
