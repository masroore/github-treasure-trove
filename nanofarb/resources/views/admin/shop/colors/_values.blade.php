@php
    use App\Models\Shop\Attribute;
@endphp

@if($product->attrsAncestorsCategories()->count())
<div class="row">
    <div class="col-lg-4">
{{--        @dd($product->attrsAncestorsCategories()->where('purpose', Attribute::PURPOSE_FACET))--}}
        <div class="box box-warning box-solid">
            <div class="box-header with-border"><h3 class="box-title">Для фасетных фильтров</h3></div>
            <div class="box-body">
                @foreach($product->attrsAncestorsCategories()->where('purpose', Attribute::PURPOSE_FACET) as $attribute)
                    @include('admin.fields.field-select2-static', [
                        'label' => 'Значения атрибута "' . $attribute->title . '"',
                        'field_name' => 'values['.$attribute->id.']',
                        'multiple' => 1,
                        'max' => 20,
                        'disabled' => 0,
                        'required' => 0,
                        'attributes' => $attribute->values->pluck('value_suffix', 'id')->toArray(),
                        'selected' => isset($product) ? $product->values->pluck('id')->toArray() : [],
                        'old' => old('values')
                    ])
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box box-warning box-solid">
            <div class="box-header with-border"><h3 class="box-title">Для переключения вариантов</h3></div>
            <div class="box-body">
                @foreach($product->attrsAncestorsCategories()->where('purpose', Attribute::PURPOSE_CARD) as $attribute)
                    @include('admin.fields.field-select2-static', [
                        'label' => 'Значения атрибута "' . $attribute->title . '"',
                        'field_name' => 'values['.$attribute->id.']',
                        'multiple' => 1,
                        'max' => 1,
                        'disabled' => 0,
                        'required' => 1,
                        'attributes' => $attribute->values->pluck('value_suffix', 'id')->toArray(),
                        'selected' => isset($product) ? $product->values->pluck('id')->toArray() : [],
                        'old' => old('values')
                    ])
                @endforeach
            </div>
        </div>
    </div>
    {{--
    <div class="col-lg-4">
        <div class="box box-warning box-solid">
            <div class="box-header with-border"><h3 class="box-title">Комбинированные</h3></div>
            <div class="box-body">
                @foreach($product->attrsAncestorsCategories()->where('purpose', Attribute::PURPOSE_COMBINED) as $attribute)
                    @include('admin.fields.field-select2-static', [
                        'label' => 'Значения атрибута "' . $attribute->title . '"',
                        'field_name' => 'values['.$attribute->id.']',
                        'multiple' => 1,
                        'max' => 1,
                        'disabled' => 0,
                        'required' => 1,
                        'attributes' => $attribute->values->pluck('value_suffix', 'id')->toArray(),
                        'selected' => isset($product) ? $product->values->pluck('id')->toArray() : [],
                        'old' => old('values')
                    ])
                @endforeach
            </div>
        </div>
    </div>
    --}}
    <div class="col-lg-6">
    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.products.create', ['product_group_id' => isset($product) ? $product->product_group_id : null]),
    'url_store_and_close' => session('admin.products.index'),
    'url_destroy' => isset($product) ? route('admin.products.destroy', $product) : '',
    'url_after_destroy' => session('admin.products.index'),
    'url_close' => session('admin.products.index'),
])

@else
    @include('admin.fields.empty-rows', [
       'msg_title' => 'Нет заданных атрибутов для категорий товара!',
       'msg_body' => 'Создайте / задайте атрибуты для категории товара.',
       //'url_create' => '#',
    ])
@endif