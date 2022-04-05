<div>

    {{ $main_region_id  }}
    <div>
        <div class="flex items-center justify-around  sm:justify-around mt-2 mb-6">
            <div class="flex items-center justify-around">
                <a href="{{ route('managers.index') }}">
                    <button class="{{  $upso_type == null ? 'top-menu-color' : 'bg-my-black' }} text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                    전체
                    </button>
                </a>
                @foreach ($upso_types as $item)
                    <a href="{{ route('managers.index', ['upso_type_id'=> $item->id ]) }}">
                        <button class="{{ isset(  $upso_type ) &&  $upso_type->id == $item->id ? 'top-menu-color' : 'bg-my-black' }}  text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                        {{  $item->title  }}
                        </button>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            @include('managers.regions', [
                'upso_type_id' =>$upso_type_id,
                'main_region_id' =>$main_region_id,
                'region_id' =>$region_id,
                'sub_regions'=>$sub_regions,
                'allowances'=>$allowances,
            ])
        </div>

        @livewire('manager-allow', [
            'upso_type_id' => $upso_type_id, 
            'main_region_id' => $main_region_id, 
            'region_id' => $region_id,
            'allowances'=> $allowances,
            'search'=> $search,
            'manager'=> $manager,
            ])
    </div>
    <div class="md:hidden">
        @include('upsos.partials.floating-phone')
    </div>
</div>


    {{-- Because she competes with no one, no one can compete with her. --}}
</div>
