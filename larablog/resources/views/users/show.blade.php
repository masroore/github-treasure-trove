@extends('layouts.manage')
@section('title' ,'Author Profile')

@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    {{ $user->name }}'s Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('changeRole', $user->id) }}" method="post" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" value="{{$user->name}}" name="name"
                                   disabled>
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                   value="{{$user->email}}" name="email" disabled>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small>
                        </div>

                        <div class="form-group">
                            <label for="role">Change Role</label>
                            <select name="role" id="role">
                                @forelse($roles as $role)
                                    <option
                                        value="{{ $role->id }}"
                                        {{ $role->id === auth()->user()->role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @empty
                                    <option value="null">No Role Assigned</option>
                                @endforelse

                            </select>
                        </div>

                        <button type="submit" class="btn bg-sienna">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#form").submit(function (event) {
                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = new FormData(this); //Encode form elements for submission

                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data,
                    contentType: false, //contentType is set to false otherwise default is set "application/x-www-form-urlencoded", which is no good for uploading files, setting it false will post data as "multipart/form-data".
                    processData: false, // processData, which must also be set to false, otherwise jQuery will try to serialize the FormData object into query string, and you might end up with an Illegal invocation error.
                }).done(function (response) { //
                    toastr.success(response.success); // success notification
                    $("#form").trigger("reset"); // form reset
                });
            });
        });
    </script>
@endsection
