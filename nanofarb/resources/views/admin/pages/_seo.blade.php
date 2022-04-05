@include('admin.seo.meta-tags.inc.entity-field-form', [
    'model' => $model,
])

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.pages.create'),
    'url_store_and_close' => session('admin.pages.index'),
    'url_destroy' => isset($model) ? route('admin.pages.destroy', $model) : '',
    'url_after_destroy' => session('admin.pages.index'),
    'url_close' => session('admin.pages.index'),
])
