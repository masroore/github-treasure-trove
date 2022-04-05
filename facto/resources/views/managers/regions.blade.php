<div class="row">
    <div class="div-tab tabs">
    <div class="grid grid-cols-1 gap-1 text-sm">
            <a href="{{ route('managers.index', [
                'upso_type_id'=>$upso_type_id, 
                'main_region_id'=>null, 
                'region_id'=>null, 
            ]) }}">
            <div 
            {{-- wire:click="setMainRegion( -1 )" --}}
            
            class="{{ $main_region_id ==null ? 'top-menu-color': 'bg-my-black' }} cursor-pointer py-2 pr-1 text-white font-normal  border rounded-md text-center "
        >
                전체지역
            </div>
        </a>
    </div>
    <div class="flex flex-wrap text-sm">
        @foreach ($main_regions as $item)
        <a href="{{ route('managers.index', [
            'upso_type_id'=>$upso_type_id, 
            'main_region_id'=>$item->id, 
            'region_id'=>null, 
            ]) }}"
            class="{{ $item->id == $main_region_id  ? 'top-menu-color': 'bg-my-black' }} w-1/4 cursor-pointer text-white font-normal py-2 border rounded-md text-center "
        >
                <div  
                    {{-- wire:click="setMainRegion( {{ $item->id }})" --}}
                    class=""
                >
                    {{ $item->title }}
                </div>
            </a>
        @endforeach
    </div>
    <div>
    @if( ! empty( $sub_regions ))
        <div class="flex flex-wrap text-xs">
            @foreach ($sub_regions as $item)
                <a href="{{ route('managers.index', [
                            'upso_type_id'=>$upso_type_id, 
                            'main_region_id'=>$main_region_id, 
                            'region_id'=> $item->id, 
                        ]) }}"
                    class="{{ $item->id == $region_id ? 'bg-gray-700 text-my-red font-bold border border-yellow-700 ': '' }} w-1/4 cursor-pointer text-black p-1 border rounded-md text-center"
                >
                    <div>
                        {{ $item->title }} 
                        <br>
                        ( <span class="text-my-red" >
                            {{ $item->count_managers($upso_type_id) }} 
                        </span>)
                    </div>
                </a>
            @endforeach
        </div>
    @endif
    </div>
</div>
</div>