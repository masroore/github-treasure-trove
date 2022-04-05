@if($item->children->count() && Menu::hasAccessToTreeview($item))
    <li class="treeview @if(Menu::isTreeviewOpen($item))menu-open @endif">
        <a href="{{ $item->getUrl() ?: '#' }}" {{ $item->getTargetStr() }}>
            <i class="@empty($item->data['icon']) fa fa-circle-o text-green @else {{ $item->data['icon'] }} @endempty"></i>
            <span>{{ $item->name }}</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu" @if(Menu::isTreeviewOpen($item))style="display: block;" @endif>
            @foreach($item->children as $itemCh)
                @include('admin.layouts.sidebar-menu.menu-item', ['item' => $itemCh])
            @endforeach
        </ul>
    </li>
@elseif(! empty($item->data['header']))
    <li class="header">{{ $item->name }}</li>
@elseif(Menu::hasAccessToItem($item))
    <li class="@if(Menu::isActive($item))active @endif">
        <a href="{{ $item->getUrl() ?: '' }}" {{ $item->getTargetStr() }}>
            <i class="@empty($item->data['icon']) fa fa-circle-o text-green @else {{ $item->data['icon'] }} @endempty"></i>
            <span>{{ $item->name }}</span>
            {!! Menu::suffix($item) !!}
        </a>
    </li>
@endif