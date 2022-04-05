<div class="modal fade" id="change-avatar" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <span class="text-center">
                        <p><b>{{ __('profile.change_avatar_head') }}</b></p>
                        <hr>
                    </span>
                    <div class="form-group">
                        <label><small class="text-muted">Recommend Size 800x800</small></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar" required>
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-dark btn-shadow"><i class="fas fa-redo"></i> {{ __('profile.change_avatar_btn') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>