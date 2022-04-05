@extends('layouts.master')
@section('content')


@include('parts.banners')

@include('parts.lists-best')


<div class="p-1 mt-5 mb-0 ">
    <div class="text-lg font-semibold text-blue-800">[{{ $post->cat->title }}] {{ $post->title}}</div>
</div>
<div class=" flex items-center justify-between border-t border-b bg-gray-100 text-sm p-2 ">
        <div class="flex w-full items-center justify-between text-xs font-light text-gray-700 px-2">
            <div class="flex">
                <div class="">{{ $post->user->name }}</div>
                <div class=" flex mx-2 items-center" >
                    <svg class="fill-current text-gray-500 mx-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path class="heroicon-ui" d="M2 15V5c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v15a1 1 0 0 1-1.7.7L16.58 17H4a2 2 0 0 1-2-2zM20 5H4v10h13a1 1 0 0 1 .7.3l2.3 2.29V5z"/>
                    </svg>
                    <div class="mx-1"> 0 </div>
                    
                    <svg class="fill-current text-gray-500 mx-1  w-4 h-4"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                    </svg>
                    <div class="mx-1">{{ $post->visits }}</div>

                    
                </div>
            </div>
            <div class="flex items-center ">
                    <svg class="fill-current text-gray-600 mx-1  w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.59V4h2v5.59l3.95 3.95-1.41 1.41L9 10.41z"/>
                    </svg>
                    <div class="mx-1 text-red-600"> {{ \Carbon\Carbon::parse( $post->created_at)->locale('ko_KR')->diffForhumans() }}</div>
            </div>
        </div>
        
</div>


<div class="p-1 mb-5 ">
    
        @include('parts.banners-2')

    <div class="relative aspect-16x9 mt-8 " >
        {{-- <iframe src="{{ env('APP_DEV') == 'TEST'? '':  $post->outlink1 }}" class="absolute w-full h-full border border-indigo-400"></iframe> --}}
        <iframe src="{{   $post->embed }}" class="absolute w-full h-full border border-indigo-400 w-48" ></iframe>
    </div>
    <div class="font-normal text-gray-800 text-sm self-center mt-2">[ {{ $post->cat->title }} ] {{ $post->title }}</div>
</div>

@include('parts.banners-3')

<div class="p-1 my-2">
    <div class="flex items-center p-2">
            <svg class="w-3 h-3 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
            </svg>
            <div class="text-sm text-gray-600 ">
            {{ implode( ", " , $post->tags->pluck('name')->all() )}}
            </div>
    </div>
</div>

<div class="p-1 mt-2 mb-8   ">
    <div class="float-right flex items-center justify-between bg-gray-900 text-white text-sm py-1 px-2">
        <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M0 3h20v2H0V3zm0 4h20v2H0V7zm0 4h20v2H0v-2zm0 4h20v2H0v-2z"/>
        </svg>
        <div class="ml-2"><a href='/posts?cat_id={{ $post->cat->id }}'>목록</a></div>
    </div>
</div>

{{-- @include('parts.tags') --}}
{{-- // tags 적용 --}}

<div class="w-full mx-0 my-2 border border-gray-400 ">
    <ul class="flex border-b ">
        <li class="-mb-px mr-1">
            <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-red-600 font-medium text-sm"
                href="#">카테고리</a>
        </li>
        <li class="mr-1">
        </li>
    </ul>
    <div class="flex flex-wrap ">
        @foreach( $tags as $item )
        <div class="flex-initial mr-2">
            <div class="text-gray-700 text-center p-2 text-xs font-light {{ isset( $tag) &&  $tag->id == $item->id ? 'text-red-500': '' }} ">
                <a href ='/posts/{{ $post->id}}?&tag_id={{$item->id}}'>
                    {{ $item->name }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div> 


{{-- // list again  --}}
<div class="p-2 m-2 w-full">
    <div class="mt-1 flex flex-wrap items-center  justify-between ">
        @if ( $posts->count() > 0 )
        @foreach( $posts as $item)
        <div class=" w-1/2  sm:w-1/4 p-1 bg-white mb-3 ">
            <div class=" rounded h-auto  ">
                {{-- @include('parts.card-image', ['item'=>$item]) --}}

                <div class=" p-1 rounded rounded-lg  spect-4x3">
                        <a href="/posts/{{ $item->id}}?page={{ $page}}&tag_id={{ isset( $tag) ? $tag->id : -1 }}">
                            <img class=" hidden sm:block w-full object-cover rounded  cursor-pointer "  style="max-height:150px;"
                                src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
                                 />

                            <img class="sm:hidden w-full object-cover rounded  cursor-pointer "  style="max-height:100px;"
                                src="{{ env('APP_DEV') === 'TEST' ? '/storage/' . $item->thumb_path : '/'. $item->thumb_path }}"
                                />       
                                
                    </a>
                </div>

                <div class=" flex flex-no-wrap text-base font-medium text-black  text-center my-2 px-1 ">
                        <div class="w-full flex-none  cursor-pointer hover:text-red-600">
                                <a href="/posts/{{ $item->id}}?page={{ $page}}&tag_id={{ isset( $tag) ? $tag->id : -1 }}">
                                [{{ $item->cat->title }}]
                                {{ $item->title_short}} 
                                </a>
                        </div>
                </div>
                <div class="flex w-full items-center justify-between text-xs font-light text-gray-700 px-2">
                    <div class="">최고관리자</div>
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
                        <div class="mx-1"> {{ $item->visits }} </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach

        <div
            class=" w-full text-xs  flex items-center  justify-center   p-1 bg-white mb-3 font-medium text-gray-700 text-center ">
            {{ $posts->links('vendor.pagination.tailwindcss') }}
        </div>

        @else

        <div class=" w-full p-1 bg-white mb-3 font-medium text-indigo-700 text-center">
            해당 데이터가 없습니다.
        </div>

        @endif
    </div>
</div>


@endsection