<header id="header">
    <div id="header-wrap">
        <div class="container clearfix">
            <div id="side-panel-trigger" class="side-panel-trigger d-block d-sm-none" style="left: 36px;"><i class="icon-reorder"></i></div>
            {{--<div id="side-panel-trigger"><a href="#"><i class="icon-reorder"></i></a></div>--}}
            <!-- Logo -->
            <div id="logo">
                <a href="{{ route('index') }}" class="standard-logo"><img src="{{ asset('media/images/logo-mrav.svg') }}" alt="{{ config('app.name') }} Logo"></a>
                <a href="{{ route('index') }}" class="retina-logo"><img src="{{ asset('media/images/logo-mrav.svg') }}" alt="{{ config('app.name') }} Logo"></a>
            </div>
            <!-- Primary Navigation -->
            <nav id="primary-menu" class="style-3">
                <ul>
                    @foreach ($categories as $category)
                        @if ( ! $category->subcategory)
                            <li><a href="{{ route('page', ['cat' => $category->slug]) }}"><div>{{ $category->name }}</div></a></li>
                        @else
                            @if ($category->single_page)
                                <li><a href="{{ route('page', ['cat' => $category->slug, 'subcat' => $subcategory->slug]) }}"><div>{{ $subcategory->name }}</div></a></li>
                            @else
                                <li><a href="{{ route('page', ['cat' => $category->slug]) }}"><div>{{ $category->name }}</div></a>
                                    <ul>
                                        @foreach ($category->subcategory as $subcategory)
                                            <li><a href="{{ route('page', ['cat' => $category->slug, 'subcat' => $subcategory->slug]) }}"><div>{{ $subcategory->name }}</div></a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
                <!-- Top Search -->
                <div id="top-search">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <form action="{{ route('search.all') }}" method="get">
                        <input type="text" name="q" class="form-control" value="" placeholder="Upiši pojam pretrage &amp; Enter..">
                    </form>
                </div>
            </nav>
        </div>
    </div>
</header>
