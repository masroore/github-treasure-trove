@extends('admin.app')

@php
    $content_header = [
        'page_title' => $vocabulary->name,
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.terms.create', ['vocabulary' => $vocabulary->system_name])
    ]
@endphp

@section('content')
    <section class="content">
        @include('admin.fields.hierarchical.tree', [
            'terms' => $terms,
            'tree' => $tree,
            'has_hierarchy' => $vocabulary->options['has_hierarchy'] ?? 0,
            'box_title' => 'Список терминов',
            'entity_name' => 'term',
            'route_name_save_tree' => 'admin.terms.order',
            'route_name_edit' => 'admin.terms.edit',
            'route_name_create' => 'admin.terms.create',
            'route_name_delete' => 'admin.terms.destroy',
            'route_additional_attrs' => ['vocabulary' => $vocabulary->system_name],
        ])
    </section>
@stop