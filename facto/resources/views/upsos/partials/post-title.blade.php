<label class="col-sm-2 control-label" for=" ">제목<strong class="sound_only">필수</strong></label>
<div wire:ignore  class="col-sm-10" >

    <div class="input-group">
        <input 
            wire:ignore 
            wire:model.lazy="form.title" 
            type="text" 
            required
            class="form-control input-sm" 
            size="50" 
            maxlength="255"
        />
    </div>
    <div>
    @error('form.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
</div>