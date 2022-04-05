<!--   Feature Post Section -->
<section class="feature-posts d-none">
    <div class="feature-posts_wrapper d_flex feature-post-slider owl-carousel owl-theme">

        @forelse ($feature_posts as $item)

            <div class="feature-post d_flex item owl-lazy" data-src="{{asset($item->post_img)}}">
                <span class="overlay"></span>
                <div class="feature-post_content d_flex">
                    <div class="categories d_flex">
                        <a href="{{url('/categories/'.$item->category->slug)}}">{{$item->category->name}}</a>
                    </div>
                    <a class="title" href="{{ url('post/'. $item->slug) }}">
                        {{$item->title}}
                    </a>
                    <div class="post_bottom d_flex">
                        <p class="date">{{$item->created_at->format('d F, Y')}}</p>
                        <div class="comments d_flex">
                            <i class="fas fa-comment"></i>
                            <p> {{$item->comments_count}}</p>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <p>No Post to show</p>
        @endforelse
    </div>
    <div class="btn-prev"></div>
    <div class="btn-next"></div>
</section>
<!--   Feature Post Section End -->
