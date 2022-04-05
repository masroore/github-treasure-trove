@foreach($subcategories as $subcategory)
    -
    @if(count($subcategory->parentCat->categories))
        @include('product::category.hierarchy',['subcategories' => $subcategory->categories])
    @endif
@endforeach
