@extends('layouts.manage')
@section('title' ,'Admin Panel')

@section('content')
    <div class="col-md-12 p-0">
        <h3>All Registered Users</h3>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Posts</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>{{ $user->posts_count }}</td>
                        <td>

                            @can('update', $user)
                                <a href="{{route('users.edit', $user->id)}}" class="btn text-primary"><i
                                        class="far fa-edit"></i></a>
                            @endcan
                            @can('delete', $user)
                                <form action="" id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger" id="delete"
                                            data-action="{{ route('users.destroy',$user->id) }}"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <td>No data available</td>
                @endforelse
                </tbody>
            </table>

            <!-- pagination -->
        @if ($users->lastPage() > 1)
            {{ $users->links() }}
        @endif
        <!-- pagination End -->

        </div>
    </div>

@endsection
