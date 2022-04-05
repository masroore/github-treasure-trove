<x-layout >
    <div>
        

        <x-common.top-title menu='업소정보' mode='리스트' />
        <link rel="stylesheet" href="/css/upso.css?v=12">
        
        <p class=" flex items-center justify-center" >
            {{-- <img alt="1만원쿠폰.png" src="{{ $image_domain }}/images/coupon1.png"> --}}
        </p>
    
        <div>
            <div class="flex items-center justify-around  sm:justify-around my-2">
                <div class="flex items-center justify-around">
                    <a href="{{ route('upsos.index') }}">
                        <button class="{{  $upso_type == null ? 'top-menu-color' : 'bg-my-black' }} text-xs font-bold p-2 sm:py-3 sm:px-6 rounded-lg ml-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                        전체
                        </button>
                    </a>
                    @foreach ($upso_types as $item)
                        <a href="{{ route('upsos.index', ['upso_type_id'=> $item->id ]) }}">
                            <button class="{{ isset(  $upso_type ) &&  $upso_type->id == $item->id ? 'top-menu-color' : 'bg-my-black' }}  text-xs font-bold p-2 sm:py-3 sm:px-6 rounded-lg ml-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                            {{  $item->title  }}
                            </button>
                        </a>
                        
                    @endforeach
                </div>
            </div>
            
            <div>
                @include('upsos.regions', [
                    'upso_type_id' =>$upso_type_id,
                    'main_region_id' =>$main_region_id,
                    'region_id' =>$region_id,
                    'sub_regions'=>$sub_regions,
                ])
            </div>
        
            <div class="list-tsearch mt-4">
                <form method="GET" action="{{ route('upsos.index') }}"
                    class="form bg-blue-200 flex items-center justify-center"
                >
                    <input type="hidden" name="upso_type_id" value="{{ $upso_type_id }}" />
                    <input type="hidden" name="main_region_id" value="{{ $main_region_id }}" />
                    <input type="hidden" name="region_id" value="{{ $region_id }}" />

                    <div class="flex items-center justify-around my-2 sm:max-w-2xl text-center">
                        <div class="form-group">
                            <div class="form-group">
                                <x-jet.input value="{{ $search }}" type="text"  name="search" class="text-xs p-1" placeholder="업소입력" />
                            </div>
                        </div>
                        <div class="">
                            <div class="flex items-center justify-start">
                                <svg class="w-5 h-5 fill-current text-indigo-600 mx-2" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    viewBox="0 0 20 20">
                                    <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                </svg>
                                <button type="submit" class="btn btn-crimson btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            @include('upsos.partials.buttons-write-list')

            <div class="list-wrap">
                <x-upso-premium />

                @if( $upso_type_id )
                    <x-upso-premium-sub :upsotypeid="$upso_type_id"/>
                @endif 
                
                @include('upsos.partials.upsos-best', [
                    'upsos_best'=>$upsos_best,
                    'main_region_id' => $main_region_id,
                    'region_id' => $region_id,
                    'search'=> $search,
                ])
                
                @include('upsos.partials.upsos-normal', [
                    'upsos_normal'=>$upsos,
                    'main_region_id' => $main_region_id,
                    'region_id' => $region_id,
                    'search'=> $search,
                ])
        
            </div>
        </div>
        @include('upsos.partials.buttons-write-list')
    </div>
    

    
</x-layout>
