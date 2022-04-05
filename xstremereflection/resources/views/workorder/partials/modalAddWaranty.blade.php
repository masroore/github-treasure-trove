<!-- Modal -->
<div class="modal fade" id="warrantyModal" tabindex="-1" role="dialog" aria-labelledby="warrantyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warrantyModalLabel">Add Warranty Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/addwarrantycode/{{$workOrder->estimateId}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="warrantyCode">Warranty Code</label>
                        <input class="form-control" name="warrantyCode" id="warrantyCode" value="{{$workOrder->estimate->warrantyCode}}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Submit Warranty Code</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
