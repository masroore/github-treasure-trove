<form wire:submit.prevent="generate">
    <div class="card-body bg-secondary">
        <div class="form-group row">
            <label for="level" class="col-md-4 col-sm-4 col-form-label text-right"><b>Difficulty Level</b></label>
            <div class="col-md-8 col-sm-8">
                <div class="input-group">
                    <select class="form-control {{ $errors->has('level') ? ' is-invalid' : '' }}" wire:model.lazy="level">
                        <option disabled>Select Password Difficulty Level</option>
                        <option value="ld">Level 1</option>
                        <option value="lud">Level 2</option>
                        <option value="luds">Level 3</option>
                    </select>
                </div>
                @error('level') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="size" class="col-md-4 col-sm-4 col-form-label text-right"><b>Password Size</b></label>
            <div class="col-md-8 col-sm-8">
                <input type="text" class="form-control {{ $errors->has('size') ? ' is-invalid' : '' }}" wire:model="size">
                @error('size') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="dashes" class="col-md-4 col-sm-4 col-form-label text-right"><b>Add Dashes</b></label>
            <div id="for-dashes" class="col-md-8 col-sm-8">
                <select class="selectpicker form-control {{ $errors->has('dashes') ? ' is-invalid' : '' }}" wire:model.lazy="dashes" data-container="#for-dashes">
                    <option disabled>Should the password contain dashes or not?</option>
                    <option value="1" default>Yes</option>
                    <option value="0">No</option>
                </select>
                @error('dashes') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12">
                <button type="submit" class="btn btn-outline-primary btn-icon">
                    <i class="fas fa-key"></i> Generate Password</button>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="input-group align-items-center">
                <label class="col-form-label mr-1"><i class="fas fa-arrow-alt-circle-right text-primary rpg"></i></label>
                <input type="text" class="form-control mr-1 text-primary font-weight-bold" value="{{ $rpg }}" id="rpg" name="rpg">
                <span class="input-group-button">
                    <button class="btn btn-outline-primary" name="btn" id="btn" type="button" data-clipboard-target="#rpg" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                        <i class="fas fa-copy"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>