<div class="col-md-12">
    <nav class="nav">
        @foreach($laravelAdminMenus->menus as $item)
        	@if( $item->status =="1" )
            	<a class="nav-link" href="{{ url($item->url) }}">{{ $item->title }}</a>
            @endif
        @endforeach
    </nav>
</div>
