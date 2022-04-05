<div>
    <form role="form" wire:submit.prevent="updateProfile">
        <h6 class="heading-small text-muted mb-4">{{ __('profile.personal_info') }}</h6>
        <div class="pl-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="first_name">{{ __('profile.firstname') }}</label>
                        <input type="text" id="first_name" wire:model.lazy="first_name" placeholder="{{ __('profile.firstname_placeholder') }}" class="form-control form-control-alternative @error('first_name') is-invalid @enderror" required>
                        @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="last_name">{{ __('profile.lastname') }}</label>
                        <input type="text" id="last_name" wire:model.lazy="last_name" placeholder="{{ __('profile.lastname_placeholder') }}" class="form-control form-control-alternative @error('last_name') is-invalid @enderror" required>
                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="email">{{ __('profile.email') }}
                            <span data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('profile.email_info') }}"><i class="fas fa-question-circle"></i></span>
                        </label>
                        <input type="email" class="form-control form-control-alternative" value="{{ $this->user->email }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="country">{{ __('profile.country') }}</label>
                        <div class="input-group">
                            <select id="country" name="country" class="form-control @error('country') is-invalid @enderror" wire:model="country" required>
                                <option value="">Select a Country</option>
                                @foreach($this->countries as $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="phone">{{ __('profile.phone') }}
                            <span data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('profile.phone_info') }}"><i class="fas fa-question-circle"></i></span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary" id="cc">
                                 @if($this->cc)
                                    +{{ $this->cc }}
                                @endif
                                </span>
                            </div>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model.lazy="phone" required>
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="dob">{{ __('profile.dob') }}
                            <small class="text-muted">(MM/DD/YYYY)</small>
                        </label>
                        <div class="form-group">
                            <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror" wire:model.lazy="dob" id="dob" required>
                            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @if($this->user->oath)
                <div class="col-lg-12 text-center">
                    <small>{!! Lang::get('profile.oauth_login', ['oauth' => auth()->user()->oauth]) !!}</small>
                </div>
                @endif
            </div>
        </div>
        <hr class="my-4">
        <!-- Billing Information -->
        <h6 class="heading-small text-muted mb-4">{{ __('profile.billing_info') }}</h6>
        <div class="pl-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="address_line1">{{ __('profile.address1') }}</label>
                        <input type="text" id="address_line1" wire:model.lazy="address_line1" placeholder="{{ __('profile.address1_placeholder') }}" class="form-control form-control-alternative @error('address_line1') is-invalid @enderror">
                        @error('address_line1') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group focused">
                        <label class="form-control-label" for="address_line2">{{ __('profile.address2') }}</label>
                        <input type="text" id="address_line2" wire:model.lazy="address_line2" placeholder="{{ __('profile.address2_placeholder') }}" class="form-control form-control-alternative @error('address_line2') is-invalid @enderror">
                        @error('address_line2') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="city">{{ __('profile.city') }}</label>
                        <input type="text" wire:model.lazy="city" id="city" placeholder="{{ __('profile.city_placeholder') }}" class="form-control form-control-alternative @error('city') is-invalid @enderror">
                        @error('coty') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="zipcode">{{ __('profile.zipcode') }}</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="zipcode" id="zipcode" placeholder="{{ __('profile.zipcode_placeholder') }}" class="form-control form-control-alternative @error('zipcode') is-invalid @enderror">
                            @error('zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="state">{{ __('profile.state') }}</label>
                        <select id="state" name="state" class="form-control @error('state') is-invalid @enderror" wire:model="state" required>
                            @if($this->country)
                                @foreach($this->states as $state)
                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <!-- Account Information -->
        <h6 class="heading-small text-muted mb-4">{{ __('profile.account_info') }}</h6>
        <div class="pl-lg-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group focused">
                        <label class="form-control-label" for="rng_level">{{ __('profile.randomizer') }} <span data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('profile.randomizer_info') }}"><i class="fas fa-question-circle"></i></span></label>
                        <select class="form-control @error('rng_level') is-invalid @enderror" wire:model.lazy="rng_level" id="rng_level" required>
                            <option value="1" @if($user->rng_level=='1') selected @endif>Weak [8 Characters Combo of (a-z) + (1-9)] </option>
                            <option value="2" @if($user->rng_level=='2') selected @endif>Normal [8 Characters Combo of (a-z) + (A-Z) + (1-9)] </option>
                            <option value="3" @if($user->rng_level=='3') selected @endif>Strong [12 Characters Combo of (a-z) + (A-Z) + (1-9) + (Special Characters)] </option>
                            <option value="4" @if($user->rng_level=='4') selected @endif>Very Strong [16 Characters Combo of (a-z) + (A-Z) + (1-9) + (Special Characters) + (Dashes)] </option>
                        </select>
                        @error('rng_level') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" wire:ignore>
                    <div class="form-group focused">
                        <label class="form-control-label" for="support_pin">{{ __('profile.support_pin') }} <span data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('profile.support_pin_info') }}"><i class="fas fa-question-circle"></i></span></label>
                        <input data-toggle="support_pin" type="password"  id="support_pin" wire:model.lazy="support_pin" class="form-control @error('support_pin') is-invalid @enderror" placeholder="Your 4-digit Support PIN" required="">
                        @error('support_pin') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        @if($this->user->profile_incomplete())
                        <button type="submit" class="btn btn-success my-4">{{ __('profile.complete_my_profile') }}</button>
                        @else
                        <button type="submit" class="btn btn-primary my-4">{{ __('profile.update_profile') }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
$('#dob').on('change', function (e) {
    @this.set('dob', e.target.value);
});
$('#country').on('change', function (e) {
    @this.set('country', e.target.value);
    @this.call('updateStates');
});
$('#state').on('change', function (e) {
    @this.set('state', e.target.value);
});
$('#rng_level').on('change', function (e) {
    @this.set('rng_level', e.target.value);
});
$('#support_pin').on('change', function (e) {
    @this.set('support_pin', e.target.value);
});
</script>
@endpush

@push('notyf')
<script>
window.livewire.on('profileUpdated', msg => {
    notyf.open({
        type: 'success',
        message: 'Profile Updated Successfully.'
    });
});
</script>
@endpush