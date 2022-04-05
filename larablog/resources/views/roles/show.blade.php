@extends('layouts.manage')
@section('title' ,'Role Details')
@section('stylesheet')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
@stop
@section('content')

    <div class="jumbotron bg-light">
        <div class="float-right">
            <button class="btn text-primary" type="button">
                <a href="{{ route('roles.edit', $role->id) }}"><i class="far fa-edit"></i> Edit</a>
            </button>
        </div>
        <h3>Role {{ $role->name }}</h3>
        <hr>
        <div class="row">
            <div class="col">
                <!-- Tags Form Input -->
                <div class="form-group">
                    <label for="tags">Permissions</label>
                    <select class="js-select-multiple form-control" name="permissions[]" multiple="multiple">
                        @forelse ($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->display_name}}</option>
                        @empty
                            <option value="">No permission available</option>
                        @endforelse
                    </select>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        // Select2 int
        $(document).ready(function () {
            $('.js-select-multiple').select2();
            var permissions = []; // declare an empty array
            @foreach ($role->permissions as $permission) // loop through each permissions
            permissions.push({{ $permission->id }}) // push id to permission array
            @endforeach
            $('.js-select-multiple').select2().val(permissions).trigger('change'); // Notify any JS components that the value changed

        });
    </script>
@stop
