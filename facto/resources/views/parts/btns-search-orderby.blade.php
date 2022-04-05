<div >
    <div x-data="search_section()"  x-cloak>    
        @php 
            $url = url()->full();
            $path = parse_url($url, PHP_URL_PATH);
            $queries = parse_url($url, PHP_URL_QUERY);
            parse_str($queries, $output);
            $output['page'] = 1  ;

            $output['orderBy'] = ''  ;
            $new_url1 =  $path . '?' . http_build_query($output);

            $output['orderBy'] = 'created_at'  ;
            $new_url2 =  $path . '?' . http_build_query($output);

            $output['orderBy'] = 'visits'  ;
            $new_url3 =  $path . '?' . http_build_query($output);
        @endphp 

        <div x-show="orderByBox" class="relative z-10 flex items-center -mt-16 w-full h-16 justify-end mb-0 mr-1 ">
            <div class=" bg-gray-800 text-xs text-white" >
                <div class="m-1 px-3" ><a href="{{ $new_url1 }}">초기화</a></div>
                <div class="m-1 px-3" ><a href="{{ $new_url2 }}">날짜순</a></div>
                <div class="m-1 px-3" ><a href="{{ $new_url3 }}">조회순</a></div>
            </div>
        </div>
        {{-- @include('parts.search-modal') --}}
    {{-- <Transition name="search"> --}}
    
        <div class="flex items-center  w-full justify-between p-1 text-white">
            <div class=" flex items-center justify-betwwen bg-gray-800 text-xs py-1 px-3"
                x-on:click="search_modal=!search_modal">
                    <svg class=" w-3 h-3 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                    </svg>
                    <div class=" ml-3" >검색</div>
            </div>
            <div class=" bg-green-300">
                <div class="bg-gray-800 text-xs py-1 px-3" id="btnOrderByBox" 
                    x-on:click="orderByBox = !orderByBox "
                >정렬</div>
                
            </div>
        </div>
        <div x-show="search_modal" class="fixed inset-0 w-full h-full flex items-center justify-center bg-semi-75 pr-3"
            x-on:click.self="closeSearchModal">

            <form name="frmsearch" action="/posts" method="GET" class="">
                <input type="hidden" name="cat_id" value="{{ $cat->id }}">
                <div class=" w-full h-56 bg-white rounded-lg m-3 ">
                    <div class="flex w-full ">
                        <div class="w-10/12"></div>
                        <button aria-label="close" class="w-2/12  text-xl text-gray-500 " 
                            x-on:click.prevent="closeSearchModal"
                        >
                            ×
                        </button>
                    </div>

                    <div class="w-full flex items-center justify-center mb-5">
                        <svg class="  w-4 h-4 fill-current text-black text-lg" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                        </svg>
                        <div class="text-lg font-semibold mx-3">Search</div>
                    </div>
                    <div class="flex w-full px-2">
                        <select class=" flex-1 text-xs border border-black p-2 m-2" name="condition1">
                            <option value="title">제목</option>
                            <option value="content">내용</option>
                            <option value="all">제목+내용</option>
                        </select>
                        <select class=" flex-1  text-xs border border-black p-2 m-2" name="condition2">
                            <option value="and">그리고</option>
                            <option value="or">또는</option>
                        </select>
                    </div>
                    <div class="flex w-full px-2">
                        <input type="text" name="search" class="w-full py-1 px-4 m-2 border border-gray-800 rounded text-xs "
                            placeholder="검색어">
                    </div>

                    <div class="flex w-full px-2 ">
                        <button type="submit"
                            class=" flex-1 button bg-red-600 text-sm text-white hover:bg-red-700 m-2 px-4  py-1">검색</button>
                        <button class=" flex-1 button bg-gray-700 text-sm text-white hover:bg-gray-900 m-2 px-4 py-1"
                            x-on:click="search_modal = ! search_modal"
                        >닫기</button>
                    </div>

                </div>
            </form>
        </div>

    </div>
    {{-- </Transition> --}}
    <script>
        function search_section(){
            return {
                search_modal : false, 
                orderByBox : false ,
                closeSearchModal() {
                    this.search_modal = false;
                },
                setOrderByBoxPosition(){
                    this.orderByBox = ! this.orderByBox;
                    var orderByBox = document.querySelector('#btnOrderByBox');
                    console.log( orderByBox.offsetTop);
                }

            }
        }

    </script>




</div>