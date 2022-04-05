<div x-data="popups()" x-init="init()" >
    @php
        $popup_titles = [
            '1xbet',
            '벳모아',
        ];
        $popup_links = [
            'https://bit.ly/3kpkPmq',
            'http://betmoa03.com/',
        ];

        $popup_images = [
            '/images/popups/Yagong Bonus_5000_320x220.gif',
            '/images/popups/betmoa1-320x220-2.gif',
        ];
    @endphp

    @if( isset( $popup_links[0]) )

    <div x-show="popupVisible[0]" class="sm:hidden popup-mobile ">
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[0] }}" target='_blank'>
                <img src="{{ $popup_images[0] }}" width="320" height="220" alt="{{ $popup_titles[0] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg" x-on:click="closePop(0,1)" > 4 시간동안 다시 열람하지 않습니다. </button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg " x-on:click="closePop(0,0)">닫기</button>
            </div>
        </div>
    </div>

    <div x-show="popupVisible[0]" class="hidden sm:block popup-pc ">
        <div class=" border border-gray-100 ">
            <a href="{{ $popup_links[0] }}"  target='_blank'>
                <img src="{{ $popup_images[0] }}"  width="320" height="220" alt="{{ $popup_titles[0] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" x-on:click="closePop(0,1)" > 4 시간동안 다시 열람하지 않습니다.</button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" x-on:click="closePop(0, 0)">닫기</button>
            </div>
        </div>
    </div>

    @endif 

    @if( isset( $popup_links[1]))
    <div x-show="popupVisible[1]" class="sm:hidden popup-mobile2 ">
        <div >
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[1] }}"  target='_blank'>
                <img src="{{ $popup_images[1] }}"  width="320" height="220" alt="{{ $popup_titles[1] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg" x-on:click="closePop(1, 1)" > 4 시간동안 다시 열람하지 않습니다. </button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg " x-on:click="closePop(1,0)">닫기</button>
            </div>
        </div>
        </div>
    </div>

    <div x-show="popupVisible[1]" class="hidden sm:block popup-pc2 ">
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[1] }}"  target='_blank'>
                <img src="{{ $popup_images[1] }}"  width="320" height="220" alt="{{ $popup_titles[1] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" x-on:click="closePop(1,1)" > 4 시간동안 다시 열람하지 않습니다.</button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" x-on:click="closePop(1,0)">닫기</button>
            </div>
        </div>
    </div>

    @endif 

    @if( isset( $popup_links[2]))

    <div x-show="popupVisible[2]" class="sm:hidden popup-mobile3 ">
        <div >
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[2] }}"  target='_blank'>
                <img src="{{ $popup_images[2] }}"  width="320" height="220" alt="{{ $popup_titles[2] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg" x-on:click="closePop(2,1)" > 4 시간동안 다시 열람하지 않습니다. </button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg " x-on:click="closePop(2, 0)">닫기</button>
            </div>
        </div>
        </div>
    </div>
    <div x-show="popupVisible[2]" class="hidden sm:block popup-pc3 ">
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[2] }}"  target='_blank'>
                <img src="{{ $popup_images[2] }}"  width="320" height="220" alt="{{ $popup_titles[2] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" x-on:click="closePop(2, 1)" > 4 시간동안 다시 열람하지 않습니다.</button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" x-on:click="closePop(2, 0)">닫기</button>
            </div>
        </div>
    </div> 
    @endif 

    @if( isset( $popup_links[3]))
    <div x-show="popupVisible[3]" class="sm:hidden popup-mobile4 ">
        <div >
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[3] }}"  target='_blank'>
                <img src="{{ $popup_images[3] }}"  width="320" height="220" alt="{{ $popup_titles[3] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg" x-on:click="closePop(3, 1)" > 4 시간동안 다시 열람하지 않습니다. </button>
            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg " x-on:click="closePop(3, 0)">닫기</button>
            </div>
        </div>
        </div>
    </div>

    <div x-show="popupVisible[3]" class="hidden sm:block popup-pc4 ">
        <div class="   border border-gray-100 ">
            <a href="{{ $popup_links[3] }}"  target='_blank'>
                <img src="{{ $popup_images[3] }}"  width="320" height="220" alt="{{ $popup_titles[3] }}"/>
            </a>
        </div>
        <div class="flex  bg-black p-2 items-center justify-between ">
            <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
                <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" x-on:click="closePop(3, 1)" > 4 시간동안 다시 열람하지 않습니다.</button>

            </div>
            <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
                <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" x-on:click="closePop(3, 0)">닫기</button>
            </div>
        </div>
    </div> 
    @endif
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
            
            closePop( i, hours) {
                if( hours == 0  ){
                    // close
                    this.popupVisible[i] = false;
                } else if( hours > 0 ){
                    var four_hour = new Date().addHours(4).getTime();
                    $cookies.set( this.cookie_key + i , four_hour );
                        // $cookies.set('popup_cookie1', four_hour, 60 * 60 * 4  );
                        this.popupVisible[i] = false;
                        

                }

            }

        }
    }
</script>