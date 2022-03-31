@extends('frontend.layouts.app')
@section('title', '404 Error')
@section('style')
<style>
  header{
    display: none;
  }
  footer{
    display: none;
  }
</style>
@endsection
@section('content')
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
  <!--Register Form Start-->
  <div class="wt-haslayout wt-main-section py-2">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-xs-12 col-sm-12 col-md-10 push-md-1 col-lg-8 push-lg-2">
          <div class="wt-404errorpage">
            <figure class="wt-404errorimg"><img src="{{asset('assets/images/404-img.jpg')}}" alt="img description"></figure>
            <div class="wt-404errorcontent">
              <div class="wt-title">
                <h3>Link Might Crashed or Not Working!</h3>
              </div>
              <div class="wt-description">
                <p>Go back to <a href="{{url('/')}}">Homepage</a></p>
              </div>
              <!-- <form class="wt-formtheme wt-formhelpsearch">
                <fieldset>
                  <div class="form-group">
                    <input type="text" name="searching" class="form-control" placeholder="Searching Might Help">
                    <a href="javascript:void(0);" class="wt-btnsearch">Search Now</a>
                  </div>
                </fieldset>
              </form> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Register Form End-->
</main>
<!--Main End-->
@endsection
@section('script')
@endsection
