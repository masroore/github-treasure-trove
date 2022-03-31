@extends('frontend.layouts.app')
@section('content')
<!--Home Banner Start-->
<div class="wt-haslayout wt-bannerholder">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-5">
        <div class="wt-bannerimages">
          <figure class="wt-bannermanimg" data-tilt>
            <img src="{{ asset('assets/images/home/img-01.png')}}" alt="img description">
            <img src="{{ asset('assets/images/home/img-02.png')}}" class="wt-bannermanimgone" alt="img description">
            <img src="{{ asset('assets/images/home/img-03.png')}}" class="wt-bannermanimgtwo" alt="img description">
          </figure>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
        <div class="wt-bannercontent">
          <div class="wt-bannerhead">
            <div class="wt-title">
              <h1><span>Hire Lebanese freelancers</span> for any job, Online</h1>
            </div>
            <div class="wt-description">
              <p>Consectetur adipisicing elit sed dotem eiusmod tempor incuntes ut labore etdolore maigna aliqua enim.</p>
            </div>
          </div>
          <form class="wt-formtheme wt-formbanner" method="get" action="{{url('search')}}">
            <fieldset>
              <div class="form-group">
                <input type="text" name="keyword" class="form-control" placeholder="I’m looking for">
                <div class="wt-formoptions">
                  <div class="wt-dropdown">
                    <span>In: <em class="selected-search-type">Freelancers </em><i class="fal fa-chevron-down"></i></span>
                  </div>
                  <div class="wt-radioholder">
                    <span class="wt-radio">
                      <input id="wt-freelancers" data-title="Freelancers" type="radio" name="searchtype" value="freelancer" checked>
                      <label for="wt-freelancers">Freelancers</label>
                    </span>
                    <span class="wt-radio">
                      <input id="wt-jobs" data-title="Jobs" type="radio" name="searchtype" value="job">
                      <label for="wt-jobs">Jobs</label>
                    </span>
                  </div>
                  <button class="wt-searchbtn"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Home Banner End-->
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout">
  <!--Categories Start-->
  <section class="wt-haslayout wt-main-section">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
          <div class="wt-sectionhead wt-textcenter">
            <div class="wt-sectiontitle">
              <h2>Explore Categories</h2>
              <span>Professional by categories</span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        @foreach($categories as $category)
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-4">
          <div class="wt-categorycontent">
            <figure><img src="{{asset('assets/images/categories/'.$category->cat_icon)}}" alt="image description"></figure>
            <div class="wt-cattitle">
              <h3><a href="{{url('jobs/'.$category->slug)}}">{{$category->category_name}}</a></h3>
            </div>
            <div class="wt-categoryslidup">
              <p class="mt-2 mb-1"><a href="{{url('jobs/'.$category->slug)}}" class="text-reset text-decoration-none">{{ \Illuminate\Support\Str::limit($category->cat_desc, $limit = 150, $end = '...') }}</a></p>
              <a href="{{url('jobs/'.$category->slug)}}">Explore <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        @endforeach
        
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-4 text-center">
          <div class="wt-btnarea">
            <a href="{{route('categories')}}" class="wt-btn">View All</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Categories End-->
  <!--Limitless Experience Start-->
  <div class="section pt-5 pb-5">
    <div class="container">
      <div class="row">

        <div class="col-xl-12">
          <!-- Section Headline -->
          <div class="section-headline text-center mt-0 mb-5">
            <h3>How It Works?</h3>
          </div>
        </div>
        
        <div class="col-xl-4 col-md-4">
          <!-- Icon Box -->
          <div class="icon-box with-line">
            <!-- Icon -->
            <div class="icon-box-circle">
              <div class="icon-box-circle-inner">
                <i class="fal fa-lock"></i>
                <div class="icon-box-check"><i class="fas fa-check"></i></div>
              </div>
            </div>
            <h3>Create an Account</h3>
            <p>Bring to the table win-win survival strategies to ensure proactive domination going forward.</p>
          </div>
        </div>

        <div class="col-xl-4 col-md-4">
          <!-- Icon Box -->
          <div class="icon-box with-line">
            <!-- Icon -->
            <div class="icon-box-circle">
              <div class="icon-box-circle-inner">
                <i class="fal fa-gavel"></i>
                <div class="icon-box-check"><i class="fas fa-check"></i></div>
              </div>
            </div>
            <h3>Post a Job</h3>
            <p>Efficiently unleash cross-media information without. Quickly maximize return on investment.</p>
          </div>
        </div>

        <div class="col-xl-4 col-md-4">
          <!-- Icon Box -->
          <div class="icon-box">
            <!-- Icon -->
            <div class="icon-box-circle">
              <div class="icon-box-circle-inner">
                <i class=" fal fa-trophy"></i>
                <div class="icon-box-check"><i class="fas fa-check"></i></div>
              </div>
            </div>
            <h3>Choose an Expert</h3>
            <p>Nanotechnology immersion along the information highway will close the loop on focusing solely.</p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!--Limitless Experience End-->
  <div class="section gray pt-5 pb-5">
    
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <!-- Section Headline -->
          <div class="section-headline text-center mt-0 mb-5">
            <h3>Testimonials</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Categories Carousel -->
    <div class="fullwidth-carousel-container mt-2">
      <!-- <div class="slider testimonial-carousel">
        <div><h3>1</h3></div>
        <div><h3>2</h3></div>
        <div><h3>3</h3></div>
        <div><h3>4</h3></div>
        <div><h3>5</h3></div>
      </div> -->
      <div class="testimonial-carousel testimonials">
        <!-- <button class="slick-prev slick-arrow" aria-label="Previous" type="button" style="">Previous</button> -->

        <!-- Item -->
        

        <!-- Item -->
        

        <!-- Item -->
        

        <!-- Item -->
        

        <!-- Item -->
        
        
      <!-- <div class="slick-list draggable" style="padding: 0px 21%; height: 382px;"><div class="slick-track" style="opacity: 1; width: 9636px; transform: translate3d(-2409px, 0px, 0px);"> -->
        <div class="fw-carousel-review slick-slide" style="width: 763px;" data-slick-index="0" aria-hidden="true" tabindex="-1">
          <div class="testimonial-box">
            <div class="testimonial-avatar">
              <img src="{{asset('assets/images/home/user-avatar-small-02.jpg')}}" alt="">
            </div>
            <div class="testimonial-author">
              <h4>Sindy Forest</h4>
               <span>Freelancer</span>
            </div>
            <div class="testimonial">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.</div>
          </div>
        </div><div class="fw-carousel-review slick-slide" style="width: 763px;" data-slick-index="1" aria-hidden="false" tabindex="0">
          <div class="testimonial-box">
            <div class="testimonial-avatar">
              <img src="{{asset('assets/images/home/user-avatar-small-01.jpg')}}" alt="">
            </div>
            <div class="testimonial-author">
              <h4>Tom Smith</h4>
               <span>Freelancer</span>
            </div>
            <div class="testimonial">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.</div>
          </div>
        </div>
        <div class="fw-carousel-review slick-slide" style="width: 763px;" data-slick-index="2" aria-hidden="true" tabindex="-1">
          <div class="testimonial-box">
            <div class="testimonial-avatar">
              <img src="{{asset('assets/images/home/user-avatar-placeholder.png')}}" alt="">
            </div>
            <div class="testimonial-author">
              <h4>Sebastiano Piccio</h4>
               <span>Employer</span>
            </div>
            <div class="testimonial">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.</div>
          </div>
        </div>
        <div class="fw-carousel-review slick-slide" style="width: 763px;" data-slick-index="3" aria-hidden="true" tabindex="-1">
          <div class="testimonial-box">
            <div class="testimonial-avatar">
              <img src="{{asset('assets/images/home/user-avatar-small-03.jpg')}}" alt="">
            </div>
            <div class="testimonial-author">
              <h4>David Peterson</h4>
               <span>Freelancer</span>
            </div>
            <div class="testimonial">Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services. Seamlessly empower fully researched growth strategies and interoperable sources.</div>
          </div>
        </div>
        <div class="fw-carousel-review slick-slide" style="width: 763px;" data-slick-index="4" aria-hidden="true" tabindex="-1">
          <div class="testimonial-box">
            <div class="testimonial-avatar">
              <img src="{{asset('assets/images/home/user-avatar-placeholder.png')}}" alt="">
            </div>
            <div class="testimonial-author">
              <h4>Marcin Kowalski</h4>
               <span>Freelancer</span>
            </div>
            <div class="testimonial">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.</div>
          </div>
        </div>
        </div>
      <!-- </div> -->
      <!-- <button class="slick-next slick-arrow" aria-label="Next" type="button" style="">Next</button> -->
    </div>
    </div>
    <!-- Categories Carousel / End -->

  </div>
  <!--Counter-->
  <div class="section pt-5 pb-5">
    <div class="container">
      <div class="row">

        <div class="col-xl-12">
          <div class="counters-container">
            
            <!-- Counter -->
            <div class="single-counter">
              <i class="fal fa-briefcase"></i>
              <div class="counter-inner">
                <h3><span class="counter">1,586</span></h3>
                <span class="counter-title">Jobs Posted</span>
              </div>
            </div>

            <!-- Counter -->
            <div class="single-counter">
              <i class="fal fa-gavel"></i>
              <div class="counter-inner">
                <h3><span class="counter">3,543</span></h3>
                <span class="counter-title">Tasks Posted</span>
              </div>
            </div>

            <!-- Counter -->
            <div class="single-counter">
              <i class="fal fa-user"></i>
              <div class="counter-inner">
                <h3><span class="counter">2,413</span></h3>
                <span class="counter-title">Active Members</span>
              </div>
            </div>

            <!-- Counter -->
            <div class="single-counter">
              <i class="fal fa-trophy"></i>
              <div class="counter-inner">
                <h3><span class="counter">99</span>%</h3>
                <span class="counter-title">Satisfaction Rate</span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Counter End-->
</main>
<!--Main End-->
@endsection
@section('script')
<script>
  jQuery('.wt-dropdown').on('click', function(event){
    event.preventDefault();
    jQuery('.wt-radioholder').slideToggle();
  });
  jQuery('input:radio[name="searchtype"]').on('change',
      function(){
          var _type = jQuery(this).data('title');
          jQuery('.selected-search-type').html(_type);
      }
    );
</script>
@endsection