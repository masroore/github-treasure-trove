<div class="modal fade" id="delete-user" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                @csrf
                @method('DELETE')
                <div class="card card-danger mb-0">
                    <div class="card-header">
                        <h4 class="text-danger">{{ __('admin.profile.delete_user') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('admin.profile.delete_confirm') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <select class="form-control" name="confirm" id="confirm" required>
                                    <option value="" selected disabled>{{ __('admin.profile.delete_confirm_sub') }}</option>
                                    <option value="1">{{ __('admin.profile.delete_confirm_msg') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-danger">
                            @lang('admin.profile.delete_warning')
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-trash"></i> {{ __('admin.profile.delete_user') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>