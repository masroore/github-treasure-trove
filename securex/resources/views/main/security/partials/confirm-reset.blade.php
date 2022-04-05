<div class="modal fade" id="confirm-reset" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('security.2fa.reset') }}">
                @csrf
                <div class="card card-info mb-0">
                    <div class="card-header">
                        <h4 class="text-info">{{ __('security.ga_reset_head') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <h6>{{ __('security.ga_reset_body') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-info btn-shadow"><i class="fas fa-redo"></i> {{ __('security.ga_reset_confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>