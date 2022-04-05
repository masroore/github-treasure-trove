@extends('layouts.master')


@section('content')


@include('parts.banners')

@include('parts.lists-best')

@include('parts.tags')

<div class="p-2 m-2 w-full">
        <div class="mt-1 flex flex-wrap items-center  justify-between ">
            @if ( $posts->count() > 0 )
            @foreach( $posts as $item)
            <div class=" w-1/2  sm:w-1/4 p-1 bg-white mb-3 ">
                <div class=" rounded h-auto  ">
                    @include('parts.card-image', ['item'=>$item])
                    {{-- <div class=" p-2 rounded rounded-lg ">
                            <img class="object-cover w-full sm:w-full rounded h-32 sm:h-48 " 
                                src="{{ config('app.env') === 'production' ? '/storage/' . $item->thumb_path : $item->thumb_path }}"
                    @click="goView('{{ $item->id }}')" />
                </div> --}}
                <div class=" flex flex-no-wrap text-base font-medium text-black  text-center my-2 px-1">

                        <div class="w-full flex-none cursor-pointer hover:text-red-600 ">
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
                        <div class="mx-1"> {{ $item->visits }}</div>
                    </div>
                </div>
            </div>
    
        </div>
        @endforeach
    
        <div
            class=" w-full text-xs  flex items-center  justify-center   p-1 bg-white mb-3 font-medium text-gray-700 text-center ">
            {{ $posts->links('vendor.pagination.tailwindcss-test') }}
        </div>
    
        @else
    
        <div class=" w-full p-1 bg-white mb-3 font-medium text-indigo-700 text-center">
            해당 데이터가 없습니다.
        </div>
    
        @endif
    </div>
    


@endsection