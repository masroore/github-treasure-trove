
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
        <url>
            @if (in_array($page->slug, ['o-nama', 'kontakt']))
                <loc>{{ route('page', ['cat' => $page->slug]) }}</loc>
                <changefreq>yearly</changefreq>
                <priority>1.0</priority>
            @else
                @if (isset($page->subcat->parent))
                    <loc>{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}</loc>
                @else
                    <loc>{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}</loc>
                @endif
                <priority>0.9</priority>
                <changefreq>monthly</changefreq>
            @endif
            <lastmod>{{ $page->updated_at }}</lastmod>
        </url>
    @endforeach
</urlset>
