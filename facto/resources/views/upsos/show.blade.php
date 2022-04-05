<x-layout >
    <div class="max-w-full">
        <link rel="stylesheet" href="/css/upso.css?v=12">
        <div class="px-1">
            {{-- @include('parts.lists-best') --}}
        </div>
        
        {{-- <x-common.top-title menu='업소정보' mode='보기' /> --}}
        
        <div>
            <div class=" sm:hidden ">
                <div class="flex ml-2">
                    <div class="border-b-2 border-teal-600 my-1 pb-1 font-semibold ">
                        {{ $upso->upso_type->title  }} : {{ $upso->site_name }} 
                    </div>
                    <div class=" flex-grow border-b border-gray-400 my-1 px-2 font-semibold ">
                        <span class="text-red-600 text-sm">[ {{ $upso->region->title }} ]</span>
                    </div>
                </div>
            </div>
                
            <div class="hidden sm:block sm:flex sm:items-end sm:content-end justify-between p-2 m-1 w-full">
                <div class="flex items-center justify-start">
                    <div class="border-b-2 border-red-500 text-lg font-medium">
                        {{ $upso->upso_type->title  }} : {{ $upso->site_name }}  
                    </div>
                    <div class=" flex-grow border-b border-gray-400 my-1 px-2 font-semibold ">
                        <span class="text-red-600 text-sm">[ {{ $upso->region->title }} ]</span>
                    </div>
                </div>
                <div class="flex-grow  border-b border-gray-400 flex justify-end items-center  text-right  align-baseline ">
                    <svg class="hidden sm:block w-3 h-3 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z" />
                    </svg>
                    <span class="hidden sm:block  text-xs text-gray-700 px-2">
                        홈 > {{ $upso->upso_type->title  }} > {{  $upso->site_name }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-1 mt-3 mb-0 ">
            @if( $upso->status =='Locked')
                (잠금 상태입니다.)
            @else 
                <div class="text-lg font-semibold text-blue-800">
                    {{  $upso->title  }}
                </div>
            @endif
        </div>
        <div class=" flex items-center justify-between border-t border-b bg-gray-100 text-sm p-2 ">
            <div class="flex w-full items-center justify-between text-xs font-light text-gray-700 px-2">
                <div class="flex">
                    <div class="">{{ $upso->user->name }}</div>
                    <div class=" flex mx-2 items-center">
                        <svg class="fill-current text-gray-500 mx-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" width="24" height="24">
                            <path class="heroicon-ui"
                                d="M2 15V5c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v15a1 1 0 0 1-1.7.7L16.58 17H4a2 2 0 0 1-2-2zM20 5H4v10h13a1 1 0 0 1 .7.3l2.3 2.29V5z" />
                        </svg>
                        <div class="mx-1"> 0 </div>
        
                        <svg class="fill-current text-gray-500 mx-1  w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                        </svg>
                        <div class="mx-1">{{ $upso->visits }}</div>
                    </div>
                </div>

                <div class="flex items-center ">
                    <div>
                        <button
                            type="button"
                            class="border border-indigo-500 bg-my-black text-white rounded-lg px-2 py-1 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
                        >
                        <a href="{{ route('managers.list', ['upso_id'=> $upso->id ]) }}">
                            매니저 정보
                        </a>
                        </button>

                    </div>
                    <svg class="fill-current text-gray-600 mx-1  w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.59V4h2v5.59l3.95 3.95-1.41 1.41L9 10.41z" />
                    </svg>
                    <div class="mx-1 text-red-600">
                        {{ \Carbon\Carbon::parse( $upso->created_at)->locale('ko_KR')->diffForhumans() }}</div>
                </div>
            </div>
        
        </div>

        <div class="p-1 mb-5 ">

            {{-- @include('parts.banners-2') --}}
        
            <div class="font-normal text-gray-800 text-sm self-center mt-2">{{ $upso->site_name }} [ {{ $upso->upso_type->title  }} ] <span class="text-red-600">[ {{ $upso->region->title }} ]</span> </div>
        </div>
        
        {{-- @include('parts.banners-3') --}}
        

    <style>
        .view-wrap img {
            display: block;
            margin-left: auto;
            margin-right: auto
        }
    </style>
        <div class="view-wrap p-1 my-2">
            @if( $upso->status =='Locked')
                <div class="w-full h-56 grid place-items-center">
                    해당글은 잠긴상태입니다.
                </div>
                @auth
                    @if( Auth::user()->isAdmin() )
                        <div>
                            <div class="w-full h-24 grid place-items-center font-bold ">
                                원본내용 ..
                            </div>
                            <div class="flex items-center p-2">
                                <svg class="w-3 h-3 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                </svg>
                            </div>
            
                            <div class="flex items-center p-2  flex flex-col items-start w-full" >
                                @if( $upso->thumb_path)
                                <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $upso->thumb_path) ) }}" class=" md:max-w-3xl self-center p-2 object-cover" >
                                @endif
            
                                <div class="w-full flex flex-col ">
                                    @foreach ($upso->all_images as $item)
                                        <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $item->thumb_path) ) }}" class="md:max-w-3xl self-center p-2 object-cover" >
                                    @endforeach
                                </div>
                                <div class="p-2 text-center">
                                    {!!  $upso->content  !!}
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
                


            @else 
                <div class="flex items-center p-2">
                    <svg class="w-3 h-3 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                    </svg>
                </div>

                <div class="flex items-center p-2  flex flex-col items-start w-full" >
                    @if( $upso->thumb_path)
                    <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $upso->thumb_path) ) }}" class=" md:max-w-3xl self-center p-2 object-cover" >
                    @endif

                    <div class="w-full flex flex-col ">
                        @foreach ($upso->all_images as $item)
                            <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $item->thumb_path) ) }}" class="md:max-w-3xl self-center p-2 object-cover" >
                        @endforeach
                    </div>
                    <div class="p-2 text-center">
                        {!!  $upso->content  !!}
                    </div>

                    <div class="p-2 text-center">
                        <img src="/images/upsos/upso-bottom-yagong.png" class="" />
                    </div>
                </div>
            @endif
        </div>
        
        <div class="p-1 mt-2 mb-8   ">
            <div class="float-right flex items-center justify-between bg-gray-900 text-white text-sm py-1 px-2">
                <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M0 3h20v2H0V3zm0 4h20v2H0V7zm0 4h20v2H0v-2zm0 4h20v2H0v-2z" />
                </svg>
                <div class="ml-2"><p href='/posts?cat_id={{ $upso->upso_type->id }}'>목록</p></div>
            </div>
        </div>
        
        @include('upsos.partials.buttons-delete-edit-write')
        
        <div class="my-4 ">.</div>

        {{-- @livewire('upso-page', ['upso_type_id' => $upso->upso_type_id]) --}}

        <x-common.top-title menu='업소정보' mode='리스트' />
        
        
        <div>

            <x-upso-premium />

            @if( $upso_type_id )
            <x-upso-premium-sub :upsotypeid="$upso_type_id"/>
        @endif 
        
                
            <div class="flex items-center justify-around  sm:justify-around mt-2 mb-6">
                <div class="flex items-center justify-around">
                    <a href="{{ route('upsos.index') }}">
                        <button class="{{  $upso_type == null ? 'top-menu-color' : 'bg-my-black' }} text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                        전체
                        </button>
                    </a>
                    @foreach ($upso_types as $item)
                        <a href="{{ route('upsos.index', ['upso_type_id'=> $item->id ]) }}">
                            <button class="{{ isset(  $upso_type ) &&  $upso_type->id == $item->id ? 'top-menu-color' : 'bg-my-black' }}  text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
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
        
            <div class="list-wrap">
                @include('upsos.partials.upsos-best', [
                    'upso'=>$upso,
                    'upsos_best'=>$upsos_best,
                    'upso_type_id'=>$upso_type_id,
                    'main_region_id' => $main_region_id,
                    'region_id' => $region_id,
                    'search'=> $search,
                ])
                
                @include('upsos.partials.upsos-normal', [
                    'upso'=>$upso,
                    'upsos_normal'=>$upsos,
                    'upso_type_id'=>$upso_type_id,
                    'main_region_id' => $main_region_id,
                    'region_id' => $region_id,
                    'search'=> $search,
                ])
        
            </div>
        </div>
    
        <div class="md:hidden">
            @include('upsos.partials.floating-phone')
        </div>

    </div>

    

</x-layout>
