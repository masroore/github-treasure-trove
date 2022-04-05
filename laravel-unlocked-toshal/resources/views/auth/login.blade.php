<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <main class="py-4 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"></div>
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
                                @if($register != '')
                                <div class="alert alert-success  alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ $register }}
                                </div>
                                @endif
                            </div> <!-- end .flash-message -->
                            <div class="card-body">
                                <div class="" id="status"></div>
                                <form class="form" method="POST" action="{{ route('login') }}" id="login_form">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"" placeholder=" Email Address" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 offset-md-2">
                                            <button type="submit" class="btn btn-custom" id="sign_in">
                                                LOG IN
                                            </button>

                                            <!-- <button class="btn btn-custom"> -->
                                            <a href="{{ route('password.reset') }}" class="font-fourteen">Forgot my password</a>
                                            <!-- </button> -->
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-12 offset-md-2">
                                            <a href="{{ url('auth/google') }}" class="btn btn-success ">
                                                <strong>Login With Google</strong>
                                            </a>
                                            <a href="" class="btn btn-info ">
                                                <strong>Login With Facebook</strong>
                                            </a>
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
    $(document).ready(function() {
        $("form[id='login_form']").validate({
            // Specify validation rules
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            },
            // Specify validation error messages
            messages: {
                email: {
                    required: 'Email address is required',
                    email: 'Provide a valid Email address',
                },
                password: {
                    required: 'Password is required',

                }
            },
            submitHandler: function(form) {
                var formdata = jQuery("form[id='login_form']");
                var urls = formdata.prop('action');
                jQuery("#sign_in").html('LOG IN <i class="fa fa-spinner fa-spin"></i>');
                jQuery("#sign_in").attr("disabled", true);
                jQuery.ajax({
                    type: "POST",
                    url: urls,
                    data: formdata.serialize(),
                    success: function(data) {
                        let result = JSON.parse(data);
                        if (result.success == true) {
                            location.href = result.message;
                        } else if (result.success == false) {
                            jQuery("#status").html('<div class="alert alert-danger  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>');
                            jQuery("#sign_in").html('LOG IN');
                            jQuery("#sign_in").attr("disabled", false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';

                        if (jqXHR.status === 302) {
                            swal({
                                title: "Warning",
                                text: "Session timeout!",
                                icon: "warning",
                            });
                            window.location.reload();
                        } else if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            var errors = jQuery.parseJSON(jqXHR.responseText);
                            var erro = '';
                            jQuery.each(errors['errors'], function(n, v) {
                                erro += '<p class="inputerror">' + v + '</p>';
                            });
                            jQuery("#sign_in").html('LOG IN');
                            jQuery("#sign_in").attr("disabled", false);
                            jQuery("#status").html('<div class="alert alert-danger alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + erro + '</div>');
                            jQuery("#errorsinfo").html(erro);
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        console.info(msg);
                    }
                });
            }
        });
    });
</script>