<!-- Modal -->
<div class="modal fade" id="customerEditModal" tabindex="-1" role="dialog" aria-labelledby="customerEditModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerEditModalLabel">Edit Customer And Date Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/estimate/{{$estimate->id}}/edit" method="POST" id="customerForm" method="POST">
                @method('PUT')



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="customerSubmit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
