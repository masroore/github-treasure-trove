@foreach($items as $item)
    <li data-id="{{ $item->id }}">
    <span class="handle">
    <i class="fa fa-arrows"></i>
    </span>
        <span class="text">{{ $item->name }}</span>
        <span class="tools">
        @if($route_name_show)
            <a href="{{ route($route_name_show, $item) }}" target="_blank" class="text-success"><i class="fa fa-eye"></i></a>
        @endif
        @if($has_hierarchy)
            <a href="{{ route($route_name_create, array_merge(['parent_id' => $item->id], $route_additional_attrs)) }}" class="text-success"><i class="fa fa-plus-square-o"></i></a>
        @endif
{{--        <a href="{{ route($route_name_edit, $item) }}" class="text-warning"><i class="fa fa-edit"></i></a>--}}
        <a href="{{ route($route_name_edit, array_merge([$item], $route_additional_attrs)) }}" class="text-warning"><i class="fa fa-edit"></i></a>
        <a href="#" class="text-danger js-action-destroy" data-url="{{ route($route_name_delete, $item) }}"><i class="fa fa-trash-o"></i></a>
    </span>
        @if(! empty($item->children) && $item->children->count())
            <ul>
                @include('admin.fields.hierarchical.item', ['items' => $item->children])
            </ul>
        @elseif($has_hierarchy)
            <ul></ul>
        @endif
    </li>
@endforeach