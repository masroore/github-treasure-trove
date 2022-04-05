<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Unlocked') }} Admin</title>

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
				{{ config('app.name', 'Unlocked') }} Admin
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

        <main class="py-4 d-flex flex-column justify-content-center">

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header">404 Error</div>

							<div class="flash-message">
                                    @if(session()->has('status'))
                                        @if(session()->get('status') == 'Success')
                                            <div class="alert alert-success  alert-dismissible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
                                            </div>
                                        @endif
                                        @if(session()->get('status') == 'Error')
                                            <div class="alert alert-danger  alert-dismissible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
                                            </div>
                                        @endif
                                    @endif
                                </div> <!-- end .flash-message -->
							<div class="card-body">
								<form>

									<div class="form-group row mb-0">
										<div class="col-md-12 text-center">
                    <p>Page not found, the requested URL has been changed or removed.</p>
                    <a href="{{url('/')}}" class="tn btn-link">Go to Home Page</a>
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


