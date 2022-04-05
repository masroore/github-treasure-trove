@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Users List</h1>
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
						Update User Detail
						<a href="{{route('users.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('user.update')}}" method="post" class="user" id="edit_user_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="edit_record_id" value="{{$userDetail->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>First Name<span class="required">*</span>
									</label>
									<input type="text" name="first_name" id="first_name" value="{{old('first_name', $userDetail->first_name)}}" class="form-control form-control-user" />
									@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Last Name<span class="required">*</span>
									</label>
									<input type="text" name="last_name" id="last_name" value="{{old('last_name', $userDetail->last_name)}}" class="form-control form-control-user" />
									@if ($errors->has('last_name'))
										<span class="text-danger">{{ $errors->first('last_name') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Email<span class="required">*</span>
									</label>
									<input type="text" name="email" id="email"  value="{{old('email', $userDetail->email)}}" class="form-control form-control-user" />
									@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Contact No.<span class="required">*</span>
									</label>
									<input type="number" min="0" name="mobile" id="mobile" minlength="10" maxlength="12"  value="{{old('mobile', isset($userDetail->user_detail->mobile) ? $userDetail->user_detail->mobile: "")}}" class="form-control form-control-user" />
									@if ($errors->has('mobile'))
										<span class="text-danger">{{ $errors->first('mobile') }}</span>
									@endif
								</div>
							</div>

						</div>
						<div class="row">

							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Zipcode<span class="required">*</span>
									</label>
									<input type="number" min="0" name="zipcode" id="zipcode"  value="{{old('zipcode', isset($userDetail->user_detail->zipcode) ? $userDetail->user_detail->zipcode : "")}}" class="form-control form-control-user" />
									@if ($errors->has('zipcode'))
										<span class="text-danger">{{ $errors->first('zipcode') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Address<span class="required"></span>
									</label>
									<textarea  name="address" id="address" class="form-control form-control-user" />{{old('address', isset($userDetail->user_detail->address)?$userDetail->user_detail->address:"")}}</textarea>
									@if ($errors->has('address'))
										<span class="text-danger">{{ $errors->first('address') }}</span>
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
										<div id="radioBtn" class="btn-group">
										    <a class="btn btn-success btn-sm {{ old('status', $userDetail->status) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status', $userDetail->status) == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="{{ old('status',$userDetail->status) == '1' ? '1' : '0'}}">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="edit-genre-btn" class="btn btn-primary">Update</button>
								<a href="{{route('users.list')}}" class="btn btn-light">Cancel</a>
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
			$("form[id='edit_user_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					first_name: {
						required: true,
						lettersonly :true
					},
					last_name: {
						required: true,
						lettersonly :true
					},
					email: {
						required: true,
						email: true,
					},
					mobile: {
						required: true,
						number: true,
						maxlength: 12,
						minlength: 10,
					},
					zipcode: {
						required: true,
						number: true,
					},

				},
				// Specify validation error messages
				messages: {
					first_name: {
						required: 'First name is required',
						lettersonly: 'First name should contain letters only',
					},
					last_name: {
						required: 'Last name is required',
						lettersonly: 'Last name should contain letters only',
					},
					email: {
						required: 'Email address is required',
						email: 'Provide a valid email address',
					},
					mobile:{
						required: 'Contact no is required',
						number: 'Contact no must be number only',
						maxlength: 'Contact no should be of 10 to 12 digit',
						minlength: 'Contact no should be of 10 to 12 digit',
					},
					zipcode:{
						required: 'Zipcode is required',
						number: 'Zipcode must be number only',
					},

				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
	@stop