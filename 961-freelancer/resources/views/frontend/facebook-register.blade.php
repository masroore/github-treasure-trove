@extends('frontend.layouts.app')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/intlTelInput.min.css')}}">
<style>
  .iti__divider,.iti__country{
    list-style: none;
  }
  .iti{
    width: 100%;
  }
  .fb_profile_image{
    width: 220px;
    height: 220px;
    border-radius: 50%;
    margin: 0 auto;
    border: 2px solid #00a651; 
    text-align: center;
  }
  .fb_profile_image img{
    border-radius: 50%;
    height: 215px;
    width: 215px;
    margin: 0 auto;
  }
</style>
@section('content')
<section class="login-signup">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-md-8">
				<div class="login-signup-wrapper signup-wrapper">
          <div class="login-signup-header border-bottom">
            <h3 class="text-center mb-0">Facebook Register</h3>
            <!-- <p class="text-center">Already have an account? <a href="{{ route('login') }}">Log In</a></p> -->
          </div>
          <div class="login-with-credentials">
            <form action="{{url('facebook/register')}}" method="POST" id="registerForm"  class="bv-form">
              @if ($errors->any())
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
              @endif
              <div class="fb_profile_image">
                <img src="{{$user->avatar_original}}">
              </div>
              @csrf
                <input type="hidden" name="username" value="{{$username}}">
              	<input type="hidden" name="email" value="{{$user->email}}">
                <input type="hidden" name="first_name" value="{{$user->name}}">
                <input type="hidden" name="last_name" value="">
                <input type="hidden" name="facebook_id" value="{{$user->id}}">
                <input type="hidden" name="profile_image" value="{{$user->avatar_original}}">
              <!-- <div class="mb-3">
              	<label class="control-label">Phone No.</label>
              	<input class="form-control" type="text" name="mobile_number" id="phone" placeholder="Enter Phone No.">
              	<div class="invalid-feedback">
                  Please enter mobile.
                </div>
              </div> -->
                 
              <div class="mb-3 has-error">
              	<label class="control-label">Password</label>
              	<input class="form-control" type="password" name="password" id="password" placeholder="Enter Password">
              	<div class="invalid-feedback">
                  Please enter password.
                </div>
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
              	<button class="login-button w-100 text-white" type="submit" name="register">Sign up</button>
              </div>
            </form>
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
var phone_number = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  hiddenInput: "full",
  utilsScript: "assets/js/utils.js"
  excludeCountries: ["il"]
});
  // var input = document.querySelector("#phone");
  // window.intlTelInput(input, {
  //   // allowDropdown: false,
  //   // autoHideDialCode: false,
  //   // autoPlaceholder: "off",
  //   // dropdownContainer: document.body,
  //   // excludeCountries: ["us"],
  //   // formatOnDisplay: false,
  //   // geoIpLookup: function(callback) {
  //   //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
  //   //     var countryCode = (resp && resp.country) ? resp.country : "";
  //   //     callback(countryCode);
  //   //   });
  //   // },
  //   // hiddenInput: "full_number",
  //   // initialCountry: "auto",
  //   // localizedCountries: { 'de': 'Deutschland' },
  //   // nationalMode: false,
  //   // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
  //   // placeholderNumberType: "MOBILE",
  //   // preferredCountries: ['cn', 'jp'],
  //   separateDialCode: true,
  //   utilsScript: "js/utils.js",
  // });

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
    } else 
      $('#match').html('Password Not Matching').css('color', 'red');
  });
</script>
@endsection