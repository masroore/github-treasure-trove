<x-layout.app>

    @section('og_meta')
    <x-products.product_meta :product=$product />
    @endsection

    @section('addstyles')
    <script src="{{url('js/dropzone.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/dropzone.css')}}">
    @endsection

    @section('title', 'Piece Details')


    <x-layout.pageheader />

    <div class="container pb-4 mx-auto">
        <div class="flex flex-col items-center justify-around mt-12">

            @if(isset($product->featured_img))
            <div class="flex items-center justify-center w-2/3 max-w-md mb-4 card">
                <img class="object-cover p-4 object-centre " src="{{URL::asset( $product->featured_img)}}">
            </div>
            @endif

            <div class="w-2/3 card">
                <div class="mb-4">
                    <h1 class="pb-2 text-2xl font-semibold text-center text-base-700"> {{ $product->title }}</h1>
                    <p class="pb-4"> {!! nl2br($product->description) !!}</p>

                    <x-dashboard.pricing :product="$product" />

                    <div class="block mb-4">
                        <span class="text-gray-700">Categories</span>
                        <div class="mt-2">
                            <div class="flex flex-wrap ">
                                @foreach($product->categories as $existing)
                                <div class="mr-1 font-semibold">
                                    <a href="/bycategory/ {{ $existing->id }} ">
                                        {{ $existing->category }},</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <div class="flex-1 text-sm">
                        <p><a class="no-underline" href="{{ $url = '/' }}"><i class="fas fa-backward"></i> Back</a></p>
                    </div>
                    @auth
                    <div class="mr-4 text-sm">
                        <p><a class="no-underline" href="{{ $url = action('ProductController@edit', $product->id) }}"><i class="far fa-edit"></i> Edit</a></p>
                    </div>
                    <div class="text-sm">
                        <form method="POST" action="{{ $product->path() }}" class="text-right">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="text-sm"><i class="far fa-trash-alt"></i> Delete</button>
                        </form>
                    </div>
                    @endauth
                </div>


                <main class="flex flex-wrap py-4 -mx-2">
                    @forelse($images as $image)
                    <div class="w-1/3 px-2 py-2">
                        <div class="flex-1 overflow-hidden card">
                            <img class="object-cover w-full rounded object-centre" src="{{$image->getUrl('thumb')}}" alt="Thumbnail is Missing here">
                            <div class='flex justify-between'>
                                @auth
                                <a href="/images/{{$product->id}}/{{$image->id}}/delete"><i class="fas fa-trash"></i></a>
                                <a href="/images/{{$product->id}}/{{$image->id}}/featured"><i class="fas fa-bolt"></i></a>
                                @endauth
                                <a href="{!! Route('images.show',$image->id) !!}"><i class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="mx-2 card"> No Pictures Yet</div>
                    @endforelse


                </main>
                @auth
                    <livewire:images.upload :product="$product" />
                @endauth
            </div>

        </div>

    </div>

</x-layout.app>