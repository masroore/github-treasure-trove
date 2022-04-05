@extends('user.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Update Profile</h1>
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
                        Update Profile
                       
                    </h5>
                    <form action="{{route('update.details')}}" method="post" class="user" id="update_profile_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="userid" value="@if(Auth::user()){{ $userDetail->id }}@endif">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>First Name<span class="required">*</span></label>
                                    <input type="text" name="first_name" id="first_name" value="{{old('first_name',$userDetail->first_name)}}" class="form-control form-control-user"  />
                                    @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Last Name<span class="required">*</span></label>
                                    <input type="text" name="last_name" id="last_name" value="{{old('last_name',$userDetail->last_name)}}" class="form-control form-control-user"  />
                                    @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email<span class="required">*</span></label>
                                    <input type="text" name="email" id="email" value="{{old('email',$userDetail->email)}}" class="form-control form-control-user"  />
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Contact<span class="required">*</span></label>
                                    <input type="number" name="mobile" min="0" minlength="10" maxlength="12" id="mobile" value="{{old('mobile', isset($userDetail->user_detail->mobile) ? $userDetail->user_detail->mobile: "")}}" class="form-control form-control-user"  />
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Zipcode<span class="required"></span></label>
                                    <input type="number" min="0" name="zipcode" id="zipcode" value="{{old('zipcode', isset($userDetail->user_detail->zipcode) ? $userDetail->user_detail->zipcode : "")}}" class="form-control form-control-user"  />
                                    @if ($errors->has('zipcode'))
                                    <span class="text-danger">{{ $errors->first('zipcode') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Country<span class="required"></span></label>
                                    <input type="text" name="country" id="country" value="{{old('country', isset($userDetail->user_detail->country) ? $userDetail->user_detail->country : "")}}" class="form-control form-control-user"  />
                                    @if ($errors->has('country'))
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>City<span class="required"></span></label>
                                    <input type="text" name="city" id="city" value="{{old('city', isset($userDetail->user_detail->city) ? $userDetail->user_detail->city : "")}}" class="form-control form-control-user"  />
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address<span class="required"></span></label>
                                    <textarea name="address" id="address" value="{{old('address')}}" class="form-control form-control-user" />{{old('address', isset($userDetail->user_detail->address)?$userDetail->user_detail->address:"")}}</textarea>
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>                           
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Profile Photo<span class="required"></span></label>                
									<input type="file" name="profile_picture" id="profile_picture"  value="{{old('profile_picture',isset($userDetail->user_detail->profile_picture) ? $userDetail->user_detail->profile_picture : '')}}"  class="form-control form-control-user"/>
                                    @if ($errors->has('profile_picture'))
                                        <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 images-sections">
								<div class="form-group">
                                @if(session()->has('userdetails'))
								    @php
									$userdata = session()->get('userdetails');
									@endphp	
                                    @if($userdata["profile_picture"] !="" && $userdata['imagetype'] != "")
                                        <img class="img-profile mt30" width="100" height="100" src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}" alt="Profile Photo">
                                        <a href="{{route('profilephoto.remove')}}">
												<img src="{{asset('backend/images/cross-icon.png')}}" alt="Remove Photo" class="cross-section">
                                        </a>
                                    @else
                                    <img class="img-profile rounded-circle" src="{{asset('frontend/images/dummyprofile.jpg')}}">
                                    @endif
								@else
								    <img class="img-profile rounded-circle" src="{{asset('frontend/images/dummyprofile.jpg')}}">
								@endif
								</div>
							</div>                           
                        </div>
                        <div class="mt-1 mb-1">
                            <div class="text-left d-print-none mt-4">
                                <button type="submit" id="save-membershipplan-btn" class="btn btn-primary">Update Profile</button>
                                <a href="{{route('userdashboard')}}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container-fluid -->
@endsection
@section('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script>
    $( document ).ready(function() {
    	$("form[id='update_profile_form']").validate({
    		// Specify validation rules
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
                    country: {						
						lettersonly :true
					},
                    city: {						
						lettersonly :true
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
					mobile:{
						required: 'Contact no is required',
						number: 'Contact must be digit only',
                        maxlength: 'Contact no should be of 10 to 12 digit',
						minlength: 'Contact no should be of 10 to 12 digit',
					},
                    country: {						
						lettersonly: 'Country should contains letters only',
					},
                    city: {						
						lettersonly: 'City should contains letters only',
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