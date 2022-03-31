@if ($paginator->hasPages())
<nav class="wt-pagination wt-savepagination">
	<ul>
		@if ($paginator->onFirstPage())
		<li class="wt-prevpage disabled"><a href="javascrip:void(0);"><i class="fal fa-chevron-left"></i></a></li>
		@else
		<li class="wt-prevpage"><a href="{{ $paginator->previousPageUrl() }}"><i class="fal fa-chevron-left"></i></a></li>
		@endif

		@foreach ($elements as $element)

		    @if (is_string($element))
		        <li class="disabled"><a href="javascrip:void(0);">{{ $element }}</a></li>
		    @endif



		    @if (is_array($element))
		        @foreach ($element as $page => $url)
		            @if ($page == $paginator->currentPage())
		                <li class="wt-active"><a href="javascrip:void(0);">{{ $page }}</a></li>
		            @else
		                <li><a href="{{ $url }}">{{ $page }}</a></li>
		            @endif
		        @endforeach
		    @endif
		@endforeach

		@if ($paginator->hasMorePages())
		<li class="wt-nextpage"><a href="{{$paginator->nextPageUrl()}}"><i class="fal fa-chevron-right"></i></a></li>
		@else
		<li class="wt-nextpage disabled"><a href="javascrip:void(0);"><i class="fal fa-chevron-right"></i></a></li>
		@endif
	</ul>
</nav>
@endif