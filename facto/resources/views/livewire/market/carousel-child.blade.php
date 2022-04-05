<div>
    <div class="z-10 relative w-screen h-screen bg-purple-400">
        <div class="grid grid-cols-12  md:grid-cols-16 gap-0">
            {{-- <div 
                class="fixed top-0 right-0 text-2xl flex items-center justify-center align-middle"
            > 
                <svg class="cursor-pointer w-10 h-10 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/>
                </svg>
            </div> --}}
            <div class="col-span-10 md:col-span-14 bg-red-300">
                <div class="w-full h-auto flex items-center justify-center bg-green-300" id="myElement" >
                    {{-- <img :src="previewUrl" 
                        class="object-cover rounded-lg" id="main_image"
                    > --}}
                    <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $selected_img->org_path) ) }}" 
                        class="object-cover rounded-lg max-w-screen max-h-screen" id="main_image"
                    >
                </div>
            </div>
            {{-- <div 
                class="text-2xl flex items-center justify-center align-middle"
            > 
                <svg class="cursor-pointer w-10 h-10 fill-current text-gray-700 "  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/>
                </svg>
            </div> --}}
        </div>
        <div class="flex flex-no-wrap items-center justify-center flex-none whitespace-no-wrap overflow-x-auto">
            {{-- <template x-for="(images, index) in items" :key="index">
                <div x-text="index"></div>
            </template> --}}

            {{-- <template x-for="(thumb, index) in all_images" :key="index">
                <div x-text="index"></div>
            </template> --}}

            @foreach ($all_images as $item)
            <div class="flex-none w-12 h-12 p-1 ">
                <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $item->thumb_path) ) }}" 
                    class="max-h-screen object-cover w-10 h-10 rounded-full {{ $image_id == $item->id ? 'border-4 border-red-500 opacity-50' : ' cursor-pointer ' }}" 
                >
            </div>
            @endforeach
        </div>
    </div>
</div>




{{-- <script>
 
    var images = {!! json_encode($all_images->pluck('org_path', 'id')) !!};
    var selected_id = {!!  json_encode($selected_img->id) !!};
    var path = {!!  json_encode($path) !!};

    console.log(images);
    console.log( selected_id)
    console.log( images[selected_id])
    console.log( path)

    function get_image_url(images, image_id, path ){
        let url = path + images[ selected_id];
        return  url.replace(/\/\//g, '/');
    }

    function changeSrc( new_image_id ){
        // var main_image = document.getElementById('main_image');
        // main_image.src = get_image_url( images, new_image_id, path)
        let url = window.path + window.images[ new_image_id];
        url = url.replace(/\/\//g, '/');
        document.getElementById('main_image').src= url ;
    }
    // get_image_url( images, selected_id, path  )

    function setImageId( id){
        changeSrc(id);
    }

    function doNext(){
        var main_image = document.getElementById('main_image');
        var classesToAdd = ['transform', '-translate-x-full',  'transition-transform', 'duration-1000', 'ease-in-out', 'opacity-50', 'transition-opacity' ];
        main_image.classList.add( ...classesToAdd);
        setTimeout( function(){
            window.state = 1 ;
            @this.call('goNext');
        },1000)
    }

    function doPrev(){
        var main_image = document.getElementById('main_image');
        var classesToAdd = ['transform', 'translate-x-full', 'transition-transform', 'duration-1000', 'ease-in-out' ,'opacity-50', 'transition-opacity'];
        main_image.classList.add( ...classesToAdd);
        setTimeout( function(){
            window.state = 1 ;
            @this.call('goPrev');
        },1000)
    }

    var state = 1; 
    var myElement = document.getElementById('myElement');
    var mc = new Hammer(myElement);
    console.log( 'state before =', state );

    // listen to events...
    mc.on("panleft panright", function(ev) {
        if( window.state  =='undefined') {
            window.state  = 1;
        }
        console.log( 'state =', window.state );
        if( window.state == 0 ){
            return false;
        } 
        window.state = 0;

        var main_image = document.getElementById('main_image');
        console.log( ev.type)
        if( ev.type =='panleft') {
            // ,'opacity-25', 'transition-opacity'
            var classesToAdd = ['transform', '-translate-x-full',  'transition-transform', 'duration-1000', 'ease-in-out', 'opacity-50', 'transition-opacity' ];
            main_image.classList.add( ...classesToAdd);
            setTimeout( function(){
                window.state = 1 ;
                // @this.call('goNext');
            },700)
            
            
        } else if( ev.type =='panright'){
            var classesToAdd = ['transform', 'translate-x-full', 'transition-transform', 'duration-1000', 'ease-in-out' ,'opacity-50', 'transition-opacity'];
            main_image.classList.add( ...classesToAdd);
            setTimeout( function(){
                window.state = 1 ;
                // @this.call('goPrev');
            },700)
        }

        console.log(ev.type +" gesture detected." + new Date() );
        
        // myElement.textContent = ev.type +" gesture detected.";
    });

    function changeImage( current_id, driection){
        document.getElementById("myImg").src = "hackanm.gif";
        
    }
</script> --}}
