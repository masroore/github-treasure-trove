@extends('frontend.layouts.app')
@section('title', 'Change Password')
@section('style')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/owl.carousel.min.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
@endsection
@section('content')
<!--Inner Home Banner Start-->
<div class="wt-haslayout wt-innerbannerholder">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
        <div class="wt-innerbannercontent">
        <div class="wt-title"><h2>About Us</h2></div>
        <ol class="wt-breadcrumb">
          <li><a href="{{route('home')}}">Home</a></li>
          <li class="wt-active">About Us</li>
        </ol>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Inner Home End-->
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
  <div class="wt-haslayout wt-main-section">
    <!--Greetings & Welcome Start-->
    <section class="wt-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="wt-greeting-holder">
              <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-left">
                  <div class="wt-greetingcontent">
                    <div class="wt-sectionhead">
                      <div class="wt-sectiontitle">
                        <h2>Greetings &amp; Welcome</h2>
                        <span>Start Today For a Great Future</span>
                      </div>
                      <div class="wt-description">
                        <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce anim id est laborumed.</p>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborumed perspiciatis unde omnis isteatus error aluptatem accusantium doloremque laudantium.</p>
                      </div>
                    </div>
                    <div id="wt-statistics" class="wt-statistics">
                      <div class="wt-statisticcontent wt-countercolor1">
                        <h3 data-from="0" data-to="1500" data-speed="8000" data-refresh-interval="50">1500</h3>
                        <em>k</em>
                        <h4>Active Projects</h4>
                      </div>
                      <div class="wt-statisticcontent wt-countercolor2">
                        <h3 data-from="0" data-to="99" data-speed="8000" data-refresh-interval="5.9">99%</h3>
                        <em>%</em>
                        <h4>Great Feedback</h4>
                      </div>
                      <div class="wt-statisticcontent wt-countercolor3">
                        <h3 data-from="0" data-to="5000" data-speed="8000" data-refresh-interval="100">5000</h3>
                        <em>k</em>
                        <h4>Active Freelancers</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-5 float-left">
                  <div class="wt-greetingvideo">
                    <figure><img src="{{asset('assets/images/freelancer.jpg')}}" alt="video">
                    </figure>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Greetings & Welcome End-->
    <!--Signup Start-->
    <section class="wt-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="wt-signupholder">
              <div class="col-12 col-sm-12 col-md-12 col-lg-6 float-end">
                <div class="wt-signupcontent">
                  <div class="wt-title">
                    <h2><span>Signup as</span>961Freelancer Pro</h2>
                  </div>
                  <div class="wt-description">
                    <p>Consectetur adipisicing elit amissed dotem eiusmod tempor incuntes utneai labore etdolore.</p>
                  </div>
                  <div class="wt-btnarea">
                    <a href="{{route('register')}}" class="wt-btn wt-btnvtwo rounded-pill">Join Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Signup End-->
    <!--Brand Start-->
    <div class="wt-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div id="wt-brandslider" class="wt-barandslider wt-haslayout owl-carousel">
              <figure class="item wt-brandimg">
                <img src="{{asset('assets/images/brands/img-01.png')}}" alt="image description">
              </figure>
              <figure class="item wt-brandimg">
                <img src="{{asset('assets/images/brands/img-02.png')}}" alt="image description">
              </figure>
              <figure class="item wt-brandimg">
                <img src="{{asset('assets/images/brands/img-03.png')}}" alt="image description">
              </figure>
              <figure class="item wt-brandimg">
                <img src="{{asset('assets/images/brands/img-04.png')}}" alt="image description">
              </figure>
              <figure class="item wt-brandimg">
                <img src="{{asset('assets/images/brands/img-05.png')}}" alt="image description">
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Brand End-->
    <!--Our Team Start-->
    <section class="wt-haslayout">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="wt-ourteamhold wt-haslayout wt-bgwhite">
              <div id="filter-masonry" class="wt-teamfilter wt-haslayout">
                <div class="wt-sectionhead">
                  <div class="wt-sectiontitle">
                    <h2>Our Professionals</h2>
                    <span>Team Behind The Curtain</span>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-01.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Luisa Moxley</a></h2>
                      <span>Marketing Manager</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-02.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Guadalupe</a></h2>
                      <span>Marketing Administrator</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-03.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Brande Feeley</a></h2>
                      <span>Marketing Director</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-04.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Joseph Farner</a></h2>
                      <span>VP Marketing</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-05.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Rozella Hott</a></h2>
                      <span>Marketing Director</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-06.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Duane Villalta</a></h2>
                      <span>Marketing Administrator</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-07.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Johanne Deyoung</a></h2>
                      <span>VP Marketing</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="wt-teamholder">
                  <figure class="wt-speakerimg">
                    <img src="{{asset('assets/images/team/img-08.jpg')}}" alt="image description">
                  </figure>
                  <div class="wt-teamcontent">
                    <div class="wt-title">
                      <h2><a href="javascript:void(0);">Joseph Farner</a></h2>
                      <span>Marketing Manager</span>
                    </div>
                    <ul class="wt-socialicons wt-socialiconssimple">
                      <li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                      <li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                      <li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                      <li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Our Team End-->
  </div>
</main>
<!--Main End-->
@endsection
@section('script')
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.hoverdir.js') }}"></script>
@endsection
