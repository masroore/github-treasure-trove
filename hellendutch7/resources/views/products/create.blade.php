<x-layout.app>
    @section('title', 'Create a new Product')

<x-layout.pageheader />

    <div class="container mx-auto">
        <div class="p-6 rounded shadow lg:w-1/2 lg:mx-auto bg-card md:py-12 md:px-16">
            <h1 class="mb-10 text-2xl font-normal text-center">
                New Product
            </h1>

            <form method="POST" action="/product">
                @include ('products.form', [
                'product' => new App\Models\Product,
                'buttonText' => 'Save'
                ])
            </form>
        </div>
    </div>

</x-layout.app>