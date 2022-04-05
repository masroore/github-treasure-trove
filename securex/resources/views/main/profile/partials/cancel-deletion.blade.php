<div class="modal fade" id="cancel-deletion" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-gradient-danger">
            <div class="modal-header">
                <h5 class="modal-title text-white">Want to cancel your Account Deletion?</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body text-white">If you cancel your account deletion, all of your data will stay intact.</div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('profile.delete.cancel') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-shadow">Yes, Cancel Account Deletion</button>
                </form>
            </div>
        </div>
    </div>
</div>