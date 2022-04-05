@extends('user.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Change Password</h1>
	</div>
    <div class="flash-message">
		@if(session()->has('status'))
			@if(session()->get('status') == 'success')
				<div class="alert alert-success  alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
				</div>
			@endif
		@endif
	</div>
    <div class="flash-message">
        @if(session()->has('status'))
        @if(session()->get('status') == 'error')
        <div class="alert alert-danger  alert-dismissible">
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
                        Change Password                     
                    </h5>
                    <form method="POST" action="{{ route('update.password') }}" id="change_password_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Old Password<span class="required">*</span></label>
                                    <input type="password" name="currentpassword" id="currentpassword"  class="form-control form-control-user"  />
                                    @if ($errors->has('currentpassword'))
                                    <span class="text-danger">{{ $errors->first('currentpassword') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Password<span class="required">*</span></label>
                                    <input type="password" name="newpassword" id="newpassword"  class="form-control form-control-user"  />
                                    @if ($errors->has('newpassword'))
                                    <span class="text-danger">{{ $errors->first('newpassword') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Confirm Password<span class="required">*</span></label>
                                    <input type="password" name="confirmpassword" id="confirmpassword"  class="form-control form-control-user"  />
                                    @if ($errors->has('confirmpassword'))
                                    <span class="text-danger">{{ $errors->first('confirmpassword') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 mb-1">
                            <div class="text-left d-print-none mt-4">
                                <button type="submit"  class="btn btn-primary">Update</button>                              
                            </div>
                        </div>         
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->
@endsection
@section('scripts')
<script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
<script>
$( document ).ready(function() {
	$("form[id='change_password_form']").validate({
		// Specify validation rules
		rules: {
            currentpassword : {
    				required: true,
                    minlength : 6
                },
                newpassword : {
    				required: true,     
                    minlength : 6            
                },
                 confirmpassword : {
    				required: true,
                    equalTo : "#newpassword"
                }
		},
		// Specify validation error messages
		messages: {
			currentpassword: {
    				required: 'Old password field is required',
    				minlength: 'Please enter minimum 6 length password'
    			},
    			newpassword: {
    				required: 'New password field is required',
                    minlength: 'Please enter minimum 6 length password'                  
    			},
                confirmpassword: {
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

@stop

















