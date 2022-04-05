<div>

    <x-jet.create-page-container class=" text-xs">
    <form wire:submit.prevent='save' >
        <div class="my-4">
            <x-jet.label for="title" value="업소 정보" />
            <div class="flex items-center justift-start">
                <div>{{  $upso->site_name }} [ {{  $upso->upso_type->title }} ] [ {{ $upso->region->title  }} ]</div>
            </div>
        </div>

        <div class="my-4">
            <x-jet.label for="name" value="이름" />
            <x-jet.input id="name"  wire:model.lazy="name" class="max-w-xs mt-1 w-full border border-black p-1" type="text" name="title" :value="old('title')" required autofocus />
            <span class="text-red-600 text-xs">매니저이름만 가능합니다.</span>
        </div>
        
        <div class="my-4">
            <x-jet.label for="cc" value="국적" />
            <x-jet.input id="cc"  wire:model.lazy="cc" class="max-w-xs mt-1 w-full border border-black p-1" type="text" name="cc" :value="old('cc')" required autofocus />
        </div>
        <div class="my-4">
            <x-jet.label for="price" value="+금액" />
            <x-jet.input id="price"  wire:model.lazy="price" class="max-w-xs mt-1 w-full border border-black p-1" type="text" name="title" :value="old('title')" required autofocus />
            <span class="text-red-600 text-xs">숫자만 입력바랍니다.</span>
        </div> 
        <div class="my-4">
            <x-jet.label for="age" value="나이" />
            <x-jet.input id="age"  wire:model.lazy="age" class="max-w-xs mt-1 w-full border border-black p-1" type="number" name="title" :value="old('title')" required autofocus />
            <span class="text-red-600 text-xs">숫자만 가능합니다.</span>
        </div> 
        <div class="my-4">
            <x-jet.label for="ht" value="키" />
            <x-jet.input id="ht"  wire:model.lazy="ht" class="max-w-xs mt-1 w-full border border-black p-1" type="number" name="title" :value="old('title')" required autofocus />
            <span class="text-red-600 text-xs">숫자만 가능합니다.</span>
        </div> 

        <div class="my-4">
            <x-jet.label for="wt" value="몸무게" />
            <x-jet.input id="wt"  wire:model.lazy="wt" class="max-w-xs mt-1 w-full border border-black p-1" type="number" name="title" :value="old('title')" required autofocus />
            <span class="text-red-600 text-xs">숫자만 가능합니다.</span>
        </div> 

        <div class="my-4">
            <x-jet.label for="bsize" value="가슴사이즈" />
            <div class="flex">
                @foreach ($bsizes as $item)
                <div class="w-1/4 sm:w-1/12 p-1 text-sm  ">
                    <div class=" w-ful  rounded-lg text-center flex items-center justify-center"
                    >
                        <input type="radio" wire:model="bsize" value="{{ $item }}" id="allow-{{ $item }}"/>
                        <label for="allow-{{ $item }}" class="mx-2">{{  $item }}</label>
                    </div>
                </div>
            @endforeach
            </div>
        </div> 

        <div class="my-4">
            <x-jet.label for="allowance" value="가능서비스" />
            
            <div class="flex flex-wrap my-2 border border-gray-500 p-2">
                @foreach ($all_allowances as $item)
                    <div class="w-1/4 sm:w-1/6 p-1 text-sm  ">
                        <div class=" w-ful  rounded-lg text-center flex items-center justify-start"
                        >
                            <input type="checkbox" id="allow-{{ $item->id }}" wire:model="allowances" value="{{ intval( $item->id )}}" />
                            <label for="allow-{{ $item->id }}" class="mx-2">{{  $item->title }}</label>
                        </div>
                    </div>
                @endforeach
                
            </div>
            <div class="text-red-600 text-xs">서비스는 다중선택이 가능합니다.</div>

        </div> 

        <script src="/assets/vendor/ckeditor2/ckeditor.js"></script>

        <div class="my-4">
            <x-jet.label for="description" value="매니저소개" />
            <div class="form-group">
                <textarea 
                    wire:model.lazy="content" 
                    class="w-full  p-1 text-gray-700 border border-black rounded-lg focus:outline-none" 
                    rows="4"
                ></textarea>
            </div>
        </div>

        <div class="my-4">
            {{-- @if( Auth::user()->isAdmin() ) --}}
            <div wire:ignore class="form-group">
                <x-jet.label for="upsothumb" value="메인이미지" />
                <div class="col-sm-10">
                    @include('managers.partials.manager-thumb-upload')
                </div>
                <div class="text-red-600 text-xs">기존 올린 이미지는 새로 업로드시에만 변경됩니다.</div>
            </div>
            {{-- @endif  --}}
        </div>
        <div class="my-4">
            <div wire:ignore class="form-group">
                <x-jet.label for="photos" value="추가 이미지" />
                <div class="col-sm-10">
                    @include('managers.partials.upload-photos')
                </div>
                <div class="text-red-600 text-xs">기존 올린 이미지들은 새로 업로드시에만 변경됩니다.</div>
            </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet.button class="ml-4">
                작성
            </x-jet.button>
        </div>
    </form>
    </x-jet.create-page-container>

</div>
