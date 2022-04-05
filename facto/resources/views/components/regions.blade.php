<div>
    <div>
        <div class="grid grid-cols-1 gap-1 text-base">
            <div 
                wire:click="setMainRegion({{ $null = null }})"
                class="{{ $main_region_id ==null ? 'bg-my-red': 'bg-my-black' }} cursor-pointer py-2 pr-1 text-white font-semibold  border rounded-md text-center "
            >
                전체
            </div>
        </div>
        <div class="grid grid-cols-4 gap-1 text-base">
            @foreach ($main_regions as $item)
                <div  
                    wire:click="setMainRegion( {{ $item->id }})"
                    class="{{ $item->id == $main_region_id  ? 'bg-my-red': 'bg-my-black' }} cursor-pointer text-white font-semibold py-2 pr-1 border rounded-md text-center"
                >
                    {{ $item->title }}
                </div>
            @endforeach
        </div>
        <div>
        @if( ! empty( $sub_regions ))
            <div class="grid grid-cols-4 gap-1 text-sm">
                @foreach ($sub_regions as $item)
                    <div  
                        wire:click="setSubRegion( {{ $item->id }})"
                        class="{{ $item->id == $sub_region_id  ? 'bg-gray-700 text-my-red font-bold border border-yellow-700 ': '' }} cursor-pointer text-black py-2 pr-1 border rounded-md text-center"
                    >
                        {{ $item->title }} ( <span class="text-my-red" >{{ $item->posts->count() }} </span>)
                    </div>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</div>