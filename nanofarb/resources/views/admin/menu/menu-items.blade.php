@extends('admin.app')

@php
    $content_header = [
        'page_title' => $menu->name,
        'small_page_title' => '',
        'url_back' => route('admin.menu.index'),
        'url_create' => route('admin.menu-items.create', ['menu_id' => $menu->id])
    ]
@endphp

@section('content')
    <section class="content">
        @include('admin.fields.hierarchical.tree', [
            'terms' => $menuLinks,
            'tree' => $tree,
            'has_hierarchy' => $menu->data['has_hierarchy'] ?? 1,
            'box_title' => 'Список пунктов меню',
            'entity_name' => 'term',
            'url_create_root' => route('admin.menu-items.create', ['menu_id' => $menu->id]),
            'route_name_save_tree' => 'admin.menu-items.order',
            'route_name_edit' => 'admin.menu-items.edit',
            'route_name_create' => 'admin.menu-items.create',
            //'route_name_show' => 'admin.menu-items.show',
            'route_name_delete' => 'admin.menu-items.destroy',
            'route_additional_attrs' => ['menu_id' => $menu->id],
        ])
    </section>
@stop