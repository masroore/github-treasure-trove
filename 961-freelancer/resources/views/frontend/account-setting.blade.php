@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	.dragBox {
	  width: 100%;
	  height: 56px;
	  margin: 0 auto;
	  position: relative;
	  text-align: center;
	  font-weight: bold;
	  line-height: 57px;
	  color: #999;
	  /*border: 2px dashed #ccc;*/
	  display: inline-block;
	  transition: transform 0.3s;
	}
	.dragBox input[type="file"] {
    position: absolute;
    height: 100%;
    width: 100%;
    opacity: 0;
    top: 0;
    left: 0;
  }
	.draging {
	  transform: scale(1.1);
	}
	#preview {
	  text-align: center;
	}
	#preview img {
	  max-width: 100%
	}
	#message{
	  display: none;
	  padding: 10px 0;
	}
	.invalid{
	  color: #ed1c24;
	}
	.valid{
	  color: #00a651;
	}
	#strengthMessage{
	  margin: 15px 0;
	}
	.Short {  
	    width: 100%;  
	    background-color: #dc3545;  
	    margin-top: 5px;  
	    height: 4px;  
	    color: #dc3545;  
	    font-weight: 500;  
	    font-size: 12px;  
	}  
	.Weak {  
	    width: 100%;  
	    background-color: #ffc107;  
	    margin-top: 5px;  
	    height: 4px;  
	    color: #ffc107;  
	    font-weight: 500;  
	    font-size: 12px;  
	}  
	.Good {  
	    width: 100%;  
	    background-color: #28a745;  
	    margin-top: 5px;  
	    height: 4px;  
	    color: #28a745;  
	    font-weight: 500;  
	    font-size: 12px;  
	}  
	.Strong {  
	    width: 100%;  
	    background-color: #d39e00;  
	    margin-top: 5px;  
	    height: 4px;  
	    color: #d39e00;  
	    font-weight: 500;  
	    font-size: 12px;  
	}
</style>
@endsection
@section('content')
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			<section class="wt-haslayout wt-dbsectionspace">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
							<div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
								<div class="wt-dashboardtabs">
									<ul class="wt-tabstitle nav navbar-nav" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="active" id="wt-password-tab" data-bs-toggle="pill" data-bs-target="#wt-password" type="button" role="tab" aria-controls="wt-password" aria-selected="true">Password</a>
										</li>
										<li class="nav-item d-none">
											<a class="" id="wt-emailnoti-tab" data-bs-toggle="pill" data-bs-target="#wt-emailnoti" type="button" role="tab" aria-controls="wt-emailnoti" aria-selected="true">Email Notifications</a>
										</li>
										<li class="nav-item">
											<a class="" id="wt-verify-tab" data-bs-toggle="pill" data-bs-target="#wt-verify" type="button" role="tab" aria-controls="wt-verify" aria-selected="true">Account Verification</a>
										</li>
										<li class="nav-item d-none">
											<a class="" id="wt-deleteaccount-tab" data-bs-toggle="pill" data-bs-target="#wt-deleteaccount" type="button" role="tab" aria-controls="wt-deleteaccount" aria-selected="true">Delete Account</a>
										</li>
									</ul>
								</div>
								<div class="wt-tabscontent tab-content" id="nav-tabContent">
									<div class="wt-passwordholder tab-pane fade active show" id="wt-password" role="tabpanel" aria-labelledby="wt-password-tab">
										<div class="wt-changepassword">
											<div class="wt-tabscontenttitle">
												<h2>Change Your Password</h2>
											</div>
											@if(Session::has('verify'))
											<div class="alert alert-success">
											  {{ Session::get('verify') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											@if(Session::has('resetAlert'))
											<div class="alert alert-danger">
											  {{ Session::get('resetAlert') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											
											@if(Session::has('resetSuccess'))
											<div class="alert alert-success">
											  {{ Session::get('resetSuccess') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 30px;margin-top: 59px;color: black;">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											<form class="wt-formtheme wt-userform" action="{{ url('/reset-password') }}" method="post">
												@csrf
												@if ($errors->any())
												<div class="alert alert-danger">
												  <ul>
												    @foreach ($errors->all() as $error)
												    <li>{{ $error }}</li>
												    @endforeach
												  </ul>
												</div>
												@endif
												<input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
												<fieldset>
													<div class="form-group form-group-half">
														<input type="password" id="current-password" name="password" class="form-control" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*_=+-]).{8,}" title="Must contain at least one number and one uppercase and one special charater and lowercase letter, and at least 8 or more characters">
														@if ($errors->has('current-password'))
														<span class="help-block">
														  <strong>{{ $errors->first('current-password') }}</strong>
														</span>
														@endif
														<div id="strengthMessage"></div>
														<div id="message">
														  <!-- <h3>Password must contain the following:</h3> -->
														  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
														  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
														  <p id="number" class="invalid">A <b>number</b></p>
														  <p id="special" class="invalid">A <b>Special charater</b></p>
														  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
														</div>
													</div>
													<div class="form-group form-group-half">
														<input type="password" id="confirm_pass" name="confirm_password" class="form-control" placeholder="Confirm Password">
														@if ($errors->has('new-password'))
														<span class="help-block">
														  <strong>{{ $errors->first('new-password') }}</strong>
														</span>
														@endif
														<span id="match" class="pl-3"></span>
													</div>
													<!-- <div class="form-group">
														<span class="wt-checkbox">
															<input id="termsconditions" type="checkbox" name="termsconditions" value="termsconditions" checked="">
															<label for="termsconditions"><span>Logout from all other web/mobile session now.</span></label>
														</span>
													</div> -->
													<div class="form-group mt-4 text-end">
														<button class="wt-btn" type="submit">Update Password</button>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
									<div class="wt-emailnotiholder tab-pane fade" id="wt-emailnoti" role="tabpanel" aria-labelledby="wt-emailnoti-tab">
										<div class="wt-emailnoti">
											<div class="wt-tabscontenttitle">
												<h2>Manage Email Notifications</h2>
											</div>
											<div class="wt-settingscontent">
												<div class="wt-description">
													<p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua aut enim ad minim veniamac quis nostrud exercitation ullamco laboris.</p>
												</div>
												<form class="wt-formtheme wt-userform">
													<fieldset>
														<div class="form-group form-disabeld">
															<input type="password" name="password" class="form-control" placeholder="youremail@domainurl.com" disabled="">
														</div>
													</fieldset>
												</form>
												<ul class="wt-accountinfo">
													<li>
														<div class="wt-on-off">
															<input type="checkbox" id="hide-onemail" name="contact_form">
															<label for="hide-onemail"><i></i></label>
														</div>
														<span>Send me Email notification</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- Account Verification -->
									<div class="wt-verifyholder tab-pane fade" id="wt-verify" role="tabpanel" aria-labelledby="wt-verify-tab">
										<div class="wt-verify">
											<div class="wt-tabscontenttitle">
												<h2>Verify Your Account</h2>
											</div>
											<div class="wt-settingscontent">
												<div class="alert alert-success d-none" id="verification_message">Your verification request submitted. Admin will review your request within 24 hours.</div>
												<form class="wt-formtheme wt-userform" id="verificationForm" enctype="multipart/form-data">
													@csrf
													<fieldset>
														<div class="form-group form-group-label">
															<label class="pb-2">Upload ID/Passport:</label>
															<div class="wt-labelgroup">
																<label for="uploadFile"  class="dragBox w-100">
																	<input type="file" name="verification_image" id="uploadFile"onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile" class="d-block">
																	Drag or upload your ID/Passport 
																</label>
															</div>
														</div>
								  					<div class="form-group mb-3">
								  						<ul class="wt-attachfile wt-attachfilevtwo">
								  							<li class="wt-uploadingholder w-100">
								  								<div class="wt-uploadingbox">
								  									<div class="wt-designimg">
								  										<label for="demoz"  id="preview">
								  											@if(Auth::user()->verification_image)
											                    <img src="{{asset('assets/images/user/verification/'.Auth::user()->verification_image)}}" alt="">
								  											@else
								  											<img src="{{asset('assets/images/user/verification/id_sample.jpg')}}" alt="img description" id="profile">
								  											@endif
								  										</label>
								  									</div>
								  									<div class="wt-uploadingbar">
								  										<span id="img_name" class="text-break text-wrap">{{Auth::user()->verification_image}}</span>
								  									</div>
								  								</div>
								  							</li>
								  						</ul>
								  					</div>
													</fieldset>
													<div class="form-group mb-3 text-end">
														<button class="wt-btn" type="submit">Submit Request</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="wt-accountholder tab-pane fade" id="wt-deleteaccount" role="tabpanel" aria-labelledby="wt-deleteaccount-tab">
										<div class="wt-accountdel">
											<div class="wt-tabscontenttitle">
												<h2>Delete Account</h2>
											</div>
											<form class="wt-formtheme wt-userform">
												<fieldset>
													<div class="form-group form-group-half">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
													<div class="form-group form-group-half">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
													<div class="form-group">
														<span class="wt-select">
															<select>
																<option value="" disabled="">Select Reason to Leave</option>
																<option value="">Reason</option>
																<option value="">Reason</option>
															</select>
														</span>
													</div>
													<div class="form-group">
														<textarea name="message" class="form-control" placeholder="Description (Optional)"></textarea>
													</div>
													<!-- <div class="form-group form-group-half float-right">
														<span class="wt-checkbox">
															<input id="termsconditions1" type="checkbox" name="termsconditions" value="termsconditions">
															<label for="termsconditions1"><span>Unsubscribe me from all newsletter list</span></label>
														</span>
													</div> -->
													<div class="form-group form-group mt-4 text-end wt-btnarea">
														<a href="javascript:void(0);" class="wt-btn">Delete Account</a>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="wt-updatall">
								<i class="ti-announcement"></i>
								<span>Update all the latest changes made by you, by just clicking on “Save &amp; Continue” button.</span>
								<a class="wt-btn" href="javascript:void(0);">Save &amp; Continue</a>
							</div> -->
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3"></div>
					</div>
				</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
<script>
  $('#confirm_pass').on('keyup', function () {
    if ($('#current-password').val() == $('#confirm_pass').val()) {
      $('#match').html('Password Match').css('color', 'green');
    } else 
      $('#match').html('Password Not Matching').css('color', 'red');
  });

  function dragNdrop(event) {
      var fileName = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("preview");
      var previewImg = document.createElement("img");
      previewImg.setAttribute("src", fileName);
      preview.innerHTML = "";
      preview.appendChild(previewImg);

      var filename = $('#uploadFile').val().split('\\').pop();
      $('#img_name').html(filename);
  }
  function drag() {
      document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
  }
  function drop() {
      document.getElementById('uploadFile').parentNode.className = 'dragBox';
  }

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });


  $('#verificationForm').submit(function(event){
		event.preventDefault();
  	$.ajax({
      url: "{{url('verification-request')}}",
      type: 'POST',
      data: new FormData(this),
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,

      success: (response)=>{
          if (response.status == 'true') {
              $.notify(response.message , 'success'  );
                // window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/account-setting/";
              $('#wt-password-tab').removeClass('active');
              $('#wt-password').removeClass('active show');
              $('#wt-verify-tab').addClass('active');
              $('#wt-verify').addClass('active show');
              $('#verification_message').removeClass('d-none');
              
              
          }else{
              $.notify(response.message , 'error');

          }
      },
      error: (errorResponse)=>{
          $.notify( errorResponse, 'error'  );


      }
  	})
  })

     var myInput = document.getElementById("current-password");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var special = document.getElementById("special");
  var length = document.getElementById("length");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  }

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  }

  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(myInput.value.match(lowerCaseLetters)) {  
      letter.classList.remove("invalid");
      letter.classList.add("valid");
    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
    }
    
    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(myInput.value.match(upperCaseLetters)) {  
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {  
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }
    // Special numbers
    var specials = /[!@#$%^&*_=+-]/g;
    if(myInput.value.match(specials)) {  
      special.classList.remove("invalid");
      special.classList.add("valid");
    } else {
      special.classList.remove("valid");
      special.classList.add("invalid");
    }
    
    // Validate length
    if(myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  }

  $('#current-password').keyup(function () {  
         $('#strengthMessage').html(checkStrength($('#current-password').val()))  
  })  
     function checkStrength(password) {  
         var strength = 0  
         if (password.length < 6) {  
             $('#strengthMessage').removeClass()  
             $('#strengthMessage').addClass('Short')  
             return 'Too short'  
         }  
         if (password.length > 7) strength += 1  
         // If password contains both lower and uppercase characters, increase strength value.  
         if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1  
         // If it has numbers and characters, increase strength value.  
         if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1  
         // If it has one special character, increase strength value.  
         if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
         // If it has two special characters, increase strength value.  
         if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
         // Calculated strength value, we can return messages  
         // If value is less than 2  
         if (strength < 2) {  
             $('#strengthMessage').removeClass()  
             $('#strengthMessage').addClass('Weak')  
             return 'Weak'  
         } else if (strength == 2) {  
             $('#strengthMessage').removeClass()  
             $('#strengthMessage').addClass('Good')  
             return 'Good'  
         } else {  
             $('#strengthMessage').removeClass()  
             $('#strengthMessage').addClass('Strong')  
             return 'Strong'  
         }  
    }
    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);
    if(activeTab == 'verify_account'){
    // alert(activeTab);
    	$('#wt-password-tab').removeClass('active');
    	$('#wt-verify-tab').addClass('active');
    	$('#wt-password').removeClass('show active');
    	$('#wt-verify').addClass('show active');
    }
    
    // wt-verify-tab
</script>
@endsection