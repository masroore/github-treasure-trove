@extends('layouts.layout')
@section('title' ,'larablog | A laravel blog')

@section('content')

    <!--   Main Post Section -->
    <section class="post-list">
        @forelse ($posts as $post)
            <div class="posts">
                <div class="posts_contents_wrapper d_flex">
                    <div class="posts_preview_img">
                        <img data-src="{{ asset($post->thumbnail)}}" class="lazyload" loading="lazy" alt="preview_img"
                             width="400" height="250">
                    </div>
                    <div class="posts_desc d_flex">
                        <div class="posts_title">
                            <div class="categories d_flex">
                                <a href="{{url('/categories/'.$post->category->slug)}}">{{$post->category->name}}</a>
                            </div>
                            <a class="title" href="{{ url('post/'. $post->slug) }}">
                                {{$post->title}}
                            </a>
                            <div class="info d_flex">
                                <p class="date">{{$post->created_at->format('d F, Y')}}</p>
                                <p class="author">by <a
                                        href="{{url('user/'.$post->user->id.'/posts')}}">{{$post->user->name}}</a></p>
                            </div>
                        </div>
                        <p class="text_contents">
                            {{Str::limit(strip_tags($post->details), 300)}}
                            <br>
                            <a class="read_more" href="{{ url('post/'. $post->slug) }}">...</a>
                        </p>
                    </div>
                </div>
                <div class="post_buttons d_flex">
                    <div class="comments d_flex">
                        <a href="{{ url('post/'. $post->slug.'#comments') }}"> <i class="far fa-comment"></i>
                            {{ $post->comments->count() }}</a>
                    </div>
                    <div class="post_share">
                        <span>Share</span>
                        <a href="http://www.facebook.com/sharer.php?u={{URL::current()}}&t={{$post->title}}"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{URL::current()}}&text={{$post->title}}"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" onclick="event.preventDefault();copyToClipboard('{{ url('post/'. $post->slug) }}');"
                           id="copy"><i class="far fa-clipboard"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No articles to show</p>
    @endforelse

    <!-- pagination -->
    @if ($posts->lastPage() > 1)
        {{ $posts->links() }}
    @endif
    <!-- pagination End -->


    </section>
@endsection
