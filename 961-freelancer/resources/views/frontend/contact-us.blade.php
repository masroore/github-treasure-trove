@extends('frontend.layouts.app')
@section('title', 'Change Password')
@section('styling')
@endsection
@section('content')
<!--Inner Home Banner Start-->
<div class="wt-haslayout wt-innerbannerholder">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
        <div class="wt-innerbannercontent">
        <div class="wt-title"><h2>Contact Us</h2></div>
        <ol class="wt-breadcrumb">
          <li><a href="{{route('home')}}">Home</a></li>
          <li class="wt-active">Contact Us</li>
        </ol>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Inner Home End-->
<div class="container">
  <div class="row">

    <div class="col-xl-12">
      <div class="contact-location-info mb-5 mt-5">
        <div class="contact-address d-flex">
          <ul>
            <li class="contact-address-headline">Our Office</li>
            <li>425 Berry Street, CA 93584</li>
            <li>Phone (123) 123-456</li>
            <li><a href="#">mail@example.com</a></li>
            <li>
              <div class="freelancer-socials">
                <ul>
                  <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Dribbble"><i class="fal fa-basketball-ball"></i></a></li>
                  <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                  <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook"><i class="fab fa-facebook"></i></a></li>
                  <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="GitHub"><i class="fab fa-github"></i></a></li>
                
                </ul>
              </div>
            </li>
          </ul>

        </div>
        <div id="single-job-map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d212644.8169165206!2d72.94602413487837!3d33.6163232214002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbfd07891722f%3A0x6059515c3bdb02b6!2sIslamabad%2C%20Islamabad%20Capital%20Territory%2C%20Pakistan!5e0!3m2!1sen!2s!4v1635320519962!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>

    <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">

      <section id="contact" class="mb-5">
        <h3 class="headline mt-3 mb-4">Any questions? Feel free to contact us!</h3>

        <form id="contactform" autocomplete="on">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="input-with-icon-left">
                <input class="with-border form-control" name="name" type="text" id="name" placeholder="Your Name" required="required">
                <i class="fal fa-user-circle"></i>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-with-icon-left">
                <input class="with-border form-control" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required">
                <i class="fal fa-envelope"></i>
              </div>
            </div>
          </div>

          <div class="input-with-icon-left">
            <input class="with-border form-control" name="subject" type="text" id="subject" placeholder="Subject" required="required">
            <i class="fal fa-file-alt"></i>
          </div>

          <div>
            <textarea class="with-border form-control" name="comments" cols="40" rows="5" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
          </div>

          <input type="submit" class="submit button mt-4 w-25 text-white" id="submit" value="Submit Message">

        </form>
      </section>

    </div>

  </div>
</div>
@endsection
@section('script')
<script>
  $('#contactform').on('submit', function(event){
      event.preventDefault();
    $.ajax({
        url: "{{url('contactStore')}}",
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,

        success: (response)=>{
            if (response.status == 'true') {
                $.notify(response.message , 'success'  );
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/contact-us";
                
                
            }else{
                $.notify(response.message , 'error');

            }
        },
        error: (errorResponse)=>{
            $.notify( errorResponse, 'error'  );


        }
    })
  })
</script>
@endsection
