<div>
    @forelse ($upsos_best as $post)
        <a href="{{  route('upsos.show', [
                        'upso'=> $post, 
                        'upso_type_id'=>$upso_type_id,
                        'main_region_id'=> $main_region_id,
                        'region_id'=> $region_id,
                        'search'=> $search,
                    ]) }}" 
        >
            <div class="{{ isset( $upso) && $upso->id == $post->id ? 'bg-gray-400 border border-red-600': '' }} flex items-center justify-between shadow-md text-xs my-2 ">
                <div class="flex items-center justify-start">
                    <img src="{{ str_replace('//', '/', Storage::disk('public')->url($post->thumb_path) ) }}" class="w-24 h-20 sm:w-32 sm:h-24 mx-1">
                    <div class="">
                        <div class="flex my-1">
                            <div class="p-2 mx-1 w-24  top-menu-color-dark text-white rounded leading-none text-center">
                                {{  $post->upso_type->title }}
                            </div>
                            <div class="p-2 mx-1 w-32  top-menu-color-dark text-white rounded leading-none text-center">
                                {{  $post->region->title }}
                            </div>
                        </div>
                        <div class="flex w-48 my-1">
                            <div class="w-full p-2 mx-1 top-menu-color flex-grow upso-title text-white rounded leading-none text-center">
                                {{  $post->site_name }}
                            </div>
                        </div>
                        <div class="px-2 text-one-lines text-sm">
                            <div class="">
                                {{ $post->status =='Locked' ? '해당글은 잠긴상태입니다.' : $post->title }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-16 p-1 flex items-center justify-center">
                    <svg class="w-5 h-5 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                    <div class="text-xs mx-2"> {{ $post->visits }}</div>
                </div>
            </div>
        </a>
    @empty 
        {{-- <div class="text-center shadow-md text-base my-2 ">
                -
        </div> --}}
    @endforelse 
</div>