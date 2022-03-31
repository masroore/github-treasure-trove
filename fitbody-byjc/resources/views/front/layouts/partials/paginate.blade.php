@if ($paginator->hasPages())


    <div class="row pagination-holder topmargin-sm">
        <div class="col-sm-12 text-center pagination-navigation ">
            <ul class="pagination pagination-rounded justify-content-center pagination-lg">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item">
                        <a  class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">«</span></a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">«</span></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item"><a class="page-link" href="javascript:void(0)">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"  href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link"  href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">»</span></a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link"  href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">»</span></a>
                    </li>
                @endif
             </ul>
        </div>
    </div>
@endif



