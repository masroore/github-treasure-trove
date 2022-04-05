@extends('layouts.layout')
@section('title')
    {{$post->title}}
@endsection

@section('content')
    <section class="post-list">
        <div class="posts">
            <div class="posts_contents_wrapper d_flex">
                <div class="post_details d_flex">
                    <div class="posts_title">
                        <div class="categories d_flex">
                            <a href="{{url('/categories/'.$post->category->slug)}}">{{$post->category->name}}</a>
                        </div>
                        <a class="title">
                            {{$post->title}}
                        </a>
                        <div class="info d_flex">
                            <p class="date">{{$post->created_at->format('jS F, Y')}}</p>
                            <p class="author">by <a
                                        href="{{url('user/'.$post->user->id.'/posts')}}">{{$post->user->name}}</a></p>
                        </div>
                    </div>
                </div>

                <div class="post_img">
                    <img data-src="{{asset($post->post_img)}}" src="{{asset($post->post_img)}}" class="lazyload"
                         loading="lazy" alt="preview_img" width="800"/>
                </div>
                <div class="entry-content">

                    {!! $post->details !!}

                </div>
                <div class="tags">
                    <ul class="taglist d_flex">
                        @foreach ($post->tags as $tag)
                            <li><a href="{{url('/')}}?tag={{$tag->name}}">{{$tag->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="post_buttons d_flex details_page">
                <div class="post_share">
                    <span>Share</span>
                    <a href="http://www.facebook.com/sharer.php?u={{URL::current()}}&t={{$post->title}}"><i
                                class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{URL::current()}}&text={{$post->title}}"><i
                                class="fab fa-twitter"></i></a>
                    <a href="#" onclick="event.stopPropagation();copyToClipboard('{{ url('post/'. $post->slug) }}');"
                       id="copy"><i class="far fa-clipboard"></i>
                    </a>
                </div>
            </div>
        </div>
        <nav class="post-navigation d_flex">
            @if (isset($previous))
                <div class="prev_post post_link">
                    <a href="{{ url('post/'.$previous->slug) }}" rel="prev">
                        <span class="meta-nav">Previous Post</span>
                        <div class="post-content">
                    <span class="title">
                        {{ $previous->title }}
                    </span>
                        </div>
                    </a>
                </div>
            @endif
            @if (isset($next))
                <div class="next-post post_link">
                    <a href="{{ url('post/'.$next->slug) }}" rel="prev">
                        <span class="meta-nav">Next Post</span>
                        <div class="post-content">
                            <span class="title">{{ $next->title }}</span>
                        </div>
                    </a>
                </div>
            @endif

        </nav>
        <div class="post-comments" id="comments">
            <h2 class="comments-title">{{$post->comments->count()}} Comments</h2>
            <div class="comment-section">
                @forelse($post->comments as $comment)
                    <div class="single-comment d-flex pt-2 pb-2">
                        <div class="single-comment__avater mr-3"
                             style="background-image: url({{ $comment->avatar }})">
                        </div>
                        <div class="single-comment__content">
                            <div class="single-comment--name font-weight-bold">
                                {{  $comment->name }}
                                <small class="float-right">{{ $comment->created_at->diffForHumans() }}</small>
                                <small class="d-block text-black-50">{{ $comment->email }}</small>
                            </div>

                            <div class="single-comment--message">
                                {{ $comment->comment }}
                            </div>
                            @auth
                                <form action="" method="post" id="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger" id="delete"
                                            data-action="{{ route('comment.destroy',$comment->id) }}"><i
                                                class="fas fa-trash"></i></button>
                                </form>
                            @endauth
                        </div>
                    </div>
                @empty

                @endforelse

            </div>

            <div class="comment-respond">
                <h2 class="comment-reply-title">
                    Leave a comment
                </h2>
                <form action="{{route('comment.store/',$post->id)}}" method="post">
                    @csrf

                    <p class="comment-notes">
                        Your email address will not be published.
                    </p>

                    <div class="input-field">
                        <textarea name="comment" placeholder="Your Comment *" aria-required="true"></textarea>
                    </div>

                    <div class="d_flex justify-between">
                        <div class="input-field">
                            <input type="text" name="name" placeholder="Name *" aria-required="true"/>
                        </div>
                        <div class="input-field">
                            <input type="email" name="email" placeholder="Email *" aria-required="true"/>
                        </div>
                    </div>
                    <p class="form-submit">
                        <input type="submit" class="submit" value="Post Your Comment"/>
                    </p>
                </form>
            </div>
            <!-- #respond -->
        </div>
    </section>
@endsection
