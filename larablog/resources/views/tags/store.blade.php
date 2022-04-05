@extends('layouts.manage')
@section('title' ,'Tags')

@section('content')

    <div class="col">
        @can('create', App\Tag::class)
            <div class="row write-tag">
                <div class="post-comments col-12">
                    <h2 class="comments-title">Add a new tag here.</h2>
                    <div class="comment-respond">
                        <form action="{{route('tag.store')}}" method="post">
                            @csrf
                            <div class="d_flex">
                                <div class="input-field" style="width:100%">
                                    <input type="text" name="name" placeholder="Tag Name *" aria-required="true"/>
                                </div>

                            </div>

                            {{-- Displaying The Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{-- Displaying The Validation Errors --}}

                            <p class="form-submit">
                                <input type="submit" class="submit" value="Add Tag" required/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('viewAny', App\User::class)
            <div class="row mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tags</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{$tag->id}}</td>
                                <td><a href="{{ route('tag.show', $tag->id) }}">{{$tag->name}}</a></td>
                                <td>
                                    @can('update', $tag)
                                        <a href="{{ route('tag.edit',$tag->id) }}" class="btn table-primary"><i
                                                class="far fa-edit"></i></a>
                                    @endcan

                                    @can('delete', $tag)
                                        <form action="" id="deleteForm" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-danger" id="delete"
                                                    data-action="{{ route('tag.destroy',$tag->id) }}"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <!-- pagination -->
                @if ($tags->lastPage() > 1)
                    {{ $tags->links() }}
                @endif
                <!-- pagination End -->
                </div>
            </div>
        @endcan
    </div>
@endsection
