<div class="modal fade" id="change-email" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.users.change.email', $user) }}">
                @csrf
                <div class="card card-warning mb-0">
                    <div class="card-header">
                        <h4 class="text-warning">{!! Lang::get('admin.profile.change_email_user', ['user' => $user->first_name]) !!}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('admin.profile.current_email') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="{{ __('admin.profile.current_email_placeholder') }}" name="current_email" id="current_email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.profile.new_email') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="{{ __('admin.profile.new_email_placeholder') }}" name="email" id="email" required>
                            </div>
                            <small id="emailHelpBlock" class="form-text text-muted">
                                {{ __('admin.profile.new_email_sub') }}
                            </small>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.profile.support_pin') }} <small class="text-danger">*</small></label>
                            <input type="text" name="pin" id="pin" class="form-control" placeholder="{{ __('admin.profile.support_pin_placeholder') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-warning btn-shadow"><i class="fas fa-redo"></i> {{ __('admin.profile.change_email') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>