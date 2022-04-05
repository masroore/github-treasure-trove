<form wire:submit.prevent="addNote">
    <div class="pl-lg-2 pt-4">
        <div class="form-group row">
            <div class="col-md-12 col-sm-12">
                <input type="text" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" wire:model.lazy="note" placeholder="{{ __('site.notes_body') }}" autofocus>
                @error('note') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row text-center pl-lg-2">
        <div class="col-lg-12 col-sm-12">
            <button class="btn btn-dark btn-block btn-icon mb-4">
                <i class="fas fa-plus"></i> {{ __('site.notes_add') }}
            </button>
        </div>
    </div>
</form>