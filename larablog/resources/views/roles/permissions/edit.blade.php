@extends('layouts.manage')
@section('title' ,'Edit Permission')
@section('content')

    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header bg-sienna">
                    Edit this permission
                </div>
                <div class="card-footer">
                    <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Name Form Input -->
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ $permission->display_name }}"
                                   required>

                        </div><!-- Name Form Input End -->


                        <!-- Slug Form Input -->
                        <div class="form-group">
                            <label for="slug">Slug (cannot be changed)</label>
                            <input type="text" id="slug" class="form-control" value="{{ $permission->slug }}" disabled>
                        </div><!-- Slug Form Input End -->


                        <!-- Description Form Input -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                   value="{{ $permission->description }}" required>
                        </div><!-- Description Form Input End -->


                        <button type="submit" class="btn bg-sienna">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

