<div>
   
    <div class="text-gray-700">
        <input 
            type="checkbox"
            wire:model.lazy="removeUserImages"
            id="removeUserImages"
            name="removeUserImages"
            value="1"
        />
        <label for="removeUserImages"> 삭제</label><br>
    </div>
    
    {{-- @if(  $edit_mode  && isset( $org_photos) &&  count( $org_photos ) > 0 )
        기존파일 보기 ( 총 {{ count( $org_photos ) }} 파일 )
        <div class="flex items-center justify-start w-full flex-none whitespace-no-wrap overflow-x-auto">
            @foreach ($org_photos as $photo)
                <img src="{{ $image_server . '/' .  $photo->thumb_path  }}" class="w-1/4 h-32 border border-gray-700 m-1 ">
            @endforeach
        </div>

        <div class="text-gray-700">
            <input 
                type="checkbox"
                wire:model.lazy="removeUserImages"
                id="removeUserImages"
                name="removeUserImages"
                value="1"
            />
            <label for="removeUserImages"> 삭제</label><br>
        </div>
    @elseif(  $edit_mode ==false && isset( $photos) &&  count( $photos ) > 0 )
        작은 사이즈로 미리 보기 ( 총 {{ count( $photos ) }} 파일 )
        <div class="flex items-center justify-start w-full flex-none whitespace-no-wrap overflow-x-auto">
            @foreach ($photos as $photo)
                <img src="{{ $photo->temporaryUrl() }}" class="w-1/4 h-32 border border-gray-700 m-1 ">
            @endforeach
        </div>
    @endif --}}

    <div
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <!-- File Input -->
        {{-- <input type="file" wire:model="photo"> --}}
        <div 
            wire:loading 
            wire:target="photos"
            class="text-red-600 text-base font-semibold"
        >임시 업로드 저장중입니다. 기다려주세요..</div>

        <input 
            wire:key='input-photos'
            type="file" 
            wire:ignore 
            wire:model.lazy="photos" 
            multiple> (이미지만 가능, 다수의 파일을 동시에 선택 가능 )
        @error('photos.*') <span class="error">{{ $message }}</span> @enderror

        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
        </div>
    </div>

    @error('photos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

</div>