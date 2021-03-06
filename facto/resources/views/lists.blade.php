@extends('layouts.master')


@section('content')


@include('parts.banners')

<div class="px-1">
@include('parts.lists-best')
</div>


<div class="px-1">
    @include('parts.tags')
</div>



<div class="p-2 m-0 w-full">
        <div class="mt-1 flex flex-wrap items-start  justify-start ">
            @if ( $posts->count() > 0 )
            @foreach( $posts as $item)
            <div class=" w-1/2  sm:w-1/4 p-1 bg-white mb-3 mt-0 object-none object-top ">
                <div class=" rounded h-auto object-none object-top ">

                    <div class=" p-1 rounded rounded-lg  spect-4x3 object-top">
                        {{-- <a href="/posts/{{ $item->id}}?page={{ $page}}&tag_id={{ isset( $tag) ? $tag->id : -1 }}"> --}}
                        <a href="{{ route('posts.show', array_merge( ['post'=>$item ], request()->all() )  ) }}">
                        <img class=" hidden sm:block w-full object-cover rounded cursor-pointer "  style="min-height:100px; max-height:150px;"
                            src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
                            />
                            <img class="sm:hidden w-full object-cover rounded cursor-pointer "  style="min-height:100px; max-height:100px;"
                            src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
                            />        
                            </a>
                    </div>
                    
                    {{-- @include('parts.card-image', ['item'=>$item]) --}}
                    
                <div class=" flex flex-no-wrap h-12 text-base font-medium text-black  text-center my-2 px-1">

                        <div class="w-full flex-none cursor-pointer hover:text-red-600 ">
                                {{-- <a href="/posts/{{ $item->id}}?page={{ $page}}&tag_id={{ isset( $tag) ? $tag->id : -1 }}"> --}}
                            <a href="{{ route('posts.show', array_merge( ['post'=>$item ], request()->all() )  ) }}">
                                [{{ $item->cat->title }}]
                                {{ $item->title_short}} 
                            </a>
                        </div>
                </div>
                <div class="flex w-full items-center justify-between text-xs font-light text-gray-700 px-2">
                    <div class="">???????????????</div>
                    <div class=" flex mx-2 items-center">
                        <svg class="fill-current text-gray-500 mx-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" width="24" height="24">
                            <path class="heroicon-ui"
                                d="M2 15V5c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v15a1 1 0 0 1-1.7.7L16.58 17H4a2 2 0 0 1-2-2zM20 5H4v10h13a1 1 0 0 1 .7.3l2.3 2.29V5z" />
                        </svg>
                        <div class="mx-1">0</div>
                        <svg class="fill-current text-gray-500 mx-1  w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" width="24" height="24">
                            <path class="heroicon-ui"
                                d="M6 18.7V21a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2H7.1A7 7 0 0 0 19 12a1 1 0 1 1 2 0 9 9 0 0 1-15 6.7zM18 5.3V3a1 1 0 0 1 2 0v5a1 1 0 0 1-1 1h-5a1 1 0 0 1 0-2h2.9A7 7 0 0 0 5 12a1 1 0 1 1-2 0 9 9 0 0 1 15-6.7z" />
                        </svg>
                        <div class="mx-1"> {{ $item->visits }}</div>
                    </div>
                </div>
            </div>
    
        </div>
        @endforeach

    
        <div
            class=" w-full text-xs  flex items-center  justify-center   p-1 bg-white mb-3 font-medium text-gray-700 text-center ">
            {{ $posts->appends(request()->query())->links('vendor.pagination.tailwindcss') }}
        </div>
    
        @else
    
        <div class=" w-full p-1 bg-white mb-3 font-medium text-indigo-700 text-center">
            ?????? ???????????? ????????????.
        </div>
    
        @endif


        @include('parts.btns-search-orderby')

    
    </div>
    


@endsection