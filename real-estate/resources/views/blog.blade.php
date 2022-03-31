@extends('layouts.homepage')
@section('content')
<!-- START SECTION BLOG -->
<section class="blog-section">
    <div class="container">
        <div class="sec-title">
            <h2><span>Articles &amp; </span>Tips</h2>
            <p>Read the latest news from our blog.</p>
        </div>
        <div class="news-wrap">
            <div class="row">
                @foreach ($blogs as $key => $blog)
                    <div class="col-xl-4 col-md-6 col-xs-12 mt-4">
                        <div class="news-item" data-aos="fade-up">
                            <a  class="news-img-link">
                                <div class="news-item-img">
                                    @if ($blog->photo)
                                        <img class="img-responsive" src="{{ $blog->photo->getUrl() }}"
                                            alt="blog image">
                                    @endif

                                </div>
                            </a>
                            <div class="news-item-text">
                                <a >
                                    <h3>{{ $blog->title ?? '' }}</h3>
                                </a>
                                <div class="dates">
                                    <span class="date"> {{ $blog->created_at->diffForHumans() }} &nbsp;/</span>
                                    {{-- <ul class="action-list pl-0">
                                        <li class="action-item pl-2"><i class="fa fa-heart"></i> <span>306</span>
                                        </li>
                                        <li class="action-item"><i class="fa fa-comment"></i> <span>34</span></li>
                                        <li class="action-item"><i class="fa fa-share-alt"></i> <span>122</span>
                                        </li>
                                    </ul> --}}
                                </div>
                                <div class="news-item-descr big-news">
                                    {!! Str::limit($blog->description, 120) !!}
                                </div>
                                <div class="news-item-bottom">
                                    {{-- <a  class="news-link">Read more...</a> --}}
                                    {{-- <div class="admin">
                                        <p>By, Karl Smith</p>
                                        <img src="images/testimonials/ts-6.jpg" alt="">
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BLOG -->
@endsection
