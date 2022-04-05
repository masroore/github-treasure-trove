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
						Add Owner Detail
						<a href="{{route('owners.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('owner.create')}}" method="post" class="user" id="add_owner_form" enctype="multipart/form-data">@csrf

						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>First Name<span class="required">*</span>
									</label>
									<input type="text" name="first_name" id="first_name" value="{{old('first_name')}}" class="form-control form-control-user" />
									@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Last Name<span class="required">*</span>
									</label>
									<input type="text" name="last_name" id="last_name" value="{{old('last_name')}}" class="form-control form-control-user" />
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
									<input type="text" name="email" id="email"  value="{{old('email')}}" class="form-control form-control-user" />
									@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
							<div class="form-group">
									<label>Contact No.<span class="required">*</span>
									</label>
									<input type="number" name="mobile" minlength="10" maxlength="12" id="mobile"  value="{{old('mobile')}}" class="form-control form-control-user" />
									@if ($errors->has('mobile'))
										<span class="text-danger">{{ $errors->first('mobile') }}</span>
									@endif
								</div>
							</div>
						</div>
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
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Zipcode<span class="required">*</span>
									</label>
									<input type="text" name="zipcode" id="zipcode"  value="{{old('zipcode')}}" class="form-control form-control-user" />
									@if ($errors->has('zipcode'))
										<span class="text-danger">{{ $errors->first('zipcode') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
							<div class="form-group">
									<label>Address<span class="required"></span>
									</label>
									<textarea  name="address" id="address" class="form-control form-control-user" />{{old('address')}}</textarea>
									@if ($errors->has('address'))
										<span class="text-danger">{{ $errors->first('address') }}</span>
									@endif
								</div>
							</div>
						</div>

						<!-- <div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Status<span class="required">*</span>
									</label>
									<div class="input-group">
										<div id="radioBtn" class="btn-group">
											<a class="btn btn-success btn-sm {{  old('status') == '1' ? 'active' : (old('status') =='0' ? 'notActive' : 'active') }}" data-toggle="status" data-title="1">Enabled</a>
											
											<a class="btn btn-danger btn-sm {{ old('status') == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										{{old('status')}}
										<input type="hidden" name="status" id="status" value="{{old('status') == '1' ?'1' :'0'}}">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div> -->
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" name="action" value="saveadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit"  name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
								<a href="{{route('owners.list')}}" class="btn btn-light">Cancel</a>
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
			$("form[id='add_owner_form']").validate({
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
					password : {
						required: true,
						minlength : 6
                	},
               		 password_confirmation : {
						required: true,
						equalTo : "#password"
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
						lettersonly: 'First name should contains letters only',

					},
					last_name: {
						required: 'Last name is required',
						lettersonly: 'Last name should contains letters only',
					},
					email: {
						required: 'Email address is required',
						email: 'Provide a valid email address',
					},
					password: {
						required: 'Password field is required',
						minlength: 'Please enter minimum 6 length password'
					},
					password_confirmation: {
						required: 'Confirm Password field is required',
						equalTo : "Confirm Password must be same as password"
					},
					mobile:{
						required: 'Contact no is required',
						number: 'Contact no must be number only',
						maxlength: 'Contact no should be of 10 to 12 digit',
						minlength: 'Contact no should be of 10 to 12 digit',
					},
					zipcode:{
						required: 'Zipcode is required',
						number: 'Zipcode must be number only'
					},
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
	@stop