<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Unlocked') }} User</title>

    <!-- Scripts -->
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
</head>
<body class="login">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Unlocked') }} User
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4  d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Set New Password</div>

                            <div class="card-body">
                                <div class="flash-message">
                                    @if(session()->has('status'))
                                        @if(session()->get('status') == 'success')
                                            <div class="alert alert-success  alert-dismissible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
                                            </div>
                                        @endif
                                        @if(session()->get('status') == 'error')
                                            <div class="alert alert-danger  alert-dismissible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
                                            </div>
                                        @endif
                                    @endif
                                </div> <!-- end .flash-message -->

                                <form method="POST" action="{{ route('userupdatenewpassword') }}" id="passwordreset_form">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('email') }}" autocomplete="email" autofocus>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                        <div class="col-md-6">
                                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('cpassword') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="email" autofocus>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-custom">
                                               Set Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
<script>
$( document ).ready(function() {
	$("form[id='passwordreset_form']").validate({
		// Specify validation rules
		rules: {
            password : {
    				required: true,
                    minlength : 6
                },
                password_confirmation : {
    				required: true,
                    equalTo : "#password"
                }
		},
		// Specify validation error messages
		messages: {
			password: {
    				required: 'Password field is required',
    				minlength: 'Please enter minimum 6 length password'
    			},
    			password_confirmation: {
    				required: 'Confirm Password field is required',
                    equalTo : "Confirm Password must be same as new password"
    			}
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>

