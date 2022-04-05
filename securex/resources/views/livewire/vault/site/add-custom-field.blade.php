<form wire:submit.prevent="addField">
    <div class="pl-lg-2 pt-4">
        <div class="form-group row">
            <div class="col-md-5 col-sm-5">
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" wire:model.lazy="name" placeholder="{{ __('site.custom_fields_name') }}" autofocus>
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-7 col-sm-7">
                <input type="text" class="form-control {{ $errors->has('value') ? ' is-invalid' : '' }}" wire:model.lazy="value" placeholder="{{ __('site.custom_fields_value') }}">
                @error('value') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row text-center pl-lg-2">
        <div class="col-lg-12 col-sm-12">
            <button class="btn btn-primary btn-block btn-icon mb-4">
                <i class="fas fa-plus"></i> {{ __('site.custom_fields_add') }}
            </button>
        </div>
    </div>
</form>