@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">SMTP Information</h1>
	</div>
	<div class="flash-message">
		@if(session()->has('status'))
		@if(session()->get('status') == 'error')
		<div class="alert alert-danger  alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ session()->get('message') }}
		</div>
		@endif
		@if(session()->get('status') == 'success')
		<div class="alert alert-success  alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ session()->get('message') }}
		</div>
		@endif
		@endif
	</div>
	<!-- end .flash-message -->
	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body pt-2 pb-3 manageClinicSection">
					<h5 class="mt-3 mb-4">
						Create SMTP Info
						<a href="{{route('smtp.list')}}" class="float-right"><i data-feather="x"></i></a>	
					</h5>
					<form action="{{route('smtp.create')}}" method="post" class="user" id="add_smtp_form" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Host Name<span class="required">*</span>
									</label>
									<input type="text" name="host" id="host" value="{{old('host')}}" class="form-control form-control-user" />
									@if ($errors->has('host'))
									<span class="text-danger">{{ $errors->first('host') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Port<span class="required">*</span>
									</label>
									<input type="text" name="port" id="port" value="{{old('port')}}" class="form-control form-control-user" />
									@if ($errors->has('port'))
									<span class="text-danger">{{ $errors->first('port') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Username<span class="required">*</span>
									</label>
									<input type="text" name="username" id="username" value="{{old('username')}}" class="form-control form-control-user" />
									@if ($errors->has('username'))
									<span class="text-danger">{{ $errors->first('username') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>From Name<span class="required">*</span>
									</label>
									<input type="text" name="from_name" id="from_name" value="{{old('from_name')}}" class="form-control form-control-user" />
									@if ($errors->has('from_name'))
									<span class="text-danger">{{ $errors->first('from_name') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Email<span class="required">*</span>
									</label>
									<input type="email" name="from_email" id="from_email" value="{{old('from_email')}}" class="form-control form-control-user" />
									@if ($errors->has('from_email'))
									<span class="text-danger">{{ $errors->first('from_email') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Password<span class="required">*</span>
									</label>
									<input type="text" name="password" id="password" value="{{old('password')}}" class="form-control form-control-user" />
									@if ($errors->has('password'))
									<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Encryption<span class="required">*</span>
									</label>
									<input type="text" name="encryption" id="encryption" value="{{old('encryption')}}" class="form-control form-control-user" />
									@if ($errors->has('encryption'))
									<span class="text-danger">{{ $errors->first('encryption') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Status<span class="required">*</span>
									</label>
									<div class="input-group">
										<div id="radioBtn" class="btn-group">	<a class="btn btn-success btn-sm {{ old('status') ? old('status') == '1' ? 'active' : 'notActive' : 'active'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status') == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="1">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" name="action" value="saveadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit" name="action" value="save" class="btn btn-primary">Save</button>	<a href="{{route('smtp.list')}}" class="btn btn-light">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
</div>
<!-- container-fluid -->
@endsection
@section('scripts')
<script>
    $( document ).ready(function() {
    	$("form[id='add_smtp_form']").validate({
    		// Specify validation rules
    		rules: {
    			host: {
    				required: true,
                	maxlength: 200
    			},
    			port: {
    				required: true,
    				number: true,
                	maxlength: 200
    			},
    			username: {
    				required: true,
                	maxlength: 200
    			},
    			from_email: {
    				required: true,
    				email: true,
                	maxlength: 200
    			},
    			from_name: {
    				required: true,
                	maxlength: 200
    			},
    			password: {
    				required: true,
                	maxlength: 200
    			},
    			encryption: {
    				required: true,
                	maxlength: 200
    			}
    		},
    		// Specify validation error messages
    		messages: {
    			host: {
    				required: 'Host name is required',
                  		maxlength: 'Host name should be less than 200 characters '
    			},
    			port: {
    				required: 'Port number is required',
    				number: 'Only digits are allowed',
                  	maxlength: 'Port should be less than 200 characters '
    			},
    			username: {
    				required: 'Username is required',
					maxlength: 'Username should be less than 200 characters '
				},
    			from_email: {
    				required: 'Email address is required',
    				email: 'Provide a valid email address',
					  maxlength: 'Email address should be less than 200 characters '
				},
    			from_name: {
    				required: 'From Name is required',
                  	maxlength: 'From name should be less than 200 characters '
    			},
    			password: {
    				required: 'Password field is reqired',
                  	maxlength: 'Password should be less than 200 characters '
    			},
    			encryption: {
    				required: 'Encryption field us required',
                  	maxlength: 'Encryption should be less than 200 characters '
    			}
    		},
    		submitHandler: function(form) {
    			form.submit();
    		}
    	});
    })
</script>
@stop