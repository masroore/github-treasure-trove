@extends('layouts.manage')
@section('title' ,'Roles & Permissions')
@section('stylesheet')
    <!-- multiple-select minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css') }}">
@stop
@section('content')
    <style>
        .ms-drop input[type="checkbox"] {
            width: auto;
        }
    </style>
    <div class="jumbotron bg-light">

        @can('create', \App\Role::class)
            <div class="float-right">
                <button class="btn text-primary" type="button">
                    <a
                        href="#" class="btn create-role"
                        data-toggle="modal" data-target="#create-role">
                        <i class="fas fa-plus-circle"></i> Create Role
                    </a>
                </button>
            </div>
        @endcan

        <h3 class="clearfix">Roles</h3>
        <div class="row">
            @foreach ($roles as $role)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $role->name }}
                        </div>
                        <div class="card-footer">
                            @can('update', \App\Role::class)
                                <button class="btn text-primary" type="button">
                                    <a href="{{ route('roles.edit', $role->id) }}"><i class="far fa-edit"></i> Edit</a>
                                </button>
                            @endcan

                            @can('view', \App\Role::class)
                                <button class="btn text-secondary" type="button">
                                    <a href="{{ route('roles.show', $role->id) }}"><i class="far fa-eye"></i>
                                        Details</a>
                                </button>
                            @endcan
                            @can('delete', \App\Role::class)
                                <button class="btn text-danger" id="delete"
                                        data-action="{{ route('roles.destroy',$role->id) }}"><i
                                        class="fas fa-trash"></i> Delete
                                </button>
                                <form action="" id="deleteForm" method="POST" style="display: none">
                                    @csrf
                                    @method('DELETE')

                                </form>
                            @endcan

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
        <hr>

        @can('create', \App\Permission::class)
            <div class="float-right">
                <button class="btn text-primary" type="button">
                    <a
                        href="#" class="btn create-permission"
                        data-toggle="modal" data-target="#create-permission">
                        <i class="fas fa-plus-circle"></i> Create Permission
                    </a>
                </button>
            </div>
        @endcan

        <h3 class="clearfix">Permissions</h3>
        <div class="row">
            <div class="col-md-12">
                <!-- Data Table -->
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Display Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>
                                    {{ $loop->index+1 }}
                                </td>
                                <td>
                                    <a href="#">{{Str::limit($permission->display_name, 25)}}</a>
                                </td>
                                <td>
                                    {{ $permission->slug }}
                                </td>
                                <td>
                                    {{ Str::limit($permission->description, 30)}}
                                </td>

                                <td>
                                    @can('update', \App\Permission::class)
                                        <a href="{{ route('permissions.edit', $permission->id) }}"
                                           class="btn table-primary"><i
                                                class="far fa-edit"></i></a>
                                    @endcan
                                    @can('delete', \App\Permission::class)
                                        <form action="#" id="deleteForm"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-danger" id="delete"
                                                    data-action="{{ route('permissions.destroy', $permission->id) }}"><i
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

                </div>

            </div>

        </div>
    </div>




    @can('create', \App\Role::class)
        <!-- Modal for role creating -->
        <div class="modal fade" id="create-role" tabindex="-1" role="dialog" aria-labelledby="create-role"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create a Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!-- Name Form Input -->
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                       required>

                                <!-- Error display -->
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <!-- Error display End-->

                            </div><!-- Name Form Input End -->


                            <!-- Permissions Form Input -->
                            <div class="form-group">
                                <label for="permissions">Permissions</label>
                                <select multiple="multiple"
                                        placeholder="Select permissions"
                                        data-display-delimiter=" | "
                                        data-show-clear="true" data-animate='slide'
                                        name="permissions[]">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                    @endforeach
                                </select>
                            </div><!-- Permissions Form Input End -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-sienna">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can('create', \App\Permission::class)
        <!-- Modal for role creating -->
        <div class="modal fade" id="create-permission" tabindex="-1" role="dialog" aria-labelledby="create-permission"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('permissions.store') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create a Permission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!-- display_name Form Input -->
                            <div class="form-group">
                                <label for="display_name">Permission Name</label>
                                <input type="text"
                                       name="display_name"
                                       id="display_name"
                                       class="form-control"
                                       value="{{ old('display_name') }}"
                                       placeholder="Enter name"
                                       required>

                                <!-- Error display -->
                                @error('display_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <!-- Error display End-->

                            </div><!-- display_name Form Input End -->


                            <!-- Description Form Input -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" class="form-control"
                                       placeholder="Enter Description" required>

                                <!-- Error display -->
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <!-- Error display End-->
                            </div><!-- Description Form Input End -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-sienna">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/multiple-select.min.js') }}"></script>
    <script>
        $(function () {
            // initiate select2
            let select = $('select')
            select.multipleSelect({
                minimumCountSelected: 4
            })


        });
    </script>
@stop
