@extends('admin.layouts.master')
@section('title') Create New User @endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- dropzone css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/intlTelInput.min.css')}}">
<style>
  .iti__divider,.iti__country{
    list-style: none;
  }
  .iti{
    width: 100%;
  }
  .select2-container .select2-selection--single {
    height: calc(1.5em + .94rem + 2px) !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 5px !important;
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

@component('admin.common-components.breadcrumb')
@slot('title') Create New @endslot
@slot('li_1') User @endslot
@slot('li_2') Create New @endslot
@endcomponent
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Create New User</h4>
        <form id="create-user-form">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="formrow-firstName-input">First Name</label>
                <input type="text" class="form-control" name="first_name" id="formrow-firstName-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="formrow-lastName-input">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="formrow-lastName-input">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="formrow-userName-input">User Name</label>
                <input type="text" class="form-control" name="username" id="formrow-userName-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="formrow-email-input">Email</label>
                <input type="email" class="form-control" name="email" id="formrow-email-input">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" class="form-control" name="mobile_number" id="phone" >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="formrow-email-input">Account Type</label>
                <select name="account_type" class="form-control">
                  <option value="">Select Type</option>
                  <option value="Freelancer">Freelancer</option>
                  <option value="Client">Client</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="formrow-email-input">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
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
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-lg-12">
              <button type="submit" class="btn btn-primary btn-lg">Add User</button>
            </div>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
<!-- end row -->
@endsection
@section('script')
<!-- bootstrap datepicker -->
<script src="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<!-- dropzone plugin -->
<script src="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/additional-methods.min.js')}}"></script>
<script src="{{asset('assets/js/intlTelInput.min.js')}}"></script>
@endsection
@section('script-bottom')
<script>
    function catImg(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          console.log(reader);
          reader.onload = function (e) {
              $('#icon_show')
                  .attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
      
    }
</script>

<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $('.select2').select2();

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


var phone_number = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  hiddenInput: "full",
  utilsScript: "/assets/js/utils.js",
  excludeCountries: ["il"]
});
  // var input = document.querySelector("#phone");

  $("#create-user-form").validate({


      errorPlacement:function (error , element) {
        error.insertAfter(element.parents(".form-group"))
      },
          rules: {
              first_name: {
                  required: true,
                  // lettersonly: true
              },
              last_name: {
                  required: true,
                  // lettersonly: true
              },
              username: {
                  required: true,
                  // email: true
              },
              email: {
                  required: true,
                  // number: true
              },
              account_type: {
                  required: true,
                  
              },
              password: {
                  required: true,
              },


          },
          messages: {
              first_name: {
                  required: "Please select first name",

              } ,
              last_name: {
                  required: "Please enter last name",

              } ,
              username: {
                  required: "Please select username",

              } ,
              email: {
                  required: "Please select email",
                  // number: "Please enter valid integer",
              } ,
              account_type: {
                  required: "Please enter account type",

              } ,
              password: {
                  required: "Please select password",

              } ,

          },

          submitHandler: function(form) {
             form_Create(form);
          }

    });


  function form_Create(formData) {
//    let createFormData = $('#formCreate').serialize();
var createFormData = new FormData (formData);
    // console.log(createFormData);
    $.ajax({
        url: "{{route('admin.users.store')}}",
        type: 'POST',
        data: createFormData,
        contentType: false,
        processData: false,

        success: (response)=>{
            if (response.status == 'true') {
                $.notify(response.message , 'success'  );
                if(response.userType == 'Freelancer'){
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/freelancers-list/";
                }else{
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/clients-list/";
                }
                
            }else{
                $.notify(response.message , 'error');

            }
        },
        error: (errorResponse)=>{
            $.notify( errorResponse, 'error'  );


        }
    })

}
</script>
@endsection