@extends('frontend.layouts.app')
@section('title', 'Change Password')
@section('styling')
<style>
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
<div class="container">
  <!-- <div class="outer-box left-side">
    <div class="inner-box">
      <div class="img-container">
        <img src="{{asset('images/sign-up-bg.jpg')}}" alt="">
      </div>

      <div class="logo-and-text">
        <img src="{{asset('images/logo-white.svg')}}" alt="">
        <p>Find The Perfect Services
          with Engezly For Your Business</p>
      </div>
    </div>
  </div> -->
  <div class="row outer-box right-side d-flex justify-content-center my-5 py-4">
    <div class="inner-box col-md-4 shadow p-3 rounded login-with-credentials">
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
      <form action="{{ url('/reset-password') }}" method="post" class="form">
        @csrf
        <h4 class="text-center mb-3">Change Your Password</h4>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <!-- <p class="reset-text">Please enter your phone number and you will receive a link to reset your password</p> -->
        <input type="hidden" value="{{ $usersData->id }}" name="user_id">
        <div class="form-group mb-3">
          <label for="">Password</label>
          <input type="password" class="form-control" id="current-password" name="password" placeholder="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*_=+-]).{8,}" title="Must contain at least one number and one uppercase and one special charater and lowercase letter, and at least 8 or more characters">
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
        <div class="form-group mb-3">
          <label>Confirm Password</label>

          <input type="password" class="form-control" id="confirm_pass" name="confirm_password" required>

          @if ($errors->has('new-password'))
          <span class="help-block">
            <strong>{{ $errors->first('new-password') }}</strong>
          </span>
          @endif
          <span id="match" class="pl-3"></span>
        </div>

        <div class="btn-container">
          <button type="submit" class="btn login-button w-100 text-white">Reset Password</button>
        </div>

        <p class="account-btn mt-3 text-center">Back to <a href="{{url('login')}}">Sing in</a></p>

      </form>
    </div>
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
</script>
@endsection
