@extends('layouts.manage')
@section('title' ,'Edit')

@section('content')
    <div class="col p-0">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="mb-0">{{  $tag->name }} Tag <span class="badge badge-secondary">{{ $tag->posts->count() }}
                Posts</span></h2>

            @can('update', \App\Tag::class)
                <a class="btn btn-primary" href="{{ route('tag.edit', $tag->id) }}">Edit</a>
            @endcan
            
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Tags</th>
                </thead>
                <tbody>
                @foreach ($tag->posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td><a href="{{ route('post.show', $post->slug) }}"> {{ $post->title }}</a></td>
                        <td>
                            @foreach ($post->tags as $tag)
                                <span class="badge badge-dark">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- pagination -->
        @if ($tag->posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $tag->posts->links() }}
        @endif
        <!-- pagination End -->

        </div>
    </div>
@endsection
