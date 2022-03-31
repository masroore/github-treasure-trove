@extends('frontend.layouts.app')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/intlTelInput.min.css')}}">
<style>
  .iti__divider,.iti__country{
    list-style: none;
  }
  .iti{
    width: 100%;
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
@section('content')
<section class="login-signup">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-md-8">
				<div class="login-signup-wrapper signup-wrapper">
          <div class="login-signup-header border-bottom">
            <h3 class="text-center">Sign Up to 961 Freelancer</h3>
            <!-- <p class="text-center">Already have an account? <a href="{{ route('login') }}">Log In</a></p> -->
          </div>
          <div class="login-with-credentials">
            <form action="{{url('/register')}}" method="POST" id="registerForm"  class="bv-form">
              @if ($errors->any())
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
              @endif
              
              @if(session()->has('registerSuccess'))
                  <div class="alert alert-success">
                      {{ session()->get('registerSuccess') }}
                  </div>
              @endif
              @csrf
              <div class="mb-3 has-error">
                <label class="control-label">Username</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="Enter Your Username" pattern="\S(?!.*_.*_)[a-zA-Z_.]*" value="{{old('username')}}" onkeyup="ValidateUsername()" required="">
                 <div class="invalid-feedback">
                   Please enter Username.
                </div>
                <span id="lblError" style="color: red"></span>
                <span id="username_exist" style="color: red"></span>
                <!-- <span class="form-text text-danger" id="space_error"></span><br> -->
                <!-- <small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
                <span class="form-text text-danger" id="space_error"></span>
                <small class="help-block" data-bv-validator="regexp" data-bv-for="u_name" data-bv-result="INVALID" style="">Spaces or dots are not allowed in username.</small> -->
              </div>
              <div class="mb-3">
              	<label class="control-label">YOUR EMAIL ADDRESS</label>
              	<input class="form-control" type="email" name="email" placeholder="Enter Email" value="{{old('email')}}" id="email" required="">
              	<div class="invalid-feedback">
                    Please enter email.
                </div>
              </div>
              <div class="mb-3">
                <label class="control-label">Date of Birth</label>
                <input class="form-control" type="date" name="age" placeholder="Enter Date of birth" value="{{old('age')}}" id="age" required="">
                <div class="invalid-feedback">
                    Please enter date of birth.
                </div>
              </div>
              <div class="mb-3">
                <label class="control-label">Country</label>
                <select class="form-control chosen-select" name="country" id="country" required="">
                  @foreach($countries as $country)
                  <option value="{{$country->name}}" data-code="{{$country->phonecode}}">{{$country->name}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select country.
                </div>
              </div>
          
              <div class="mb-3">
              	<label class="control-label">Phone No.</label>
                <div class="input-group">
                  <input type="text" class="ps-0 pe-0 text-center bg-light fw-bold" name="phone_code" value="93" style="width: 80px;height: 60px;" readonly="" id="phoneCode">
                  <input type="number" class="form-control" name="mobile_number" placeholder="Enter Phone No." value="{{old('mobile_number')}}" required>
                </div>
                
              	<!-- <input class="form-control" type="text" name="mobile_number" id="phone" placeholder="Enter Phone No."> -->
              	<div class="invalid-feedback">
                  Please enter mobile.
                </div>
              </div>
                 
              <div class="mb-3 has-error">
              	<label class="control-label">Password</label>
                <div class="position-relative" id="show_hide_password">
              	  <input class="form-control" type="password" name="password" id="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*_=+-]).{8,}" title="Must contain at least one number and one uppercase and one special charater and lowercase letter, and at least 8 or more characters">
                  <span class="position-absolute bg-transparent" id="pswrd-show">
                    <a href="javascript:void(0)"><i class="fa fa-eye-slash text-muted" aria-hidden="true"></i></a>
                  </span>
                </div>
              	<div class="invalid-feedback">
                  Please enter password.
                </div>
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
              <div class="mb-3">
              	<label class="control-label"> Confirm Password: </label>
              	<input type="password" class="form-control" id="confirm_pass" name="con_pass" placeholder="Confirm Password" required="">
              	<span class="form-text text-danger"></span>
              	<span id="match" class="pl-3"></span>
              </div>
              
              <div class="row">
                <div class="col-12">
                  <label class="control-label">ACCOUNT TYPE</label>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="customRadio1" class="custom-control custom-radio">
                      <input type="radio" hidden id="customRadio1" name="account_type" class="custom-control-input" value="Client">
                      <div class="custom-control-label">Client</div>
                    </label>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="customRadio2" class="custom-control custom-radio">
                      <input type="radio" hidden id="customRadio2" name="account_type" class="custom-control-input" value="Freelancer">
                      <div class="custom-control-label">Freelancer</div>
                    </label>
                  </div>
                </div>
                <div class="invalid-feedback">
                   Please select your account type.
                </div>
              </div>
              <div class="mb-3">
              	<button class="login-button w-100 text-white" type="submit" name="register" disabled="">Sign up</button>
              </div>
            </form>
            <div class="divider">
            	<p><span>or</span></p>
            </div>
          </div>
          <div class="login-by-social d-flex flex-column flex-lg-row align-items-center justify-content-center">
            <a class="social-button facebook d-flex flex-row align-items-center" href="{{url('login/facebook')}}">
             	<span><i class="fab fa-facebook-f"></i></span>
             	<span>Sign up with Facebook</span>
            </a>
            <a class="social-button google d-flex flex-row align-items-center" href="{{url('login/google')}}">
              <span><i class="fab fa-google"></i></span>
              <span>Sign up with Google</span>
            </a>
          </div>
          <div class="login-signup-header">
            <!-- <h3 class="text-center">Sign Up to 961 Freelancer</h3> -->
            <p class="text-center">Already have an account? <a href="{{ route('login') }}">Log In</a></p>
          </div>
      	</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script src="{{asset('assets/js/intlTelInput.min.js')}}"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var myInput = document.getElementById("password");
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

  $('#password').keyup(function () {  
         $('#strengthMessage').html(checkStrength($('#password').val()))  
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

    $("input[name='username']").keyup(function(e) {   
       if (e.which === 32)  {
         // alert('you entered space');
         $("#space_error").html("Username should not have space, please try another one");
       }
    });

  $('#submit-btn').click(function(){
    var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
    $("input[name='whatsappNumber'").val(full_number);

    
    if($('#username').val() == ""){
      $('#username').addClass('is-invalid');
      $('#username').attr("required", "true");
    }else{
      $('#username').addClass('is-valid');
    }
    if($('#email').val() == ""){
      $('#email').addClass('is-invalid');
      $('#email').attr("required", "true");
    }else{
      $('#email').addClass('is-valid');
    }
    if($('#phone').val() == ""){
      $('#phone').addClass('is-invalid');
      $('#phone').attr("required", "true");
    }else{
      $('#phone').addClass('is-valid');
    }
    if($('#password').val() == ""){
      $('#password').addClass('is-invalid');
      $('#password').attr("required", "true");
    }else{
      $('#password').addClass('is-valid');
    }
    if($('input[name=""]').val() == ""){
      $('#password').addClass('is-invalid');
      $('#password').attr("required", "true");
    }else{
      $('#password').addClass('is-valid');
    }
  });

  var empty = $(".is-invalid").filter(function() { return !this.value; })
                                  .next(".invalid-feedback").show();
  $('#confirm_pass').on('keyup', function () {
    if ($('#password').val() == $('#confirm_pass').val()) {
      $('#match').html('Password Match').css('color', 'green');
      $('.login-button').removeAttr('disabled');
      // $('.login-button').prop('disabled', false);
    } else {
      $('#match').html('Password Not Matching').css('color', 'red');
      // $('.login-button').addAttr('disabled');
      $('.login-button').attr('disabled','true');
    }
  });

  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
  }
  for (var selector in config) {
    jQuery(selector).chosen(config[selector]);
  }

  // function getCountry(country){
  //   alert(country.find(':selected').data('id'));
  // }
  $('#country').change(function(){
    // alert($(this).find(':selected').data('code'));
    $('#phoneCode').val($(this).find(':selected').data('code'));
  });

  function ValidateUsername() {
      var username = document.getElementById("username").value;
      var lblError = document.getElementById("lblError");
      lblError.innerHTML = "";
      var expr = /^\S(?!.*_.*_)[a-zA-Z_.]*$/;
      if (!expr.test(username)) {
          lblError.innerHTML = "Only Alphabets, one Underscore allowed in Username.";
      }
  }
  $("#show_hide_password a").on('click', function(event) {
    event.preventDefault();
    if($('#show_hide_password input').attr("type") == "text"){
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass( "fa-eye-slash" );
        $('#show_hide_password i').removeClass( "fa-eye" );
    }else if($('#show_hide_password input').attr("type") == "password"){
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass( "fa-eye-slash" );
        $('#show_hide_password i').addClass( "fa-eye" );
    }
  });

  $('#username').on('keyup', function(e){
    e.preventDefault();
    var username = this.value;
    // alert(username);
    $.ajax({
      url: "{{url('username-check')}}",
      type: 'post',
      data: {username:username},
      cache : false,
      success:function(response){
        if (response.status == 'true') {
          $('#username_exist').removeClass('d-none');
          $('#username_exist').html(response.message);
        }else{
          $('#username_exist').addClass('d-none');
        }
        // console.log(data);
        // $("#listings-container").html(data);
      }
    });
  })
</script>
@endsection