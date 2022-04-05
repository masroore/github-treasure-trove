<!-- Modal -->
<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-ce-soir" id="exampleModalCenterTitle">Adjuntar Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form
                        id="voucherForm"
                        action=""
                        enctype="multipart/form-data"
                        method="POST"
                        class="mt-3">
                    @csrf
                    <input type="file" id="voucherFile" name="voucher">

                </form>


            </div>

        </div>
    </div>
</div>









