<div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if(auth()->user()->oauth)
            <div class="card card-warning mb-0">
                <div class="card-body">
                    <span>{!! Lang::get('profile.oauth_login', ['oauth' => auth()->user()->oauth]) !!}
                    <br><br>{!! Lang::get('profile.oauth_login_sub', ['oauth' => auth()->user()->oauth]) !!}</span>
                </div>
            </div>
            @else
            <form class="" method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                <div class="card card-warning mb-0">
                    <div class="card-header">
                        <h4 class="text-warning">{{ __('profile.change_pass_head') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('profile.current_pass') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <input type="password" data-toggle="password" class="form-control" placeholder="{{ __('profile.current_pass_placeholder') }}" name="master_password" id="master_password" required>
                            </div>
                        </div>
                        @if($user->is_2fa_enabled)
                        <div class="form-group">
                            <label>OTP (from Google Authenticator App) <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('profile.otp_info') }}" name="otp" id="otp" required>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>{{ __('profile.new_pass') }} <small class="text-danger">*</small></label>
                            <input type="password" data-toggle="password" name="password" id="password" class="form-control" placeholder="{{ __('profile.new_pass_placeholder') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('profile.new_pass_confirm') }} <small class="text-danger">*</small></label>
                            <input type="password" data-toggle="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('profile.new_pass_confirm_placeholder') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-warning btn-shadow"><i class="fas fa-redo"></i> {{ __('profile.change_pass_btn') }}</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>