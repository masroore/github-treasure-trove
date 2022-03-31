@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	.error{
		color: red;
	}
</style>
@endsection
@section('content')
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			<section class="wt-haslayout wt-dbsectionspace">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>Feedback</h2>
							</div>

							@if(Auth::user()->account_type == 'Client')
							<div class="wt-dashboardboxcontent wt-jobdetailsholder">
								<div class="wt-freelancerholder wt-tabsinfo">
									<form class="wt-formtheme wt-formfeedback" id="feedback_form">
										@csrf
										<input type="hidden" name="rating_to" value="{{$proposal_user}}">
										<input type="hidden" name="job_id" value="{{$job_id}}">
										<input type="hidden" name="proposal_id" value="{{$proposal_id}}">
										
										<fieldset>
											<div class="form-group">
												<textarea class="form-control" name="feedback" placeholder="Add Your Feedback*"></textarea>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="general_rating" id="general_rating" value="5">
												<div class="wt-ratepoints">
													<div class="counter wt-pointscounter">5.0</div>
													<div id="wt-jrate" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">General rating</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="skills_rating" id="skills_rating" value="4">
												<div class="wt-ratepoints">
													<div class="counterone wt-pointscounter">5.0</div>
													<div id="wt-jrateone" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Skills</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="work_rating" id="work_rating" value="3">
												<div class="wt-ratepoints">
													<div class="countertwo wt-pointscounter">5.0</div>
													<div id="wt-jratetwo" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Quality of work</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="communication_rating" id="communication_rating" value="2">
												<div class="wt-ratepoints">
													<div class="counterthree wt-pointscounter">5.0</div>
													<div id="wt-jratethree" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Communication</span>
											</div>
											<div class="form-group wt-btnarea">
												<button type="submit" class="wt-btn rounded-pill py-2 w-25">Send Feedback</button>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							@endif
							@if(Auth::user()->account_type == 'Freelancer')
							<div class="wt-dashboardboxcontent wt-jobdetailsholder">
								<div class="wt-freelancerholder wt-tabsinfo">
									<form class="wt-formtheme wt-formfeedback" id="feedback_form">
										@csrf
										<input type="hidden" name="rating_to" value="{{$job_user}}">
										<input type="hidden" name="job_id" value="{{$job_id}}">
										<input type="hidden" name="proposal_id" value="{{$proposal_id}}">
										
										<fieldset>
											<div class="form-group">
												<textarea class="form-control" name="feedback" placeholder="Add Your Feedback*"></textarea>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="general_rating" id="general_rating" value="5">
												<div class="wt-ratepoints">
													<div class="counter wt-pointscounter">5.0</div>
													<div id="wt-jrate" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">General rating</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="skills_rating" id="skills_rating" value="4">
												<div class="wt-ratepoints">
													<div class="counterone wt-pointscounter">5.0</div>
													<div id="wt-jrateone" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Requirements Clarification</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="work_rating" id="work_rating" value="3">
												<div class="wt-ratepoints">
													<div class="countertwo wt-pointscounter">5.0</div>
													<div id="wt-jratetwo" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Quality of work</span>
											</div>
											<div class="form-group wt-ratingholder">
												<input type="hidden" name="communication_rating" id="communication_rating" value="2">
												<div class="wt-ratepoints">
													<div class="counterthree wt-pointscounter">5.0</div>
													<div id="wt-jratethree" class="wt-jrate"></div>
												</div>
												<span class="wt-ratingdescription">Communication</span>
											</div>
											<div class="form-group wt-btnarea">
												<button type="submit" class="wt-btn rounded-pill py-2 w-25">Send Feedback</button>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							@endif
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
					</div>
				</div>
			</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/additional-methods.min.js')}}"></script>
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});


	/* JRATE STARS  */
	jQuery(function () {
		var that = this;
		var toolitup = $("#wt-jrate").jRate({
			rating: 5.0,
			strokeColor: '#dadadacc',
			precision: 1,
			startColor: "#fecb02",
			endColor: "#fecb02",
			backgroundColor: '#ddd',
			minSelected: 1,
			shapeGap: '10px',
			count: 5,
			onChange: function(rating) {
				jQuery('.counter').text(rating + '');
			},
			onSet: function(rating) {
				console.log("OnSet: Rating: "+rating);
				$("#general_rating").val(rating);
			}
		});
	});
	
	jQuery(function () {
		var that = this;
		var toolitup = $("#wt-jrateone").jRate({
			rating: 4.0,
			strokeColor: '#dadadacc',
			precision: 1,
			startColor: "#fecb02",
			endColor: "#fecb02",
			backgroundColor: '#ddd',
			minSelected: 1,
			shapeGap: '10px',
			count: 5,
			onChange: function(rating) {
				jQuery('.counterone').text(rating + '');
			},
			onSet: function(rating) {
				console.log("OnSet: Rating: "+rating);
				$("#skills_rating").val(rating);
			}
		});
	});	
	
	jQuery(function () {
		var that = this;
		var toolitup = $("#wt-jratetwo").jRate({
			rating: 3.0,
			strokeColor: '#dadadacc',
			precision: 1,
			startColor: "#fecb02",
			endColor: "#fecb02",
			backgroundColor: '#ddd',
			minSelected: 1,
			shapeGap: '10px',
			count: 5,
			onChange: function(rating) {
				jQuery('.countertwo').text(rating + '');
			},
			onSet: function(rating) {
				console.log("OnSet: Rating: "+rating);
				$("#work_rating").val(rating);
			}
		});
	});	
	
	jQuery(function () {
		var that = this;
		var toolitup = $("#wt-jratethree").jRate({
			rating: 2.0,
			strokeColor: '#dadadacc',
			precision: 1,
			startColor: "#fecb02",
			endColor: "#fecb02",
			backgroundColor: '#ddd',
			minSelected: 1,
			shapeGap: '10px',
			count: 5,
			onChange: function(rating) {
				jQuery('.counterthree').text(rating + '');
			},
			onSet: function(rating) {
				console.log("OnSet: Rating: "+rating);
				$("#communication_rating").val(rating);
			}
		});
	});


	  $("#feedback_form").validate({


	      errorPlacement:function (error , element) {
	        error.insertAfter(element.parents(".form-group"))
	      },
	          rules: {
	              feedback: {
	                  required: true,
	                  // lettersonly: true
	              },
	              general_rating: {
	                  required: false,
	                  // lettersonly: true
	              },
	              skills_rating: {
	                  required: false,
	                  // email: true
	              },
	              work_rating: {
	                  required: false,
	                  // number: true
	              },
	              communication_rating: {
	                  required: false,
	                  
	              },
	              rating_by: {
	                  required: false,
	                  
	              },
	              rating_to: {
	                  required: false,
	                  
	              },
	              job_id: {
	                  required: false,
	                  
	              },
	              proposal_id: {
	                  required: false,
	                  
	              },


	          },
	          messages: {
	              feedback: {
	                  required: "Please enter feedback",

	              } ,
	              general_rating: {
	                  required: "Please select general rating",

	              } ,
	              skills_rating: {
	                  required: "Please select skills rating",

	              } ,
	              work_rating: {
	                  required: "Please select work rating",
	                  // number: "Please enter valid integer",
	              } ,
	              communication_rating: {
	                  required: "Please select communication rating",

	              } ,

	          },

	          submitHandler: function(form) {
	             form_Create(form);
	          }

	    });


	  function form_Create(formData) {
	//    let createFormData = $('#formCreate').serialize();
	var createFormData = new FormData (formData);
	    console.log(createFormData);
	    $.ajax({
	        url: "{{route('add-rating')}}",
	        type: 'POST',
	        data: createFormData,
	        contentType: false,
	        processData: false,

	        success: (response)=>{
	            if (response.status == 'true') {
	                $.notify(response.message , 'success'  );
	                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/completed-jobs";
	                
	                
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