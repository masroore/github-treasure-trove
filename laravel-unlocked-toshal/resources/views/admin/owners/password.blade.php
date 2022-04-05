@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Owners List</h1>
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
                        Update Password
                        <a href="{{route('owners.list')}}" class="float-right"><i data-feather="x"></i></a>
                    </h5>
                    <form action="{{route('owner.updatepassword')}}" method="post" class="user" id="update_password_form" >
                        @csrf
                        <input type="hidden" name="edit_record_id" value="{{$id}}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Password<span class="required">*</span></label>
                                    <input type="password" name="password" id="password" value="{{old('password')}}" class="form-control form-control-user"  />
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Confirm Password<span class="required">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" value="{{old('password_confirmation')}}" class="form-control form-control-user"  />
                                    @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 mb-1">
                            <div class="text-left d-print-none mt-4">
                                <button type="submit" id="save-membershipplan-btn" class="btn btn-primary">Update Password</button>
                                <a href="{{route('owners.list')}}" class="btn btn-light">Cancel</a>
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
<script>
    $( document ).ready(function() {
    	$("form[id='update_password_form']").validate({
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
                    equalTo : "Confirm Password must be same as password"
    			}
    		},
    		submitHandler: function(form) {
    			form.submit();
    		}
    	});
    });
</script>
@stop