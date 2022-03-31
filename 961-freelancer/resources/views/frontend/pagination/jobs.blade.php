@if ($paginator->hasPages())
<div class="row">
	<div class="col-md-12">
		<!-- Pagination -->
		<div class="pagination-container mt-3 mb-5">
			<nav class="pagination justify-content-center">
				<ul>
					@if ($paginator->onFirstPage())
					<li class="pagination-arrow"><a href="#"><i class="fal fa-chevron-left"></i></a></li>
					@else
					<li class="pagination-arrow"><a href="{{ $paginator->previousPageUrl() }}"><i class="fal fa-chevron-left"></i></a></li>
					@endif

					@foreach ($elements as $element)

					    @if (is_string($element))
					        <li class="disabled"><a href="javascrip:void(0);">{{ $element }}</a></li>
					    @endif


					    @if (is_array($element))
					        @foreach ($element as $page => $url)
					            @if ($page == $paginator->currentPage())
					                <li><a href="javascrip:void(0);" class="current-page">{{ $page }}</a></li>
					            @else
					                <li><a href="{{ $url }}">{{ $page }}</a></li>
					            @endif
					        @endforeach
					    @endif
					@endforeach

					
					@if ($paginator->hasMorePages())
					<li class="pagination-arrow"><a href="{{$paginator->nextPageUrl()}}"><i class="fal fa-chevron-right"></i></a></li>
					@else
					<li class="pagination-arrow"><a href="#"><i class="fal fa-chevron-right"></i></a></li>
					@endif
				</ul>
			</nav>
		</div>
	</div>
</div>
@endif