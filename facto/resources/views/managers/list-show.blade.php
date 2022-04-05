<div class="grid grid-cols-2 sm:grid-cols-4 gap-1 ">
    @if( $managers->count() > 0 )
    @forelse ($managers as $item)
        <a href="{{  route('managers.show', [
                'manager'=> $item,
                'upso_type_id'=> $upso_type_id,
                'main_region_id'=>$main_region_id,
                'region_id'=>$region_id,
                'allowances'=>$allowances,

            ]) }}" 
            class="{{ isset( $manager) && $manager->id == $item->id ? 'bg-gray-300': '' }} border-2 {{ $colors[ $item->upso->upso_type->id - 1] }} rounded-md flex flex-col justify-start "
        >
            <div class="w-full h-auto p-1 flex flex-col items-center p-1">
                <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $item->thumb_path) ) }}"  class="object-cover w-full h-48">
            </div>
            <div class="py-1 px-2 text-black font-normal text-sm"> 
                <div class="flex items-center justify-between">
                    <div class=""><span class="text-gray-600 text-sm">이름</span> {{  $item->name }}</div>
                    <div class=""><span class="text-gray-600 text-sm">국적</span>  {{  $item->cc }}</div>
                </div>
                <div class=""><span class="text-gray-600 text-sm">업종</span>  {{  $item->upso->upso_type->title }}</div>
                <div class=""><span class="text-gray-600 text-sm">지역</span>  {{  $item->upso->region->title }}</div>
                <div class=""><span class="text-gray-600 text-sm">업소명</span>  {{  $item->upso->site_name }}</div>
                <div class="flex items-center justify-between">
                    <div class="w-1/2"><span class="text-gray-600 text-sm">나이</span>  {{  $item->age }}</div>
                    <div class="w-1/2"><span class="text-gray-600 text-sm">키</span>  {{  $item->ht }}</div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="w-1/2"><span class="text-gray-600 text-sm">몸무게</span> {{  $item->wt }}</div>
                    <div class="w-1/2"><span class="text-gray-600 text-sm">가슴</span> {{  $item->bsize }}</div>
                </div>
                <div class="">
                    <span class="text-gray-600 text-sm">가능서비스</span> 
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-1">
                        @foreach ($item->allowances->pluck('title')->toArray() as $allowance)
                            <div class="{{ $colors[ $item->upso->upso_type->id - 1] }} text-xx p-1 w-full text-center border rounded-sm">
                                {{ $allowance }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="w-full p-2 text-center bg-red-200 col-span-2 sm:col-span-6">
            등록된 매니저가 없습니다.
        </div>
    @endforelse

    @endif

</div>

<div class="w-full flex items-center justify-center my-4">
    <div
        wire:click="loadMore" 
        wire:loading.class.remove="bg-my-black" 
        wire:loading.class="top-menu-color"
        wire:loading.attr="disabled"
        class="w-48 text-center bg-my-black  text-white rounded text-base px-4 py-2">
        더보기..
    </div>
</div>