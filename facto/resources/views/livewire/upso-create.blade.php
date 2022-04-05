<div>
    <x-jet.create-page-container class=" text-xs">
    <form wire:submit.prevent='save' >
        <div class="my-2">
            @include('upsos.partials.upso-types')
        </div>
        <div class="my-2">
            @include('upsos.partials.upsos-options')
        </div>
        <div class="my-2 p-2">
            <x-jet.label for="site_name" value="업소이름" />
            <x-jet.input wire:model.lazy="site_name" id="site_name" class="block border border-black p-1 mt-1 w-full" type="text" name="site_name" :value="old('site_name')" required autofocus />
        </div>
        <div class="my-2">
            <x-jet.label for="region_id" value="업소지역" />
            <div class="form-group">
                <div  class="col-sm-10" >
                    <div class="input-group flex items-center justify-start">
                        <div class="p-2">
                            <select
                                wire:ignore
                                wire:model="main_region_id" 
                                class="block appearance-none min-w-xl border border-black text-black text-sm p-1  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-700"
                            >
                            
                            @foreach ($main_regions as $item)
                                <option value="{{ $item->id}}">{{ $item->title }}</option>
                            @endforeach
                            </select>
                        </div>
    
                        <div class="p-2">
                        @if(!empty($sub_regions))
                            <select 
                                wire:model="region_id" 
                                class="block appearance-none min-w-xl border border-black text-black text-sm p-1  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-700"
                            >
                            @forelse ($sub_regions as $item)
                                <option 
                                    value="{{ $item->id}}" 
                                >{{ $item->title }}</option>
                            @empty 
                                <option disabled >no data </option>
                            @endforelse
                            </select>
                        @endif
                        </div>
                        
                    </div>
                    <div>
                    @error('region_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div> 

        </div>

        <div class="my-2 p-2">
            <x-jet.label for="phone" value="업소전화번호" />
            <x-jet.input id="phone" wire:model.lazy="phone" class="block mt-1 w-full border border-black p-1" type="text" name="phone" :value="old('phone')" required autofocus />
        </div>

        <div class="my-2 p-2">
            <x-jet.label for="title" value="제목" />
            <x-jet.input id="title"  wire:model.lazy="title" class="block mt-1 w-full border border-black p-1" type="text" name="title" :value="old('title')" required autofocus />
        </div>
        
        <div class="my-2 p-2">
            <x-jet.label for="content" value="내용 (HTML 소스 입력가능)" />
            @include('common.editor')
            {{-- <textarea 
                wire:model.lazy="content" 
                class="w-full h-64  p-1 text-gray-700 border border-black rounded-lg focus:outline-none" 
                rows="4"
            ></textarea> --}}
        </div>


        @if( Auth::user()->isAdmin() )
        <div wire:ignore class="form-group my-2 p-2">
            <label class="col-sm-2 control-label text-xs">업소 메인이미지</label>
            <div class="col-sm-10">
                @include('upsos.partials.upso-thumb-upload')
            </div>
        </div>
        @endif 

        @if( Auth::user()->isAdmin() ) 
        <div wire:ignore class="form-group my-2  p-2">
            <label class="col-sm-2 control-label text-xs">첨부 이미지</label>
            <div class="col-sm-10">
                @include('upsos.partials.upload-photos', 
                    [ 'editMode'=> false ] 
                )
            </div>
        </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <x-jet.button class="ml-4">
                작성
            </x-jet.button>
        </div>
        
    </form>
    </x-jet.create-page-container>



    
</div>
