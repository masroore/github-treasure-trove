
@if ($paginator->hasPages())
    @php 

$min = $paginator->currentPage() - 2 ;
$max = $paginator->currentPage() + 2 ;
    
if ($paginator->hasMorePages() ) {

    $next_page_url = $paginator->nextPageUrl();
    $path = parse_url($next_page_url, PHP_URL_PATH);
    $queries = parse_url($next_page_url, PHP_URL_QUERY);
    parse_str($queries, $output);
    $output['page'] = $paginator->lastPage() ;
    $last_page_url =  $path . '?' . http_build_query($output);
    $output['page'] = 1  ;
    $first_page_url =  $path . '?' . http_build_query($output);

} else {
    $last_page_url = null;
    $next_page_url = $paginator->previousPageUrl();
    $path = parse_url($next_page_url, PHP_URL_PATH);
    $queries = parse_url($next_page_url, PHP_URL_QUERY);
    parse_str($queries, $output);
    $output['page'] = 1 ;
    $first_page_url =  $path . '?' . http_build_query($output);
    
}



    @endphp 
    <div class="flex items-center">
        {{-- Previous Page Link --}}
        <a class="rounded-l rounded-sm border border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-xs " href="{{ $first_page_url }}" rel="first">
            {{-- &laquo; --}}
            <<
        </a>

        @if ($paginator->onFirstPage())
        
            <span class="rounded-l rounded-sm border border-brand-light px-3 py-2 no-underline text-xs ">
                <
                {{-- &laquo; --}}
            </span>
        @else
        

            <a
                class="rounded-l rounded-sm border-t border-b border-l border-brand-light px-3 py-2 text-brand-dark hover:bg-brand-light no-underline text-xs "
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
            >
            <
                {{-- &laquo; --}}
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            

                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="border-t border-b border-l border-brand-light px-3 py-2 cursor-not-allowed no-underline text-sm ">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ( $page >= $min && $page <= $max ) 
                            @if ($page == $paginator->currentPage())
                                <span class="border-t border-b border-l border-brand-light px-3 py-2 bg-brand-light no-underline text-sm  text-red-600 ">{{ $page }}</span>
                            @else
                                <a class="border-t border-b border-l border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-sm " href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endif             
                    @endforeach
                @endif
            
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="rounded-r rounded-sm border border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-xs " href="{{ $paginator->nextPageUrl() }}" rel="next">
                {{-- &rang;   --}}
                >
            </a>
        @else
            {{-- <span class="rounded-r rounded-sm border border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-sm  cursor-not-allowed">&raquo;</span> --}}
        @endif

        @if( $last_page_url == null )
        {{-- <a class="rounded-r rounded-sm border border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-sm  " href="{{ $last_page_url }}">&raquo;</a> --}}
        @else 
            <a class="rounded-r rounded-sm border border-brand-light px-3 py-2 hover:bg-brand-light text-brand-dark no-underline text-xs  " href="{{ $last_page_url }}">
                >>
            </a>

        @endif 
        

    </div>
@endif