@include('admin.seo.meta-tags.inc.entity-field-form', [
    'model' => $model,
])

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.products.create'),
    'url_store_and_close' => session('admin.products.index'),
    'url_destroy' => isset($model) ? route('admin.products.destroy', $model) : '',
    'url_after_destroy' => session('admin.products.index'),
    'url_close' => session('admin.products.index'),
])
