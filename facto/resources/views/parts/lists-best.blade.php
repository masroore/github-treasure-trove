<div class="w-full sm:flex my-2">
        <div class="p-1 m-0 w-full sm:w-1/2 ">
            <div class="flex  items-center w-full ">
                <div class="text-xs text-black font-semibold ">주간 베스트</div>
                <div class="flex-grow h-1 bg-gray-300 px-2 py-1 mx-2"></div>
            </div>
    
            <div class="mt-4 w-full">
                @foreach( $posts_week as $item)
                <div class="flex items-center w-full px-2" onClick="goview({{ $item->id }} )">
                    <button class="f-color-green text-white font-bold my-1 px-2   size-10">
                        {{ $loop->index + 1 }}
                    </button>
                    <div class="flex-grow ml-1 text-xs cursor-pointer hover:text-red-600">
                        [{{ $item->cat->title }}] {{ $item->title_long }}
                    </div>
                    <div class=" pr-2 text-xs text-gray-700"> {{ \Carbon\Carbon::parse( $item->created_at )->format('m-d') }}</div>
                </div>
                @endforeach 
            </div>
        </div>
    
        <div class="p-1  w-full sm:w-1/2 ">
            <div class="flex  items-center w-full ">
                <div class="text-xs text-black font-semibold ">월간 베스트</div>
                <div class="flex-grow h-1 bg-gray-300 px-2 py-1 mx-2"></div>
            </div>
    
            <div class="mt-4 w-full">
                @foreach( $posts_month as $item)
                <div class="flex items-center w-full px-2" onClick="goview({{ $item->id }} )">
                    <button class="f-color-red text-white font-bold my-1 px-2   size-10">
                        {{ $loop->index + 1 }}
                    </button>
                    <div class="flex-grow ml-1 text-xs cursor-pointer hover:text-red-600 ">
                        [{{ $item->cat->title }}] {{ $item->title_long }} 
                    </div>
                    <div class=" pr-2 text-xs text-gray-700"> {{ \Carbon\Carbon::parse( $item->created_at )->format('m-d') }}</div>
                </div>
                @endforeach 
            </div>
        </div>
    </div>
    
    <script>
        function goview( id) {
            document.location.href ='/posts/' + id 
        }
    </script>
    
    