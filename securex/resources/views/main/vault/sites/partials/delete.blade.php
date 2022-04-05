<div class="modal fade" id="delete-site" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-gradient-danger">
            <div class="modal-header">
                <h5 class="modal-title text-white">{{ __('site.delete_head') }}</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body text-white"> {{ __('site.delete_body') }}</div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('vault.site.delete', [$vault,$site]) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-light btn-shadow">{{ __('site.delete_btn') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>