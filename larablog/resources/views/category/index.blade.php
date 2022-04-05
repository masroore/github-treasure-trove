@extends('layouts.manage')
@section('title' ,'All Category')

@section('content')

    <div class="col p-0">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="mb-0">All Categories</h3>
            <a href="{{ route('category.create') }}" class="btn bg-sienna text-white">ADD+</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Author</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $row)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->slug }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->created_at->format('dS F, Y') }}</td>
                        <td>

                            @can('update', App\Category::class)
                                <a href="{{ route('category.edit', $row->id) }}" class="btn text-primary"><i
                                        class="far fa-edit"></i></a>
                            @endcan

                            @can('view', App\Category::class)
                                <a href="{{ route('category.show',$row->id) }}" class="btn text-secondary"><i
                                        class="far fa-eye"></i></a>
                            @endcan

                            @can('delete', \App\Category::class)
                                <form action="" id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger" id="delete"
                                            data-action="{{ route('category.destroy',$row->id) }}"><i
                                            class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- pagination -->
        @if ($categories->lastPage() > 1)
            {{ $categories->links() }}
        @endif
        <!-- pagination End -->

        </div>
    </div>
@endsection
