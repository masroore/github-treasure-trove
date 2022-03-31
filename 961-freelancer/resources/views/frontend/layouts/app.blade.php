<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- SEO meta tags -->
	<meta name="author" content="Zeeshan ">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>961 Freelancer</title>
	<!-- ==============Favicon ================ -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/favicon/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">
	<!-- ==============Google Fonts============= -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet"> -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/fontawesome.min.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/chosen.css') }}">
	@yield('style')
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/main.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/slick.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/color.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/responsive.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/transitions.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/scrollbar.css') }}">
	@yield('dashboardstyle')
</head>
<body>
	<!-- <div class="preloader-outer">
		<div class="loader"></div>
	</div> -->
	{{ View::make('frontend.includes.navbar') }}
	@yield('content')
	{{ View::make('frontend.includes.footer') }}
	<audio id="messagetone" muted>
    <source src="{{ asset('bell.mp3')}}" type="audio/ogg">
    <source src="{{ asset('bell.mp3')}}" type="audio/mpeg">
  </audio>
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<!-- <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script> -->
	<!-- <script src="{{ asset('assets/js/all.min.js') }}"></script> -->
	<script src="{{ asset('assets/js/slick.js') }}"></script>
	<script src="{{ asset('assets/js/scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
	<script src="{{ asset('assets/js/tilt.jquery.js') }}"></script>
	<script src="{{ asset('assets/js/readmore.js') }}"></script>
	<script src="{{ URL::asset('assets/js/notify.js') }}"></script>
	<script src="{{ URL::asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ URL::asset('assets/js/ckeditor/adapters/jquery.js') }}"></script>
	<script src="{{ URL::asset('assets/js/jRate.js') }}"></script>
	@yield('script')
	<script src="{{ asset('assets/js/custom.js') }}"></script>
	<script>
		$(window).on('load', function (){
			$('#width-tinymceeditor').ckeditor();
			CKEDITOR.replace('wt-tinymceeditor');
		});
		@if (Session::has('success'))
		   $.notify("{{ session('error') }}" , 'success'  );
		@endif
		@if (Session::has('message'))
		    $.notify("{{ session('message') }}", 'success');
		@endif

		@if (Session::has('error'))
		    $.notify("{{ session('error') }}" , 'error'  );
		@endif
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
		
	</script>
	<script src="https://961freelancer.com:22000/socket.io/socket.io.js"></script>
	@if(auth()->user())
	<script type="text/javascript">
	    const socket = io.connect('https://961freelancer.com:22000');
	    var user_id = "{{auth()->user()->id}}";
	    // alert(user_id);
	    socket.on('birdsreceivemsg', function(data) {
	      // console.log(data);
	      if( user_id == data.message_receiver){
	        var messagetone = document.getElementById("messagetone");
	        messagetone.play();
	        messagetone.muted = false;
	         $.ajax({
	              url: "{{url('/messsageCount')}}/"+user_id,
	              type: "GET"
	            }).then(function(res) {
	              $('.messageCount').html(res);
	            })

	      }

	    });
	    socket.on('receiveNotification', function(data){
	    	console.log(data);
	    	if(user_id == data.to){
	    		var messagetone = document.getElementById("messagetone");
	    		messagetone.play();
	    		messagetone.muted = false;
	    		$('.notiCount').html(1);
	    		$.ajax({
    		    url: "{{url('/notificationCount')}}/"+user_id,
    		    type: "GET"
    		  }).then(function(res) {
    		    $('.notiCount').html(res);
    		    $('.notification-list').append('<li class="notification-box bg-light"><div class="row"><div class="col-lg-12 col-sm-12 col-12"><div class="noti-msg"><a href="/proposals" class="pe-0">'+data.message+'</a></div></div></div></li>'); 
    		  })
	    	}
	    });
	    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	      return new bootstrap.Tooltip(tooltipTriggerEl)
	    })
	    $('.notification').click(function(){
	    	$('.notification-dropdown').toggle();
	    });
	    function readNoti(id){
	    	$.ajax({
	    	    url: "{{url('/readNotification')}}/"+id,
	    	    type: "POST",

	    	    success: (response)=>{
	    	        console.log(response);
	    	    },
	    	    error: (errorResponse)=>{
	    	        $.notify( errorResponse, 'error'  );
	    	    }
	    	})
	    }

    	
	    
	</script>
	@endif
</body>
</html>