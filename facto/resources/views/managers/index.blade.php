<x-layout >
    <div>
        <x-common.top-title menu='매니저정보' mode='리스트' />
        <link rel="stylesheet" href="/css/upso.css?v=12">
        <div>
            <div class="flex items-center justify-around  sm:justify-around my-2">
                <div class="flex items-center justify-around">
                    <a href="{{ route('managers.index') }}">
                        <button class="{{  $upso_type == null ? 'top-menu-color' : 'bg-my-black' }} text-xs font-bold p-2 sm:py-3 sm:px-6 rounded-lg ml-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                        전체
                        </button>
                    </a>
                    @foreach ($upso_types as $item)
                        <a href="{{ route('managers.index', ['upso_type_id'=> $item->id ]) }}">
                            <button class="{{ isset(  $upso_type ) &&  $upso_type->id == $item->id ? 'top-menu-color' : 'bg-my-black' }}  text-xs font-bold p-2 sm:py-3 sm:px-6 rounded-lg ml-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
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
                'search'=>$search,
                'manager'=> $manager ?? null,
                ])

        </div>
        @include('managers.partials.buttons-write-list')
    </div>




</x-layout>
