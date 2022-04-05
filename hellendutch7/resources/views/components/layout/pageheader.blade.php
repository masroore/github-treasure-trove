@props(['cat' => ''])

<div class="bg-gray-200">
    <div class="container mx-auto md:px-0 px-4">
        <div class="flex justify-between text-center md:text-left  py-2  text-xl">
            @if (\Route::current()->getName() == 'bycategory')
            <div class="class='w-1/3' -mb-2 pb-2 font-bold  min-w-0 border-b-4 border-pink-600">
                <p class="text-grey-dark"> Artwork By Category - {{ $cat->category }}</p>
            </div>
            @else
            <div class="class='w-1/3' -mb-2 pb-2 font-bold  min-w-0 border-b-4 border-pink-600">
                <p class="text-grey-dark"> @yield('title') </p>
            </div>
            @endif

            @if ( \Route::current()->getName() !== 'root')
            <div class=" mr-2 -mb-2 pb-2 font-bold  min-w-0  ">
                <a href="{{ url('/') }}" class="my-2 font-semibold hover:font-bold no-underline"><i class="fas fa-arrow-circle-left"></i> Home</a>
            </div>
            @endif
        </div>
    </div>
</div>