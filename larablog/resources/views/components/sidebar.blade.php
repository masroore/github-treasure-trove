<!--   Side Bar -->
<section class="side-content">
    <div class="about_me">
        <div class="about_me_inner d_flex">
            <div class="avtar">
                <img data-src="{{ asset('images/me.webp')}}" class="lazyload" loading="lazy" alt="my_avtar" width="170"
                     height="234">
            </div>
            <div class="title">about me</div>
            <p class="texts">Hi! My name is
                <b>MD Riaz</b>. This is my blog site. It is based on laravel framework. </p>
            <div class="follow_buttons">
                <p class="follow">follow me on
                </p>
                <div class="social">
                    <a href="https://twitter.com/MDRiaz53949149"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/mdriaz.wd"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/md_riaz__"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-google-plus-g"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="subscribe">
        <h3 class="bottom_bar">newshelter</h3>
        <form action="{{route('subscribe')}}" method="post">
            @csrf
            <input type="email" name="email" id="email" placeholder="your email address">
            @error('email')
            <p class="text-danger">{{$message}}</p>
            @enderror
            <button type="submit" class="flat-btn">subscribe</button>
        </form>
    </div>
    <div class="follow_insta">
        <h3 class="bottom_bar">follow@md_riaz___</h3>
        <div class="photo_grid d_flex">
            <img data-src="{{ asset('images/photo_grid/1.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/2.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/4.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/5.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/3.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/6.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/7.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/8.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
            <img data-src="{{ asset('images/photo_grid/9.webp')}}" class="lazyload" loading="lazy" alt="grid_image"
                 width="87" height="87">
        </div>
    </div>
    <div class="category_section">
        <h3 class="bottom_bar">categories</h3>
        <ul>
            @foreach ($categories as $category)
                <li class="menu-item"><a href="{{url('/categories/'.$category->slug)}}">{{ $category->name }}</a>
                    <span>{{$category->posts_count}}</span></li> <!-- count how many post in a category -->
            @endforeach
        </ul>
    </div>
    <div class="latest_posts">
        <h3 class="bottom_bar">recent posts</h3>

        <div class="latest_post_wrapper">
            @foreach ($latest as $item)
                <div class="latest_post d_flex">
                    <div class="latest_post_preview_img">
                        <img data-src="{{ asset($item->thumbnail)}}" class="lazyload" loading="lazy" alt="preview_img"
                             width="70" height="70">
                    </div>
                    <div class="posts_desc">
                        <p class="date">{{ $item->created_at->format('d F, Y')}}</p>
                        <a href="{{url('post/'.$item->slug)}}">
                            <h3 class="title">{{ $item->title}}</h3>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="search_bar">
        <form action="{{ route('searchItem') }}" method="get" id="searchForm" class="d_flex">
            @csrf
            <input type="text" name="search" id="search" placeholder="search...">
            <button class="flat-btn"><i class="fas fa-search"></i></button>
        </form>
        <span class="searchlist"></span>
    </div>

    <div class="banner">
        <h3 class="bottom_bar">banner</h3>
        <div class="banner_img">
            <img data-src="{{ asset('images/banner.webp')}}" class="lazyload" loading="lazy" alt="banner_img"
                 width="270" height="368">
        </div>
    </div>

    <div class="follow_fb">
        <h3 class="bottom_bar">find us on Facebook</h3>
        <div class="fb_frame">

        </div>
    </div>

    <!-- Tags Section -->
    <div class="tags">
        <h3 class="bottom_bar">tags</h3>
        <ul class="taglist d_flex">
            @foreach ($tags as $tag)
                <li><a href="{{url('/')}}?tag={{$tag->name}}">{{$tag->name}}</a></li>
            @endforeach
        </ul>
    </div>
    <!-- Tags Section End -->
</section>
@section('scripts')
    <script>
        /* select all needed items */
        var searchInput = $('#search'),
            searchForm = $('#searchForm'),
            action = searchForm.attr('action'),
            method = searchForm.attr('method'),
            searchlist = $('.searchlist')

        /* On search input, check empty or make ajax req */
        searchInput.on('keyup', () => {
            // empty the list
            searchlist.html("")
            if (searchInput.val() === "") {
                searchlist.fadeOut("slow")
            } else {
                // or make ajax get req
                searchlist.fadeIn("slow")
                $.ajax({
                    url: action,
                    type: method,
                    data: {'search': searchInput.val()},
                    success: (data) => {
                        // loop array & make url
                        $.each(data, function (slug, title) {
                            searchlist.append(`<a href=post/${slug}>${title}</a><hr>`)
                        });
                    },
                    // if error found show something
                    error: () => {
                        searchlist.html("Nothing Found")
                    }
                })
            }

        })
    </script>
@stop
