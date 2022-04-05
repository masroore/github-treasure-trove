<div class="box">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">{{ $box_title ?? 'Список терминов таксономии' }} ({{ $terms->count() }})</h3>
        <div class="pull-right box-tools">
            <button
                    type="button"
                    data-route="{{ isset($route_name_save_tree) ? route($route_name_save_tree) : '#' }}"
                    data-entity-name="{{ $entity_name ?? 'term' }}"
                    class="post-tree-sortaple btn btn-success btn-sm ajax"
                    data-widget="add"
                    data-toggle="tooltip"
                    title="Сохранить">
                <i class="fa fa-save"></i>
            </button>
            {{--
            &nbsp;
            <ul class="pagination pagination-sm inline">
                <li class="active">
                    <a href="#">RU</a>
                </li>
                <li>
                    <a href="#">UA</a>
                </li>
            </ul>
            --}}
        </div>
    </div>
    <div class="box-body">

        @unless($terms->count())
            @include('admin.fields.empty-rows', ['url_create' => isset($url_create_root) ? ($url_create_root) : '#'])
        @else
            <ul class="todo-list tree-sortable" data-entity-name="{{ $entity_name ?? 'term' }}">
                @include('admin.fields.hierarchical.item', [
                    'items' => $tree,
                    'has_hierarchy' => $has_hierarchy ?? 0,
                    'route_name_show' => $route_name_show ?? '',
                    'route_additional_attrs' => $route_additional_attrs ?? []
                ])
            </ul>
        @endif
    </div>
</div>

{{--
@include('admin.fields.hierarchical.tree', [
    'terms' => $terms,
    'tree' => $tree,
    'has_hierarchy' => $vocabulary->options['has_hierarchy'] ?? 0,
    'box_title' => 'Список терминов',
    'entity_name' => 'term',
    'route_name_save_tree' => 'admin.terms.order',
    'route_name_edit' => 'admin.terms.edit',
    'route_name_create' => 'admin.terms.create',
    //'route_name_show' => 'admin.menu-items.show',
    'route_name_delete' => 'admin.terms.destroy',
    'route_additional_attrs' => ['vocabulary' => $vocabulary->system_name],
])
--}}
