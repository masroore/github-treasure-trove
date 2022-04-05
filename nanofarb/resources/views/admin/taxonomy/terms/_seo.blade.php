@include('admin.seo.meta-tags.inc.entity-field-form', [
    'model' => $model,
])

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.terms.create'),
    'url_store_and_close' => session('admin.terms.index'),
    'url_destroy' => isset($model) ? route('admin.terms.destroy', $model) : '',
    'url_after_destroy' => session('admin.terms.index'),
    'url_close' => session('admin.terms.index'),
])
