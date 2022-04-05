@php
    use App\Models\Shop\Attribute;
@endphp

@foreach($products as $product)
    @include('front.products.inc.single-product', ['product' => $product])
@endforeach