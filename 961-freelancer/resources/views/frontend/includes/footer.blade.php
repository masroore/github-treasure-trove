<!-- <footer>
	<div class="footer-area">
	  <div class="container">
	    <div class="row">
	      <div class="col-lg-3 col-md-3 col-6">
	        <div class="widget-item">
	          <h4 class="text-white">For Clients</h4>
	          <a href="">Our Story</a>
	          <a href="{{route('about-us')}}">About Us</a>
	        </div>
	      </div>
	      <div class="col-lg-3 col-md-3 col-6">
	        <div class="widget-item">
	          <h4 class="text-white">For Talent </h4>
	          <a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a>
	          <a href="{{route('privacy-policy')}}">Privacy Policy </a>
	          <a href="{{route('how-it-works')}}">How It Works</a>
	          <a href="{{route('contact-us')}}">Contact Us</a>
	        </div>
	      </div>
	      <div class="col-lg-3 col-md-3 col-6">
	        <div class="widget-item">
	          <h4 class="text-white">Resources</h4>
	          <a href="{{route('help-support')}}">Help & Support</a>
	          <a href="">Success Stories </a>
	          <a href="">Resources</a>
	          <a href="">Blog</a>
	        </div>
	      </div>
	      <div class="col-lg-3 col-md-3 col-6">
	        <div class="widget-item">
	          <h4 class="text-white">Company</h4>
	          <a href="{{route('about-us')}}">About Us</a>
	          <a href="">Leadership </a>
	          <a href="">Press</a>
	          <a href="{{route('contact-us')}}">Contact Us</a>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="copyright-area pt-3 pb-3">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12 d-flex align-items-center">
					<p class="mb-0 text-white">Follow Us:</p>
					<div class="footer-social ps-3">
						<a href=""><i class="fab fa-facebook"></i></a>
		        <a href=""><i class="fab fa-twitter"></i></a>
		        <a href=""><i class="fab fa-youtube"></i></a>
		        <a href=""><i class="fab fa-linkedin"></i></a>
		        <a href=""><i class="fab fa-instagram"></i></a>
		      </div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright-area">
	  <div class="container">
	    <div class="row align-items-center d-flex justify-content-center">
	      <div class="col-lg-4 col-md-4 text-center">
	        <div class="copyright">
	          <div>
	            <p class="text-white mb-sm-0 mb-3">© 2021 961Freelancer</p>
	          </div>
	        </div>
	      </div>
	      <div class="col-lg-6 col-md-6">
	        <div class="widget-link d-flex align-items-center">
	          <p class="text-white">Secured With: </p>
	          <ul>
	            <li>
	              <a href="javascript:void(0);">
	              	Escrow
	              	<img src="https://493143-1557358-raikfcquaxqncofqfm.stackpathdns.com/assets/img/paypal.png" alt="">
	              </a>
	            </li>
	          </ul>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</footer> -->
<!--Footer Start-->
<footer id="wt-footer" class="wt-footer wt-haslayout">
	<div class="wt-footerholder wt-haslayout footer-area">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-6 col-lg-6">
					<div class="wt-footerlogohold">
						<strong class="wt-logo"><a href="{{route('home')}}"><img src="{{ asset('assets/images/logo.png') }}" alt="company logo here" width="150"></a></strong>
						<div class="wt-description">
							<p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua enim poskina ilukita ylokem lokateise ination voluptate velit esse cillum dolore eu fugiat nulla pariatur lokaim urianewce </p>
						</div>
						<ul class="wt-socialiconssimple wt-socialiconfooter">
							<li class="wt-facebook"><a href="javascript:void(0);"><i class="fa fa-facebook-f"></i></a></li>
							<li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
							<li class="wt-youtube"><a href="javascript:void(0);"><i class="fab fa-youtube"></i></a></li>
							<li class="wt-instagram"><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
							<li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus-g"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-3">
					<div class="wt-footercol wt-widgetcompany">
						<div class="wt-fwidgettitle">
							<h3>Company</h3>
						</div>
						<ul class="wt-fwidgetcontent">
							<li><a href="{{route('about-us')}}">About Us</a></li>
							<li><a href="{{route('how-it-works')}}">How It Works</a></li>
							<!-- <li><a href="javascript:void(0);">Careers</a></li> -->
							<li><a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a></li>
							<li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
							<!-- <li class="wt-viewmore"><a href="javascript:void(0);">+ View All</a></li> -->
						</ul>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-3">
					<div class="wt-footercol wt-widgetexplore">
						<div class="wt-fwidgettitle">
							<h3>Explore More</h3>
						</div>
						<ul class="wt-fwidgetcontent">
							<li><a href="{{route('help-support')}}">Help and Support</a></li>
							<li><a href="{{route('contact-us')}}">Contact Us</a></li>
							<li><a href="{{ route('freelancers.index') }}">Find Freelancers</a></li>
							<!-- <li><a href="javascript:void(0);">Jobs in USA</a></li> -->
							<li><a href="{{ route('job.index') }}">Find Jobs</a></li>
							<!-- <li class="wt-viewmore"><a href="javascript:void(0);">+ View All</a></li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wt-haslayout wt-joininfo footer-info">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 push-lg-1">
					<div class="wt-companyinfo">
						<span><a href="javascript:void(0);">New @ 961Freelancer?</a> Dotem eiusmod tempor incune utnaem labore etdolore.</span>
					</div>
					<div class="wt-fbtnarea">
						<a href="{{route('register')}}" class="wt-btn">Join Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wt-haslayout wt-footerbottom">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="wt-copyrights"><span>961Freelancer.</span> © 2021 All Rights Reserved.</p>
					<nav class="wt-addnav">
						<ul>
							<!-- <li><a href="javascript:void(0);">News</a></li> -->
							<li><a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a></li>
							<li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
							<!-- <li><a href="javascript:void(0);">Career</a></li> -->
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--Footer End-->