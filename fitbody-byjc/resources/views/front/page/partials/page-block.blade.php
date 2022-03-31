@if (isset($page->blocks->groupBy('type')['pdf']))
    <div class="fancy-title title-double-border topmargin-sm">
        <h3 class="font-weight-light">Povezani dokumenti</h3>
    </div>
    <div class="coll_full topmargin clearfix">
        @foreach ($page->blocks->groupBy('type')['pdf'] as $doc)
            <div class="ipost clearfix">
                <div class="col_one_fifth bottommargin-sm">
                    <div class="text-center">
                        <a href="{{ asset($doc->path) }}"><img class="image_fade" src="{{ asset($doc->thumb) }}" alt="Image" style="width: 90px; margin-top: 10px;"></a>
                    </div>
                </div>
                <div class="col_four_fifth bottommargin-sm col_last">
                    <div class="entry-title">
                        <h3><a href="{{ asset($doc->path) }}">{{ $doc->title }}</a></h3>
                    </div>
                    <ul class="entry-meta clearfix">
                        <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($doc->created_at)->locale('hr')->format('d.m.Y - H:i') }}h</li>
                        <li><a href="{{ asset($doc->path) }}"><i class="icon-download"></i> Skini</a></li>
                        {{--<li><i class="icon-eye"></i> Pogledaj</li>--}}
                    </ul>
                    <div class="entry-content">
                        <p>{{ $doc->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if (isset($page->blocks->groupBy('type')['image']))
    <div class="fancy-title title-double-border topmargin-sm">
        <h3 class="font-weight-light">Galerija fotografija</h3>
    </div>
    <div class="col_full bottommargin-sm">
        <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
            <div class="flexslider">
                <div class="slider-wrap">
                    @foreach ($page->blocks->groupBy('type')['image'] as $block)
                        <div class="slide" data-thumb="{{ asset($block->path) }}">
                            <a href="#">
                                <img src="{{ asset($block->path) }}" alt="">
                                <div class="overlay">
                                    <div class="text-overlay">
                                        <div class="text-overlay-title">
                                            <h3>{{ isset($block->title) && $block->title != '' ? $block->title : $page->name }}</h3>
                                        </div>
                                        <div class="text-overlay-meta">
                                            <span>{{ config('app.longname') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
