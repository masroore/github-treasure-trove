<div class="flex flex-wrap mt-4">
    
    @foreach ($all_allowances as $item)
        <div class="w-1/4 sm:w-1/6 md:w-1/8 lg:w-1/12 p-1 text-sm  ">
            <div 
                wire:click="add_allowance({{  $item->id }})"
                class="{{ in_array( $item->id, $allowances) ? 'bg-blue-400' : 'bg-white' }} w-full border border-indigo-500 rounded-md flex items-center justify-start py-1"
            >
                {{-- <input type="checkbox" 
                        id="allow-{{ $item->id }}" 
                        wire:model="allowances" 
                        value="{{  $item->id }}" 
                        class="p-2 ml-2 border-0 border-white"
                        style="border: 0;" 
                        /> --}}
                <label for="allow-{{ $item->id }}" class="w-full  mx-1 text-xs text-center">
                    {{  $item->title }}
                    
                    ( {{  $item->managers_count }} ) 
                </label>
            </div>
        </div>
    @endforeach
</div>