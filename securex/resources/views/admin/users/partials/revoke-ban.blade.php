<div class="modal fade" id="revoke-ban" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.users.ban.delete', $user) }}">
                @csrf
                @method('delete')
                <div class="card card-success mb-0">
                    <div class="card-header">
                        <h4 class="text-success">{{ __('admin.profile.revoke_ban') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('admin.profile.revoke_ban') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <select class="form-control" name="confirm" id="confirm" required>
                                    <option value="" selected disabled>{{ __('admin.profile.revoke_ban_confirm') }}</option>
                                    <option value="1">{{ __('admin.profile.revoke_ban_confirm_msg') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-success btn-shadow"><i class="fas fa-redo"></i> {{ __('admin.profile.revoke_ban') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>