<div>
    {{-- @if( Auth::user()->isAdmin() ) --}}

        {{-- @if ($upsothumb)
        미리 보기 
        <div class="flex items-center justify-start w-full flex-none whitespace-no-wrap overflow-x-auto">
            <img src="{{ $upsothumb->temporaryUrl() }}" class="w-1/4 h-32 border border-gray-700 m-1 ">
        </div>
        @endif --}}

        {{-- <div class="text-gray-700">
            <input 
                type="checkbox"
                wire:model.lazy="removeThumb"
                id="removeThumb"
                name="removeThumb"
                value="1"
            />
            <label for="removeThumb"> 삭제</label><br>
        </div> --}}
        
        @if( isset( $editMode) &&  $editMode )
            <div class="text-gray-700">
                <input 
                    type="checkbox"
                    wire:model.lazy="removeThumb"
                    id="removeThumb"
                    name="removeThumb"
                    value="1"
                />
                <label for="removeThumb"> 기존 썸네일 삭제</label><br>
            </div>
        @endif
        
        <div
            x-data="{ isUploadingUpsoThumb: false, progressUpsoThumb: 0 }"
            x-on:livewire-upload-start="isUploadingUpsoThumb = true"
            x-on:livewire-upload-finish="isUploadingUpsoThumb = false"
            x-on:livewire-upload-error="isUploadingUpsoThumb = false"
            x-on:livewire-upload-progress="progressUpsoThumb = $event.detail.progressUpsoThumb"
        >
            <!-- File Input -->
            {{-- <input type="file" wire:model="thumb"> --}}
            <div 
                wire:loading 
                wire:target="upsothumb"
                class="text-red-600 text-base font-semibold"
            >임시 업로드 저장중입니다. 기다려주세요..</div>

            <input 
                wire:key='input-upsothumb'
                type="file" 
                wire:ignore 
                wire:model.lazy="upsothumb" 
            > (500KB 이하 이미지만 가능 )
            @error('upsothumb') <span class="error">{{ $message }}</span> @enderror

            <!-- Progress Bar -->
            <div x-show="isUploadingUpsoThumb">
                <progress max="100" x-bind:value="progressUpsoThumb"></progress>
            </div>
        </div>

        @error('upsothumb') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

    {{-- @endif  --}}
</div>