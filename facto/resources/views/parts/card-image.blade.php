<div class=" p-1 rounded rounded-lg  spect-4x3 object-top">
        <a href="/posts/{{ $item->id}}?page={{ $page}}&tag_id={{ isset( $tag) ? $tag->id : -1 }}">
    <img class=" hidden sm:block w-full object-cover rounded cursor-pointer "  style="max-height:150px;"
        src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
         />
        <img class="sm:hidden w-full object-cover rounded cursor-pointer "  style="max-height:100px;"
        src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
         />        
        </a>
         {{-- @click="goView('{{ $item->id }}')" --}}
</div>
