<x-layout >
    <script src="https://hammerjs.github.io/dist/hammer.js"></script>

    <link rel="stylesheet" href="/vendor/glightbox/dist/css/glightbox.min.css">
    <style>
        .gslide-list{
            background-color:white;
            height:3rem;
            position: fixed;
            bottom:0 ;
            width:100%;    
        }
    </style>

    <div>
        <link rel="stylesheet" href="/css/upso.css?v=13">
            
        <x-common.top-title menu='매니저정보' mode='보기' />

        <div class="p-1 mt-5 mb-0  flex items-center justify-start">
            <div class="text-lg font-semibold text-blue-800 mx-2">{{ $manager->name }} <span class="text-red-600">[ {{  $upso->upso_type->title }} ][ {{ $upso->region->title }} ]</span></div>
            <div class="mx-2">
                <button
                    type="button"
                    class="border border-indigo-500 bg-my-black text-white rounded-lg px-2 py-1 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
                >
                <a href="{{ route('upsos.show', ['upso'=> $upso ]) }}">
                    예약하러가기
                </a>
                </button>
            </div>
        </div>
        <div class=" flex items-center justify-between border-t border-b bg-gray-100 text-sm p-2 ">
            <div class="flex w-full items-center justify-between text-xs font-light text-gray-700 px-2">
                <div class="flex">
                    <div class="">{{ $upso->user->nick }}</div>
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
                        <div class="mx-1">{{ $manager->visits }}</div>
                    </div>
                </div>

                <div class="flex items-center ">
                    <svg class="fill-current text-gray-600 mx-1  w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.59V4h2v5.59l3.95 3.95-1.41 1.41L9 10.41z" />
                    </svg>
                    <div class="mx-1 text-red-600">
                        {{ \Carbon\Carbon::parse( $manager->created_at)->locale('ko_KR')->diffForhumans() }}</div>
                </div>
            </div>
        
        </div>

        <div class="p-1 mb-5 ">
            <div class="font-normal text-gray-800 text-sm self-center mt-2">
                [ {{ $upso->upso_type->title  }} ] <span class="text-red-600">[ {{ $upso->region->title }} ]</span>
            </div>
        </div>
        
        <div class="p-1 my-2">
            <div class="flex items-center p-2">
                <svg class="w-3 h-3 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                </svg>
            </div>
            <div class="flex items-center p-2  flex flex-col items-start " >
                
                    @livewire('market.carousels', [ 'manager_id' => $manager->id ])
                
                <div class="w-full p-2">
                    <div class=" flex items-center justify-start">
                        <div class="flex-1 w-1/2 flex items-center justify-start">
                            <div class="text-gray-600 text-xs p-2">이름</div>
                            <div class="text-black text-base p-2">{{ $manager->name }}</div>
                        </div>

                        <div class="flex-1 w-1/2 flex items-center justify-start">
                            <div class="text-gray-600 text-xs p-2">국적</div>
                            <div class="text-black text-base p-2">{{ $manager->cc }}</div>
                        </div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">+금액</div>
                        <div class="text-black text-base p-2">{{ number_format( $manager->price ) }} </div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">업종</div>
                        <div class="text-black text-base p-2">{{ $upso->upso_type->title }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">지역</div>
                        <div class="text-black text-base p-2">{{ $upso->region->title }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">업소명</div>
                        <div class="text-black text-base p-2">{{  $upso->site_name }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">예약문의</div>
                        <div class="text-black text-base p-2">{{  make_phone($upso->phone ) }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">나이</div>
                        <div class="text-black text-base p-2">{{ $manager->age }}</div>
                    </div>

                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">키</div>
                        <div class="text-black text-base p-2">{{ $manager->ht }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">몸무게</div>
                        <div class="text-black text-base p-2">{{ $manager->wt }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">가슴사이즈</div>
                        <div class="text-black text-base p-2">{{ $manager->bsize }}</div>
                    </div>
                    <div class=" flex items-center justify-start">
                        <div class="text-gray-600 text-xs p-2">가능서비스</div>
                    </div>
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-1">
                        @foreach ($manager->allowances->pluck('title')->toArray() as $allowance)
                            <div class="{{ $colors[ $manager->upso->upso_type->id - 1] }} text-xs p-1 w-full text-center border rounded-md">
                                {{ $allowance }}
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <div class="text-gray-600 text-xs p-2">소개</div>
                        <div class="text-black text-base p-2 text-center">
                            {!!  strip_tags( $manager->content, '<img><p><br><div>') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        @include('managers.partials.buttons-delete-edit-write')
        
        <div class="my-4 ">.</div>
        <x-common.top-title menu='매니저정보' mode='리스트' />

        @livewire('managers-list', [
            'upso_type_id' => $upso_type_id,
            'main_region_id' => $main_region_id,
            'region_id' => $region_id,
            ])
        {{-- <div>
            <div class="flex items-center justify-around  sm:justify-around mt-2 mb-6">
                <div class="flex items-center justify-around">
                    <a href="{{ route('managers.index') }}">
                        <button class="{{  $upso_type == null ? 'top-menu-color' : 'bg-my-black' }} text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                        전체
                        </button>
                    </a>
                    @foreach ($upso_types as $item)
                        <a href="{{ route('managers.index', ['upso_type_id'=> $item->id ]) }}">
                            <button class="{{ isset(  $upso_type ) &&  $upso_type->id == $item->id ? 'top-menu-color' : 'bg-my-black' }}  text-xs font-bold py-2 px-2 sm:py-3 sm:px-6 rounded-lg mx-1 my-2 sm:mx-4  cursor-pointer text-white font-semibold  border rounded-md text-center ">
                            {{  $item->title  }}
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                @include('managers.regions', [
                    'upso_type_id' =>$upso_type_id,
                    'main_region_id' =>$main_region_id,
                    'region_id' =>$region_id,
                    'sub_regions'=>$sub_regions,
                    'allowances'=>$allowances,
                ])
            </div>

            @livewire('manager-allow', [
                'upso_type_id' => $upso_type_id, 
                'main_region_id' => $main_region_id, 
                'region_id' => $region_id,
                'allowances'=> $allowances,
                'search'=> $search,
                'manager'=> $manager,
                ])
        </div>
        <div class="md:hidden">
            @include('upsos.partials.floating-phone')
        </div>
    </div> --}}

    

    <script src="https://cdn.jsdelivr.net/npm/animejs@3.1.0/lib/anime.min.js"></script>
    {{-- <script src="demo/js/valde.min.js"></script> --}}
    <script src="/vendor/glightbox/dist/js/glightbox.js?v={{ now() }}"></script>

    <script>
        // const customLightboxHTML = `<div id="glightbox-body" class="glightbox-container">
        //     <div class="gloader visible"></div>
        //     <div class="goverlay"></div>
        //     <div class="gcontainer">
        //     <div id="glightbox-slider" class="gslider"></div>
        //     <button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
        //     <button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
        //     <button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
        // </div>
        // <div class="bg-white fixed bottom-0 right-0" > 123456789</div>
        // </div>`;


        let customSlideHTML = `<div class="gslide">
            <div class="gslide-inner-content">
                <div class="ginner-container">
                    <div class="gslide-media">
                    </div>
                    <div class="gslide-description">
                        <div class="gdesc-inner">
                            <h4 class="gslide-title"></h4>
                            <div class="gslide-desc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        var lightbox = GLightbox({
            // lightboxHTML: customLightboxHTML,
            // slideHtml: customSlideHTML,
            // skin: 'supercool'
        });

        var lightboxDescription = GLightbox({
            selector: '.glightbox2',
        });
        var lightboxVideo = GLightbox({
            selector: '.glightbox3',
            afterSlideLoad: (data) => {
                console.log(data);
            },
            afterSlideChange: (prevSlide, currentSlide) => {
                // prevSlide is the previously active slide
                // currentSlide is the active slide
                // the player variable can be false if slide has no video

                const { index, slide, player } = currentSlide;

                if (player) {

                    if (!player.ready) {
                        // If player is not ready
                        player.on('ready', event => {
                            // Do something when video is ready
                        });
                    }

                    player.on('play', event => {
                        console.log("Started play");
                    });

                    player.on('volumechange', event => {
                        console.log("Volume change");
                    });

                    player.on('ended', event => {
                        console.log("Video ended");
                    });
                }
            }
        });
        var lightboxInlineIframe = GLightbox({
            'selector': '.glightbox4'
        });


        /* var exampleApi = GLightbox({ selector: null });
        exampleApi.insertSlide({
            href: 'https://picsum.photos/1200/800',
        });
        exampleApi.insertSlide({
            width: '500px',
            content: '<p>Example</p>'
        });
        exampleApi.insertSlide({
            href: 'https://www.youtube.com/watch?v=WzqrwPhXmew',
        });
        exampleApi.insertSlide({
            width: '200vw',
            content: document.getElementById('inline-example')
        });
        exampleApi.open(); */
    </script>
    
</x-layout>
