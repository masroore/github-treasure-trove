<form wire:submit.prevent="verifyKeys">
    @csrf
    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('security.master_pass') }}</label>
        <div class="col-md-6">
            <input wire:model.lazy="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
            @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="access_key" class="col-md-4 col-form-label text-md-right">{{ __('security.access_key') }}</label>
        <div class="col-md-6">
            <input wire:model.lazy="access_key" type="text" placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX-XXXXX" class="form-control {{ $errors->has('access_key') ? ' is-invalid' : '' }}">
            @error('access_key') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="question_1" class="col-md-4 col-form-label text-md-right">{{ __('security.q1') }}</label>
        <div class="col-md-6">
            <p>{{ $questions->question_1 }}</p>
        </div>
        <label for="answer_1" class="col-md-4 col-form-label text-md-right">{{ __('security.a1') }}</label>
        <div class="col-md-6">
            <input wire:model.lazy="answer_1" placeholder="{{ __('security.a1_placeholder') }}" type="text" class="form-control {{ $errors->has('answer_1') ? ' is-invalid' : '' }}">
            @error('answer_1') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="question_2" class="col-md-4 col-form-label text-md-right">{{ __('security.q1') }}</label>
        <div class="col-md-6">
            <p>{{ $questions->question_2 }}</p>
        </div>
        <label for="answer_2" class="col-md-4 col-form-label text-md-right">{{ __('security.a2') }}</label>
        <div class="col-md-6">
            <input wire:model.lazy="answer_2" placeholder="{{ __('security.a2_placeholder') }}" type="text" class="form-control {{ $errors->has('answer_2') ? ' is-invalid' : '' }}">
            @error('answer_2') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('security.disable_2step_btn') }}
            </button>
        </div>
    </div>
</form>