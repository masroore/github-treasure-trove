@extends('layouts.manage')
<!-- Site title -->
@section('title' ,'All Posts')

@section('content')
    <div class="col p-0">

        <!-- Table title -->
        <div class="d-flex justify-content-between mb-3">
            <h3 class="mb-0">All Posts</h3>

            @can('create', \App\Post::class)
                <a href="{{ route('post.create') }}" class="btn bg-sienna text-white">Write</a>
            @endcan

        </div>
        <!-- Table title End -->

        <!-- Data Table -->
        <div class="table-responsive text-nowrap">
            <table class="table table--striped ">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Post Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>
                            {{ $posts->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <a href="{{ url('post/'. $post->slug) }}">{{Str::limit($post->title, 25)}}</a>
                        </td>
                        <td>
                            <a href="{{ url('user/'.$post->user->id.'/posts') }}">{{ $post->user->name }}</a>
                        </td>
                        <td>
                            <a href="{{url('/categories/'.$post->category->slug)}}">{{ $post->category->name }}</a>
                        </td>
                        <td>
                            <img data-src="{{asset($post->post_img)}}" class="lazyload" loading="lazy" alt="post thumb"
                                 width="80" height="50">
                        </td>
                        <td>
                            @can('update', $post)
                                <a href="{{ route('post.edit',$post->id) }}" class="btn table-primary"><i
                                        class="far fa-edit"></i></a>
                            @endcan

                            @can('delete', $post)
                                <form action="" id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger" id="delete"
                                            data-action="{{ route('post.destroy',$post->id) }}"><i
                                            class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No data to show</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- Data Table End -->
            <!-- pagination -->
        @if ($posts->lastPage() > 1)
            {{ $posts->links() }}
        @endif
        <!-- pagination End -->
        </div>
    </div>
@endsection
