<main class=" flex flex-1  flex-wrap justify-between -mx-2 px-2 py-4">

    @foreach ($products as $product)
    <div class="flex flex-col card  mb-2 " style=" width:325px">
        @if(isset($product->featured_img))
        <div class="mx-auto text-center">
            <img class="w-auto rounded-lg object-cover object-centre w-full" src={{ $product->featured_img }} style="height:325px" alt="<{{ $product->title }}>">
        </div>
        @endif
        <div class=" card mt-2 text-center">
            <h1 class="text-xl font-semibold p-2">{{ $product->title }}</h1>
        </div>
        <div class="flex flex-col justify-between ">
            <div class="flex-1 h-auto ">
                <p class=" mt-4">{{ substr($product->description ,0,100) }}
                    <a class="text-blue-900 font-extrabold no-underline" href="{{ $url = action('ProductController@show', $product->id) }}">... more <i class="fas fa-angle-double-right"></i></a></p>
            </div>

            <div class="">
            </div>

            <div>
                <p>Published {{ $product->published_date }}</p>
            </div>
        </div>
    </div>
    @endforeach
</main>