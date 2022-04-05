@extends('layouts.manage')
@section('title' ,'Change Password')

@section('content')
    <div class="row">
        <div class="col-md-6 py-4 m-auto">
            <div class="card">
                <div class="card-header">
                    Change Password
                </div>
                <div class="card-body">

                    <form action="{{route('users.passChange', Auth::id())}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password"
                                   placeholder="Current Password"
                                   name="current_password" required>

                            <!-- Error display -->
                            @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                   placeholder="password">

                            <!-- Error display -->
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                   placeholder="Confirm Password" name="password_confirmation" required>

                            <!-- Error display -->
                            @error('password_confirmation')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn bg-sienna">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
