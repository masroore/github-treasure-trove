<div>
    <div x-data="popups()" x-init="init()" >
        @foreach ($popups as $popup)
        <div x-show="popupVisible[ {{ $loop->index }}]" class="sm:hidden {{ 'popup-mobile' . $loop->index }}">
            <div >
            <div class=" border border-gray-100 ">
                <a href="{{ $popup->link }}"  target='_blank'>
                    <img src="{{ $popup->file_name }}"  width="320" height="220" alt="{{ $popup->title }}"/>
                </a>
            </div>
            <div class="flex  bg-black p-2 items-center justify-between ">
                <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                    <button class="bg-black w-full px-1 py-1 rounded-lg" x-on:click="closePop( {{ $loop->index }}, 1)" > 4 시간동안 다시 열람하지 않습니다. </button>
                </div>
                <div class="w-1/4 bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                    <button class="bg-black text-white px-2 py-1 rounded-lg " x-on:click="closePop({{ $loop->index }},0)">닫기</button>
                </div>
            </div>
            </div>
        </div>
    
        <div x-show="popupVisible[ {{ $loop->index }}]" class="hidden sm:block {{ 'popup-pc' . $loop->index }} ">
            <div class="   border border-gray-100 ">
                <a href="{{ $popup->link }}"  target='_blank'>
                    <img src="{{ $popup->file_name }}"  width="320" height="220" alt="{{ $popup->title }}"/>
                </a>
            </div>
            <div class="flex  bg-black p-2 items-center justify-between ">
                <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                    <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" x-on:click="closePop( {{ $loop->index }},1)" > 4 시간동안 다시 열람하지 않습니다.</button>
    
                </div>
                <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                    <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" x-on:click="closePop( {{ $loop->index }},0)">닫기</button>
                </div>
            </div>
        </div>
        
        @endforeach
    
         
    </div>
    <script>
        function popups(){
            return {
                popupVisible : [],
                cookie_key : 'popup-',
                init() {
                    this.popupVisible = Array.apply(null, Array(4)).map(function (x, i) { return false ; })
    
                    for( const [ i, value] of this.popupVisible.entries() ) {
                        var now = new Date() ;
                        now = now.getTime();
                        var timeSaved = $cookies.get( this.cookie_key + i ) ;
                        if( timeSaved == null ||  now > parseInt( timeSaved ) ) {
                            this.popupVisible[i] = true;
                        } else {
                            this.popupVisible[i] = false;
                        }
                    }
                },
                
                closePop( ii, hours) {
                    if( hours == 0  ){
                        // close
                        this.popupVisible[ii] = false;
                    } else if( hours > 0 ){
                        console.log(this.cookie_key + ii);
                        var four_hour = new Date().addHours(4).getTime();
                        $cookies.set( this.cookie_key + ii , four_hour );
                        // $cookies.set('popup_cookie1', four_hour, 60 * 60 * 4  );
                        this.popupVisible[ii] = false;
                    }
    
                }
    
            }
        }
    </script>

</div>