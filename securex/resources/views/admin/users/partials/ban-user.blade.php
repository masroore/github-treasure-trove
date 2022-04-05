<div class="modal fade" id="ban-user" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.users.ban.store', $user) }}">
                @csrf
                <div class="card card-danger mb-0">
                    <div class="card-header">
                        <h4 class="text-danger">{{ __('admin.profile.ban_user') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('admin.profile.ban_confirm') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <select class="form-control" name="confirm" id="confirm" required>
                                    <option value="" selected disabled>{{ __('admin.profile.ban_confirm_sub') }}</option>
                                    <option value="1">{{ __('admin.profile.ban_confirm_msg') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.profile.remark') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('admin.profile.remark_placeholder') }}" name="remark" id="remark" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-ban"></i> {{ __('admin.profile.ban_user') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>