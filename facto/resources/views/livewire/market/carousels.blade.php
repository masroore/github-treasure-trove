<div>
    <div class="w-full flex flex-col md:flex md:flex-row md:items-start ">
        <img src="{{ Storage::url( $manager->thumb_path) }}" class="md:w-1/2 md:max-w-3xl self-center p-2" >
        <div class="md:w-1/2 md:mx-6">
            <div class="text-gray-500 text-sm p-2">다른 이미지 </div>
            <div class="w-full grid grid-cols-4 md:grid-cols-6 border border-gray-400">
                @foreach ($manager->all_images as $item)
                <div class="flex items-center align-middle">
                    <a href="{{ str_replace('//', '/', Storage::disk('public')->url( $item->org_path) ) }}" class='glightbox'>
                        <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $item->thumb_path) ) }}" 
                            class="object-cover" 
                        />
                        {{-- <div class="glightbox-desc ">
                            <div class="flex items-center justify-center text-bold">{{  $manager->name }}</div>
                        </div> --}}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // window.livewire.emit('load-more');
    // function carousels(){
    //     return {
    //         all_images : {!! json_encode($all_images ) !!},
    //         selected_id : null,
    //         path : {!!  json_encode($path) !!},
    //         binggle: 'test',
    //         openModal( image_id){
    //             Livewire.emit('setOpen', image_id);
    //         },
    //         get_image_src( thumb) {
    //             let url = this.path + '/' + thumb;
    //             return  url.replace(/\/\//g, '/');
    //         },
    //         get_image_url(all_images, image_id, path ){
    //             let url = path + all_images[ selected_id];
    //             return  url.replace(/\/\//g, '/');
    //         },
    //         changeSrc( new_image_id ){
    //             let url = window.path + window.images[ new_image_id];
    //             url = url.replace(/\/\//g, '/');
    //             document.getElementById('main_image').src= url ;
    //         }

    //     }
    // }
</script>