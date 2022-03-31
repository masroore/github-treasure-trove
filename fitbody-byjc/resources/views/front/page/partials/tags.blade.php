@if ($page->slug != 'kontakt' && ! empty($page->meta_keywords))
    <div class="tagcloud clearfix bottommargin-sm topmargin-sm">
        @foreach (explode(',', $page->meta_keywords) as $keyword)
            <a href="{{ route('index', ['trazi' => $keyword]) }}">{{ $keyword }}</a>
        @endforeach
    </div>
@endif
