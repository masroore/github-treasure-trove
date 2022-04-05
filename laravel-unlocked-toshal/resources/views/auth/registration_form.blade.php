
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

        <main class="py-4 d-flex flex-column justify-content-center">

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="card">
                        <div  id="status">
                        </div>
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
                            <h5 >Register</h5>
								<form class="form" method="POST" action="{{ route('register') }}" id="register_form" autocomplete="off" enctype="multipart/form-data">
									@csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{old('first_name')}}" />
                                        @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                     <div class="form-group">
                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{old('last_name')}}" />
                                            @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{old('email')}}" />
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password" id="password" value="{{old('password')}}" />
                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control"  name="password_confirmation" placeholder="Confirm password" value="{{old('password_confirmation')}}" />
                                        @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="role" id="role">
                                            <option value="">Register as</option>
                                            <option value="1">User</option>
                                            <option value="2">Owner</option>
                                        </select>
                                 
                                    </div>
									<button type="submit" class="btn btn-success" id="sign_up">Register</button>
                                        <p class="noaccount-text font-fifteen text-center m-0 pt-3">Already registered <a href="{{route('login')}}">Log in</a></p>
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

<script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>
$( document ).ready(function() {
    $("form[id='register_form']").validate({
    	// Specify validation rules
    	rules: {
			
			first_name: {
				required: true,
				maxlength: 20,
				lettersonly: true
			},
			last_name: {
				required: true,
				maxlength: 20,
				lettersonly: true
			},
			
    		email: {
    			required: true,
    			email: true
    		},
            password : {
    			required: true,
                minlength : 6
            },
            password_confirmation : {
    			required: true,
                equalTo : "#password"
            },
            role : {
    			required: true,
                
            },
    	},
    	// Specify validation error messages
    	messages: {
    		
    		first_name: {
    			required: 'First name field is required',
		        maxlength: 'First name should be less than 20 characters'
    		},
    		last_name: {
    			required: 'Last name field is required',
		        maxlength: 'Last name should be less than 20 characters'
    		},
            email: {
    			required: 'Email address is required',
    			email: 'Provide a valid Email address',
    		},
    		password: {
    			required: 'Password field is required',
    			minlength: 'Please enter minimum 6 length password'
    		},
    		password_confirmation: {
    			required: 'Confirm Password field is required',
                equalTo : "Confirm Password must be same as password"
    		},
            role: {
    			required: 'Role field is required',
    		
    		},	
    	},
    	submitHandler: function(form) {  
			var formData = new FormData(form);
            var formdata = jQuery(form);
			var urls = formdata.prop('action'); 
            jQuery("#sign_up").html('Register <i class="fa fa-spinner fa-spin"></i>');
            jQuery("#sign_up").attr("disabled", true); 
            jQuery.ajax({
                type: "POST",
                url: urls,
				data: formData, 
				dataType: 'json',
						cache:false,
						contentType: false,
						processData: false,  
                success:function(result){  
                    if (result.success == true)
                    {
                        jQuery("#status").html('<div class="alert alert-success  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message+'</div>');
                        jQuery("#sign_up").html('Register');
                        jQuery("#sign_up").attr("disabled", false);
                        document.getElementById("register_form").reset();
                        location.href = result.message2;  
                    }
                    else if(result.success == false)
                    {
                        jQuery("#status").html('<div class="alert alert-danger  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message+'</div>');
                        jQuery("#sign_up").html('Register');
                        jQuery("#sign_up").attr("disabled", false);
                    } 
                    else if(result.error == true)
                    {
                        var response = JSON.parse(data.responseText);
                        var errorString = "";
                        $.each( response.errors, function( key, value) {
                            errorString =  value;
                        }); 
                        jQuery("#status").html('<div class="alert alert-danger  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+errorString+'</div>');
                        jQuery("#sign_up").html('Register');
                        jQuery("#sign_up").attr("disabled", false);
                    }  
                    // console.info("Success");
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    
                    if (jqXHR.status === 302) {
                        swal({
                            title: "Warning",
                            text: "Session timeout!",
                            icon: "warning",
                        });
                        window.location.reload();
                    }
                    else if (jqXHR.status === 0) {
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
                        jQuery("#sign_up").html('Register');
                        jQuery("#sign_up").attr("disabled", false);
                        jQuery("#status").html('<div class="alert alert-danger  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+erro+'</div>');
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    // console.info(msg);
                }  
            }); 
		}
    });
});
</script> 


