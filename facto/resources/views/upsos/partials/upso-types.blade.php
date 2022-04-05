<div>
    <div class=" flex p-2 ">
        <x-jet.label value="업종" />
        <div class="col-sm-10">
            @foreach ($upso_types as $item)
                <label class="control-label sp-label text-xs p-2">
                <input 
                    wire:model="upso_type_id"
                    type="radio" 
                    value="{{  $item->id  }}" 
                    name="upso_type_id"
                /> {{  $item->title }}
                    
                </label>
            @endforeach
        </div>
        <div>
        @error("upso_type_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>
</div>