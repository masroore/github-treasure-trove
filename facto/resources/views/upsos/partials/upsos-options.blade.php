<div>
    <div class="flex p-2 ">
        @auth 
        @if( Auth::user()->isAdmin() )
            <x-jet.label value="옵션" />
            <div class="col-sm-10">
                <label class="control-label sp-label text-xs p-2 ">
                    <input 
                        wire:model="show_order"
                        type="radio" 
                        value="1" 
                        name="show_order"
                    /> 공지
                </label>
                <label class="control-label sp-label text-xs p-2 ">
                    <input 
                        wire:model="show_order" 
                        type="radio" 
                        value="2" 
                        name="show_order"
                    /> 메인업소
                </label>
        
                <label class="control-label sp-label text-xs p-2 ">
                    <input 
                        wire:model="show_order" 
                        type="radio" 
                        value="3" 
                        name="show_order"
                    /> 일반업소
                </label>
        
            </div>
            <div>
            @error("show_order") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif
        @endauth 
        </div>
</div>