@if(($menuItems = \App\Models\Menu\MenuItem::byMenu('admin_menu')->get()) && ($menuItems->count()))
<ul class="sidebar-menu" data-widget="tree">
    @foreach($menuItems->toTree() as $item)
        @include('admin.layouts.sidebar-menu.menu-item', ['item' => $item])
    @endforeach
</ul>
@endif