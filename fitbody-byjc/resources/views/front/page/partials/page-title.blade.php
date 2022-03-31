<section id="page-title" class="bgcolor page-title-dark" style="background-image: url({{ asset('media/images/titlebg.jpg') }}); height: 200px;">
    <div class="container clearfix" style="padding-top: 17px;">
        @if (isset($cat))
            <h1>{{ isset($subcat) ? $subcat->name : $cat->name }}</h1>
            <span>{{ config('app.longname') }}</span>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                @if (isset($subcat))
                    <li class="breadcrumb-item"><a href="{{ route('page', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @if (isset($page))
                        <li class="breadcrumb-item"><a href="{{ route('page', ['cat' => $cat->slug, 'subcat' => $subcat->slug]) }}">{{ $subcat->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($page->name, 70) }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $subcat->name }}</li>
                    @endif
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($subcat) ? $subcat->name : $cat->name }}</li>
                @endif
            </ol>
        @else
            <h1>{{ config('app.longname') }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
            </ol>
        @endif
    </div>
</section>
