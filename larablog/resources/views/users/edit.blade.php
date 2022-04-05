@extends('layouts.manage')
@section('title' ,'Edit Profile')

@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    Update your information
                </div>
                <div class="card-body">
                    <form action="{{route('users.update',Auth::id())}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" value="{{Auth::user()->name}}" name="name"
                                   required>

                            <!-- Error display -->
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <!-- Error display End-->

                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                   value="{{Auth::user()->email}}" name="email" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small>
                            <!-- Error display -->
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Enter your Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                   placeholder="Password"
                                   name="password" required>
                        </div>

                        <button type="submit" class="btn bg-sienna">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
