<div class="mt-1 flex flex-wrap items-center  justify-center ">
    @php 


    $all_menus = [
        ['key' => 'upso', 'title' =>'업소정보', 'type'=>'gallery','link'=>'/upsos', 'src' => '/img/upso.jpg' ],
        ['key' => 'manager', 'title' =>'매니저정보', 'type'=>'gallery','link'=>'/managers', 'src' => '/img/managers.jpg' ],

        ['key' => 'kr', 'title' =>'한국야동', 'type'=>'gallery' ,'link'=>'/posts?cat_id=1', 'src' => '/img/kr-111.jpg' ],
        ['key' => 'jp', 'title' =>'일본야동', 'type'=>'gallery','link'=>'/posts?cat_id=2', 'src' => '/img/jp-111.jpg' ],
        ['key' => 'asia', 'title' =>'동양야동', 'type'=>'gallery','link'=>'/posts?cat_id=3', 'src' => '/img/dy-111.jpg' ],
        ['key' => 'western', 'title' =>'서양야동', 'type'=>'gallery','link'=>'/posts?cat_id=4', 'src' => '/img/xy-111.jpg' ],
        
        /* ['key' => 'torrent', 'title' =>'av토렌트', 'type'=>'outlink','link'=>'https://yaburi02.com/posts-index/19', 'src' => '/img/avtorrent.jpg' ], */
        // ['key' => 'torrent', 'title' =>'av토렌트', 'type'=>'alert','link'=>'준비중입니다.', 'src' => '/img/avtorrent.jpg' ],

        ['key' => 'suresite', 'title' =>'야동공장 보증업체', 'type'=>'outlink','link'=>'https://htsbet599.com/?ref=6666', 'src' => '/images/htsbet777-3.gif' ],

        ['key' => 'bbs', 'title' =>'고객센터', 'type'=>'dropdown','link'=>'/customers?ccat_id=1', 'src' =>'' ],
        
        ['key' => 'broadcast', 'title' =>'스포츠중계', 'type'=>'outlink','link'=>'http://betmoa04.com', 'src' => '/images/betmoa-menu.gif' ],
        // ['key' => 'bet', 'title' =>'섹스만남', 'type'=>'outlink', 'link'=>'https://il119.com/09381351-e493-4a54-8261-e81c469f3bc7?source=yagong&placement=256x163&banner=KR-256X163-20-VMP10-SUGJ1S', 'src' => '/images/meeting3.jpg' ],
        ['key' => 'quest', 'title' =>'1:1문의', 'type'=>'list-password', 'link'=>'/customers?ccat_id=1', 'src' => '' ],
        ['key' => 'banner', 'title' =>'광고문의', 'type'=>'list-password', 'link'=>'/customers?ccat_id=2', 'src' => '' ],
    ];


    $colors = ['blue', 'red', 'green', 'orange' ];
    $i = -1;
    @endphp 
    @foreach( $all_menus as $menu)
        @if( $menu['type']== 'gallery' || $menu['type'] =='outlink' || $menu['type'] =='torrent' )
            @php
            
                if( $i == 3 ) {
                    $i = -1 ;
                } 
                $link =  $menu['link'];
                $src = $menu['src'];
                $title = $menu['title'];
                $i++;
                $color = 'bg-' . $colors[$i] . '-500';
                
            @endphp

            <div class=" w-1/2  sm:w-1/4  p-2 bg-white ">
                @if($menu['type'] == 'outlink')
                    <a href ="{{$link}}" target='_blank'>
                        <div class="{{ $color }} rounded h-auto cursor-pointer " >
                            <div class="p-2 rounded rounded-lg">
                                <img class="object-cover rounded " 
                                    src="{{ $src }}"
                                >
                            </div>
                            <div class="text-lg text-white font-semibold text-center pt-1 pb-3 " 
                            >{{ $title }}</div>
                        </div>
                    </a>

                @else 
                    @if( Str::startsWith( $link , 'http'))
                        <div class="{{ $color }} rounded h-auto cursor-pointer " 
                        >
                            <a href="{{ $link }}" target='blank'>
                                <div class="p-2 rounded rounded-lg">
                                    <img class="object-cover rounded " 
                                        src="{{ $src }}"
                                    >
                                </div>
                                <div class="text-lg text-white font-semibold text-center pt-1 pb-3 " 
                                >{{ $title }}</div>
                            </a>
                        </div>

                    @else 
                        <div class="{{ $color }} rounded h-auto cursor-pointer " 
                        >
                            <a href="{{ $link }}" >
                                <div class="p-2 rounded rounded-lg">
                                    <img class="object-cover rounded " 
                                        src="{{ $src }}"
                                    >
                                </div>
                                <div class="text-lg text-white font-semibold text-center pt-1 pb-3 " 
                                >{{ $title }}</div>
                            </a>    
                        </div>


                    @endif 
                    
                @endif 


            </div>
        @elseif( $menu['type']== 'alert' )
            @php
                if( $i == 3 ) {
                    $i = -1 ;
                } 
                $link =  $menu['link'];
                $src = $menu['src'];
                $title = $menu['title'];
                $i++;
                $color = 'bg-' . $colors[$i] . '-500';
                
            @endphp

            <div class=" w-1/2  sm:w-1/4  p-2 bg-white ">
                <a href ="javascript:alert('준비중입니다.');">
                    <div class="{{ $color }} rounded h-auto cursor-pointer " >
                        <div class="p-2 rounded rounded-lg">
                            <img class="object-cover rounded " 
                                src="{{ $src }}"
                            >
                        </div>
                        <div class="text-lg text-white font-semibold text-center pt-1 pb-3 " 
                        >{{ $title }}</div>
                    </div>
                </a>
            </div>
        @endif 
    @endforeach

</div>

