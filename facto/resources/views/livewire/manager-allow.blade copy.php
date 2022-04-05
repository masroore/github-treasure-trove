<div>
    <div>
        @include('managers.partials.allows', [
            'all_allowances'=> $all_allowances,
        ])
    </div>

    @include('managers.partials.buttons-write-list')
    
    <div class="list-tsearch mt-4">
        <form method="GET" action="{{ route('managers.index') }}"
            class="form bg-blue-200 flex items-center justify-center"
        >
            <input type="hidden" name="upso_type_id" value="{{ $upso_type_id }}" />
            <input type="hidden" name="main_region_id" value="{{ $main_region_id }}" />
            <input type="hidden" name="region_id" value="{{ $region_id }}" />

            <div class="flex items-center justify-around my-2 sm:max-w-2xl text-center">
                <div class="form-group">
                    <div class="form-group">
                        <x-jet.input value="{{ $search }}" type="text"  name="search" class="text-xs p-1" placeholder="매니저입력" />
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
    {{-- @json($allowances) --}}
    <p></p>
    {{-- {{  $cache_key }} --}}
    
    @include('managers.list-show',[
        'managers'=> $managers,
        'manager'=> $manager ?? null,
        'upso_type_id'=> $upso_type_id,
        'main_region_id'=> $main_region_id,
        'region_id'=> $region_id,
        'allowances'=> $allowances,

    ])
</div>
