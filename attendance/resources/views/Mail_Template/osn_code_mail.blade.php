<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>@yield('title')</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content=""
	/>
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<!-- Bootstrap-Core-Css -->
	<link rel="stylesheet" href="{{URL::to('css/bootstrap.css')}}">
	@yield('addcss')
	<!-- Testimonials-Css -->
	<link href="{{ URL::to('css/mislider.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::to('css/mislider-custom.css')}}" rel="stylesheet" type="text/css" />
	<!-- Style-Css -->
	<link rel="stylesheet" href="{{ URL::to('css/style.css')}}" type="text/css" media="all" />
	<!-- Font-Awesome-Icons-Css -->
	<link rel="stylesheet" href="{{ URL::to('css/fontawesome-all.css')}}">
	<!-- //Custom-Files -->

	

	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	 rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
	<!-- //Web-Fonts -->


	@livewireStyles
</head>

<body>
	
	<!-- header -->
	<header>
		<!-- top header -->
		<div class="top-head-w3ls py-2 bg-dark">
			<div class="container">
				<div class="row">
					<h1 class="text-capitalize text-white col-7">
						<i class="fas fa-book text-dark bg-white p-2 rounded-circle mr-3"></i>welcome to OgusSes School</h1>
					<!-- social icons -->
					<div class="social-icons text-right col-5">
						<ul class="list-unstyled">
							<li>
								<a href="#" class="fab fa-facebook-f icon-border facebook rounded-circle"> </a>
							</li>
							<li class="mx-2">
								<a href="#" class="fab fa-twitter icon-border twitter rounded-circle"> </a>
							</li>
							<li>
								<a href="#" class="fab fa-google-plus-g icon-border googleplus rounded-circle"> </a>
							</li>
							<li class="ml-2">
								<a href="#" class="fas fa-rss icon-border rss rounded-circle"> </a>
							</li>
						</ul>
					</div>
					<!-- //social icons -->
				</div>
			</div>
		</div>
		<!-- //top header -->
		
	</header>
	<!-- //header -->

		<div class="row">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4 bg-dark text-white mt-2 mb-2" style="padding: 10px;margin:10px;">
					<h1 class="text-center text-underline">OSN CODE</h1>
					<p>Hello, Thank you for choosing Ogua School Management System.</p>
					<p>Your Online Serial Number (OSN) to continue the registeration process is 
							<br><b>{{$osncode}}</b>
					</p>
					<br>
					<p class="text-center">
						<a href="{{route('online-admission-login')}}" target="_blank" class="btn btn-sm btn-success">Online Admission</a>
					</p>

					<p class="text-left">Best Regards</p>
					<p class="text-left">Ahmed Ahia</p>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>

	
	<!-- footer -->
	<footer>
		<div class="container py-4">
			<div class="row py-xl-5 py-sm-3">
				<div class="col-lg-6 map">
					<h2 class="contact-title text-capitalize text-white font-weight-light mb-sm-4 mb-3">our
						<span class="font-weight-bold">directions</span>
					</h2>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.495758873587!2d-74.0005340845242!3d40.72911557933012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25991b7473067%3A0x59fbd02f7b519ce8!2s550+LaGuardia+Pl%2C+New+York%2C+NY+10012%2C+USA!5e0!3m2!1sen!2sin!4v1516166447283"></iframe>
					<div class="conta-posi-w3ls p-4 rounded">
						<h5 class="text-white font-weight-bold mb-3">Address</h5>
						<p>25095 Blue Ravine Rd,
							<span>Diamonds street,</span> California, USA</p>
					</div>
				</div>
				<div class="col-lg-6 contact-agileits-w3layouts mt-lg-0 mt-4">
					<h4 class="contact-title text-capitalize text-white font-weight-light mb-sm-4 mb-3">get in
						<span class="font-weight-bold">touch</span>
					</h4>
					<p class="conta-para-style border-left pl-4">If you have any questions about the services we provide simply use the form below. We try and respond to all queries
						and comments within 24 hours.</p>
					<div class="subscribe-w3ls my-xl-5 my-4">
						<h6 class="text-white text-capitalize mb-4">subscribe our newsletter</h6>
						<form action="#" method="post" class="subscribe_form">
							<input class="form-control" type="email" name="email" placeholder="Enter your email..." required="">
							<button type="submit" class="btn btn-primary submit">Submit</button>
						</form>
					</div>
					<p class="para-agileits-w3layouts text-white">
						<i class="fas fa-map-marker pr-3"></i>25095 Blue Ravine Rd,USA</p>
					<p class="para-agileits-w3layouts text-white my-sm-3 my-2">
						<i class="fas fa-phone pr-3"></i>032 625 4592</p>
					<p class="para-agileits-w3layouts">
						<i class="far fa-envelope-open pr-2"></i>
						<a href="mailto:mail@example.com" class=" text-white">info@oguses.com</a>
					</p>
				</div>
			</div>
		</div>
		<div class="copyright-agiles py-3">
			<div class="container">
				<div class="row">
					<p class="col-lg-8 copy-right-grids text-white text-lg-left text-center mt-lg-1">© <?php echo date('Y');?> OguSes College Management System. All Rights Reserved | Design by
						<a href="https://w3layouts.com/" target="_blank">W3layouts</a>
					</p>
					<!-- social icons -->
					<div class="social-icons text-lg-right text-center col-lg-4 mt-lg-0 mt-3">
						<ul class="list-unstyled">
							<li>
								<a href="#" class="fab fa-facebook-f icon-border facebook rounded-circle"> </a>
							</li>
							<li class="mx-2">
								<a href="#" class="fab fa-twitter icon-border twitter rounded-circle"> </a>
							</li>
							<li>
								<a href="#" class="fab fa-google-plus-g icon-border googleplus rounded-circle"> </a>
							</li>
							<li class="ml-2">
								<a href="#" class="fas fa-rss icon-border rss rounded-circle"> </a>
							</li>
						</ul>
					</div>
					<!-- //social icons -->
				</div>
			</div>
		</div>
	</footer>
	<!-- //footer -->


	<!-- Js files -->
	<!-- JavaScript -->
	<script src="{{ URL::to('js/jquery-2.2.3.min.js')}}"></script>
	<!-- Default-JavaScript-File -->
	<script src="{{ URL::to('js/bootstrap.js')}}"></script>
	<!-- Necessary-JavaScript-File-For-Bootstrap -->

	<!-- banner slider -->
	<script src="{{ URL::to('js/slider.js')}}"></script>
	<!-- //banner slider -->

	<!-- testimonial-plugin -->
	<script src="{{ URL::to('js/mislider.js')}}"></script>
	<script>
		jQuery(function ($) {
			var slider = $('.mis-stage').miSlider({
				//  The height of the stage in px. Options: false or positive integer. false = height is calculated using maximum slide heights. Default: false
				stageHeight: 320,
				//  Number of slides visible at one time. Options: false or positive integer. false = Fit as many as possible.  Default: 1
				slidesOnStage: false,
				//  The location of the current slide on the stage. Options: 'left', 'right', 'center'. Defualt: 'left'
				slidePosition: 'center',
				//  The slide to start on. Options: 'beg', 'mid', 'end' or slide number starting at 1 - '1','2','3', etc. Defualt: 'beg'
				slideStart: 'mid',
				//  The relative percentage scaling factor of the current slide - other slides are scaled down. Options: positive number 100 or higher. 100 = No scaling. Defualt: 100
				slideScaling: 150,
				//  The vertical offset of the slide center as a percentage of slide height. Options:  positive or negative number. Neg value = up. Pos value = down. 0 = No offset. Default: 0
				offsetV: -5,
				//  Center slide contents vertically - Boolean. Default: false
				centerV: true,
				//  Opacity of the prev and next button navigation when not transitioning. Options: Number between 0 and 1. 0 (transparent) - 1 (opaque). Default: .5
				navButtonsOpacity: 1,
			});
		});
	</script>
	<!-- //testimonial-plugin -->

	<!-- numscroller-js-file -->
	<script src="{{ URL::to('js/numscroller-1.0.js')}}"></script>
	<!-- //numscroller-js-file -->

	<!-- smooth scrolling -->
	<script src="{{ URL::to('js/SmoothScroll.min.js')}}"></script>
	<!-- //smooth scrolling -->

	<!-- move-top -->
	<script src="{{ URL::to('js/move-top.js')}}"></script>
	<!-- easing -->
	<script src="{{ URL::to('js/easing.js')}}"></script>
	<!--  necessary snippets for few javascript files -->
	<script src="{{ URL::to('js/edulearn.js')}}"></script>

	<!-- //Js files -->

@livewireScripts
</body>

</html>