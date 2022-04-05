<div class="w-full my-4 border border-gray-400">
        <ul class="flex border-b ">
            <li class="">
                <a class="bg-white inline-block border-l  border-r rounded-t py-2 px-4 text-red-600 font-medium text-sm"
                    href="#">카테고리</a>
            </li>
            <li class="mr-1">
            </li>
        </ul>
        <div class="flex flex-wrap ">
            @foreach( $tags as $item )
    
            <div class="flex-initial pr-2">
                <div class="text-gray-700 text-center px-2 py-1 mb-1 text-xs font-light {{ isset( $tag) &&  $tag->id == $item->id ? 'text-red-500': '' }} ">
                    <a href ='/posts?cat_id={{ isset($post) && isset( $post->cat) ? $post->cat->id : $cat->id }}&tag_id={{$item->id}}'>
                        {{ $item->name }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div> 