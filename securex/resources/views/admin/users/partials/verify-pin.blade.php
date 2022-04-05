<div class="modal fade" id="verify-pin" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.users.pin.verify', $user) }}">
                @csrf
                <div class="card card-info mb-0">
                    <div class="card-header">
                        <h4 class="text-info">{!! Lang::get('admin.profile.verify_pin_user', ['user' => $user->first_name]) !!}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('admin.profile.support_pin') }} <small class="text-danger">*</small></label>
                            <input type="text" name="support_pin" id="support_pin" class="form-control" placeholder="{{ __('admin.profile.support_pin_placeholder') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-info btn-shadow"><i class="fas fa-check-circle"></i> {{ __('admin.profile.verify_pin') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>