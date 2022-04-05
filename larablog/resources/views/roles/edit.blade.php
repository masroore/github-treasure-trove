@extends('layouts.manage')
@section('title' ,'Edit Role')
@section('stylesheet')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css') }}">
@stop
@section('content')
    <style>
        .ms-drop input[type="checkbox"] {
            width: auto;
        }
    </style>
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header bg-sienna">
                    Edit this Role
                </div>
                <div class="card-footer">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Name Form Input -->
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}"
                                   required>

                        </div><!-- Name Form Input End -->


                        <!-- Permissions Form Input -->
                        <div class="form-group">
                            <label for="permissions">Permissions</label>
                            <select multiple="multiple"
                                    data-display-delimiter=" | "
                                    data-show-clear="true" data-animate='slide'
                                    name="permissions[]">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                @endforeach
                            </select>
                        </div><!-- Permissions Form Input End -->

                        <button type="submit" class="btn bg-sienna">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('js/multiple-select.min.js') }}"></script>
    <script>
        $(function () {
            let select = $('select')
            select.multipleSelect({
                minimumCountSelected: 6
            })

            let permissions = []
            @foreach($role->permissions as $permission)
            permissions.push({{ $permission->id }})
            @endforeach

            select.multipleSelect('setSelects', permissions)
        })
    </script>
@stop
