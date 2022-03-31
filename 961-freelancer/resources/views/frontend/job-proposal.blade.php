@extends('frontend.layouts.app')
@section('content')
<style>
	input[type='radio'] {
	    /*-webkit-appearance:none;*/
	    width:20px;
	    height:20px;
	    border:1px solid #ed1c24;
	    border-radius:50%;
	    outline:none;
	    /*box-shadow:0 0 5px 0px gray inset;*/
	}
	input[type='radio']:hover {
	    box-shadow:0 0 5px 0px #00a651 inset;
	}
	input[type='radio']:before {
	    content:'';
	    display:block;
	    width:60%;
	    height:60%;
	    margin: 20% auto;    
	    border-radius:50%;    
	}
	input[type='radio']:checked:before {
	    background:#00a651;
	}
</style>
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
	<div class="wt-haslayout wt-main-section">
		<!-- User Listing Start-->
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
					<div class="wt-title border-bottom pb-1 bg-white ps-4 pt-3">
						<h2 class="fs-3 fw-normal ps-2">Job Detail</h2>
					</div>
					<div class="wt-proposalholder">
						<!-- <span class="wt-featuredtag"><img src="{{asset('assets/images/joblisting/featured.png')}}" alt="img description" data-tipso="Plus Member" class="template-content tipso_style"></span> -->
						<div class="row pt-3">
							<div class="col-12">
								<div class="wt-proposalhead">
									<h2>{{$jobData->job_title}} </h2>
									<ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
										<li><span><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i> {{$jobData->service_level}}</span></li>
										<li><span><i class="fa fa-map-marker-alt"></i>  {{$jobData->job_location}}</span></li>
										<li><span class="text-capitalize"><i class="far fa-folder"></i> Type: {{$jobData->job_type}}</span></li>
										<li><span><i class="far fa-clock"></i> Duration: {{$jobData->job_duration}}</span></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="description">
									<p class="lh-lg">{{$jobData->job_description}}</p>
								</div>
							</div>
						</div>
						<div class="wt-skillsrequired pt-3 border-top">
							<div class="wt-title">
								<h3 class="fs-6 fw-normal">Skills Required</h3>
							</div>
							<div class="wt-tag wt-widgettag">
								@if ($jobData->job_skills != "")
									@foreach(explode(',',$jobData->job_skills) as $skill)
									<a href="javascript:void(0);">{{$skill}}</a>
									@endforeach
								@endif
							</div>
						</div>
					</div>
					<div class="wt-proposalamount-holder">
						<div class="wt-title border-bottom">
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fs-3">Proposal Terms</h2>
								@if($jobData->job_type == 'fixed')
								<h4 class="mb-0 fw-normal fs-6">Client's Budget: <span class="text-danger fw-bold">${{$jobData->fixed_price}}</span></h4>
								@endif
							</div>
						</div>
						@if($jobData->job_type == 'fixed')
						<div class="wt-proposalamount accordion">
							<div class="form-group mb-3">
								<label class="fw-bold">How do you want to be paid?</label>
								<div class="mb-3 d-flex">
									<div class="me-2">
										<input type="radio" name="proposal_type" form="propsalSubmit" id="byProject" class="mt-1" value="by_project" checked="">
									</div>
									<div class="text ps-2">
										<label for="byProject">
											By Project
											<p>Get your entire payment at the end, when all work has been delivered.</p>
										</label>
									</div>
								</div>
								<div class="mb-3 d-flex">
									<div class="me-2">
										<input type="radio" name="proposal_type" form="propsalSubmit" id="byMilestone" class="mt-1" value="by_milestone">
									</div>
								 	<div class="ps-2">
								 		<label for="byMilestone">
							 			 	By Milestone
							 				<p>Divide the project into smaller segments, called milestones. You'll be paid for milestones as they are completed and approved.</p> 	
								 		</label>
								 	</div>
								</div>
							</div>
							<div id="by_project">
								<div class="form-group">
									<span>( <i class="fa fa-dollar-sign"></i> )</span>
									<input type="number" name="budget" onkeyup="getBudget(this)" form="propsalSubmit" value="{{old('budget')}}" class="form-control" placeholder="Enter Your Proposal Amount">
									<input type="hidden" name="budget_receive" form="propsalSubmit" value="">
									<input type="hidden" name="service_fee" form="propsalSubmit" value="">
									<a href="javascript:void(0);" class="collapsed" id="headingOne" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fal fa-chevron-up"></i></a>
									<em>Total amount the client will see on your proposal</em>
								</div>
								<ul class="wt-totalamount collapse show" id="collapseOne" aria-labelledby="headingOne">
									<li>
										<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="service_fee">- 00.00</em></h3>
										<span><strong>5% “ 961Freelancer ”</strong> Service Fee<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
									</li>
									<li>
										<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="total_budget">- 00.00</em></h3>
										<span>Amount You’ll Recive after <strong>“ 961Freelancer ”</strong> Service Fee deduction<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
									</li>
								</ul>
							</div>
							<div id="by_milestone" class="d-none">
								<div class="form-group pe-0">
									<label class="fw-bold">How many milestones do you want to include?</label>
									<div class="row d-flex align-items-center mb-4">
										<div class="col-1">
											<p class="mb-0 fw-bold text-center pt-4">1</p>
										</div>
										<div class="col-5">
											<label class="mb-0 fw-bold">Description</label>
											<input type="text" name="milestone_detail[]" form="propsalSubmit" class="form-control p-2">
										</div>
										<div class="col-3">
											<label class="mb-0 fw-bold">Due Date</label>
											<input type="date" name="milestone_due_date[]" form="propsalSubmit" class="form-control p-2">
										</div>
										<div class="col-3">
											<label class="mb-0 fw-bold">Amount</label>
											<input type="text" name="milestone_amount[]" form="propsalSubmit" class="form-control p-2 amount" placeholder="$">
										</div>
										
									</div>
									<div class="milstone-added">
										
									</div>
									<p class="mb-0 fw-bold add-milestone ps-3" style="cursor: pointer;color: #00a651;">+ Add milestone</p>
								</div>
								<input type="hidden" name="budget" value="">
								<input type="hidden" name="service_fee" value="">
								<input type="hidden" name="budget_receive" value="">
								<ul class="wt-totalamount collapse show" id="collapseOne" aria-labelledby="headingOne">
									<li>
										<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="total_amount">- 00.00</em></h3>
										<span>This includes all milestones, and is the amount your client will see.</span>
									</li>
									<li>
										<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="service_fee">- 00.00</em></h3>
										<span><strong>5% “ 961Freelancer ”</strong> Service Fee<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
									</li>
									<li>
										<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="total_budget">- 00.00</em></h3>
										<span>Amount You’ll Recive after <strong>“ 961Freelancer ”</strong> Service Fee deduction<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
									</li>
								</ul>
							</div>
						</div>
						@endif
						@if($jobData->job_type == 'hourly')
						<div class="wt-proposalamount accordion">
							<label class="fw-bold">What is the rate you'd like to bid for this job?</label>
							<div class="row mt-4 mb-4">
								<div class="col-md-6">
									<p>Your Profile rate: <strong>${{Auth::user()->hourly_rate}}/hr</strong></p>
								</div>
								<div class="col-md-6">
									<p>Client's budget: <strong>${{$jobData->hourly_min_price}}-${{$jobData->hourly_max_price}}/hr</strong></p>
								</div>
							</div>
							<input type="hidden" name="proposal_type" form="propsalSubmit" class="mt-1" value="hourly">
								<label class="fw-bold mb-0">Hourly Rate</label>
							<div class="form-group">
								<span>( <i class="fa fa-dollar-sign"></i> )</span>
								<input type="number" onkeyup="getBudget(this)" form="propsalSubmit" class="form-control" id="hourly_price" name="budget" placeholder="Enter Your Proposal Amount" value="{{Auth::user()->hourly_rate}}">
								<input type="hidden" name="budget_receive" form="propsalSubmit" value="">
								<input type="hidden" name="service_fee" form="propsalSubmit" value="">
								<a href="javascript:void(0);" class="collapsed" id="headingOne" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fal fa-chevron-up"></i></a>
								<em>Total amount the client will see on your proposal</em>
							</div>

							<ul class="wt-totalamount collapse show" id="collapseOne" aria-labelledby="headingOne">
								<li>
									<h3>( <i class="fa fa-dollar-sign"></i> ) <em  class="service_fee">- 00.00</em>/hr</h3>
									<span><strong>5% “ 961Freelancer ”</strong> Service Fee<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
								</li>
								<li>
									<h3>( <i class="fa fa-dollar-sign"></i> ) <em class="total_budget">- 00.00</em>/hr</h3>
									<span>Amount You’ll Recive after <strong>“ 961Freelancer ”</strong> Service Fee deduction<i class="fal fa-exclamation-circle template-content tipso_style" data-tipso="Plus Member"></i></span>
								</li>
							</ul>
						</div>
						@endif
						<div class="wt-title border-bottom">
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fs-3">Additional Details</h2>
							</div>
						</div>
						<form class="wt-formtheme wt-formproposal" method="post" action="{{route('proposal.store')}}" id="propsalSubmit"  enctype="multipart/form-data">
							@if ($errors->any())
							 <div class="alert alert-danger">
							    <ul>
							       @foreach ($errors->all() as $error)
							       <li>{{ $error }}</li>
							       @endforeach
							    </ul>
							 </div>
							@endif
							@csrf
							<input type="hidden" name="job_id" value="{{$jobData->job_id}}">
							<fieldset>
								@if($jobData->job_type != 'hourly')
								<div class="form-group">
									<span class="wt-select">
										<select name="duration">
											<option value="1">I Can Finish This Project In: 01 Months</option>
											<option value="2">I Can Finish This Project In: 02 Months</option>
											<option value="3">I Can Finish This Project In: 03 Months</option>
											<option value="4">I Can Finish This Project In: 04 Months</option>
										</select>
									</span>
								</div>
								@endif
								<!-- @if($jobData->job_type == 'hourly')
								<div class="form-group">
									<input type="number" name="proposed_hours" class="form-control" placeholder="Expected Hours" style="height: 50px;">
								</div>
								@endif -->
								<div class="form-group">
									<textarea class="form-control" name="cover_letter" placeholder="Add Description*">{{old('cover_letter')}}</textarea>
								</div>
							</fieldset>
							
							<fieldset>
								<div class="wt-attachments wt-attachmentsvtwo">
									<div class="wt-title">
										<h3>Upload File (Optional)</h3>
										<label for="afile">
											<span><i class="fal fa-paperclip"></i> Attach File(s)</span>
											<input type="file" name="attachments[]" id="afile" onchange="JobImages(this)" multiple>
										</label>
									</div>
									<ul class="wt-attachfile">
									</ul>
									<div class="wt-btnarea">
										<button type="submit" class="wt-btn">Send Now</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- User Listing End-->
	</div>
</main>
<!--Main End-->
@endsection
@section('script')
<script>
	
	$('#byProject').click(function(){
		$('#by_project').show();
		$('#by_milestone').addClass('d-none');

	})
	$('#byMilestone').click(function(){
		$('#by_project').hide();
		$('#by_milestone').removeClass('d-none');

	})
		var i = 2;
	$('.add-milestone').click(function(){
		// i++;
		$('.milstone-added').append('<div class="row d-flex align-items-center mb-4 milestone-'+ i +'"><div class="col-1"><p class="mb-0 fw-bold text-center pt-4">'+ i +'</p></div><div class="col-5"><label class="mb-0 fw-bold">Description</label><input type="text" name="milestone_detail[]" form="propsalSubmit" class="form-control p-2"></div><div class="col-3"><label class="mb-0 fw-bold">Due Date</label><input type="date" name="milestone_due_date[]" form="propsalSubmit" class="form-control p-2"></div><div class="col-2"><label class="mb-0 fw-bold">Amount</label><input type="text" name="milestone_amount[]" form="propsalSubmit" class="form-control p-2 amount" placeholder="$"></div><div class="col-1"><p class="mb-0 fw-bold text-center pt-4" onclick="removeMilestone('+ i +')" style="cursor: pointer;color: #00a651;">X</p></div></div>');
		i++;
	});

	function removeMilestone(id){
		$('.milestone-'+id).remove();
	}

	 	function JobImages(input) {
	 		console.log(input);

	 		var fi = input;

	      // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
	      if (fi.files.length > 0) {

	          // THE TOTAL FILE COUNT.
	          // document.getElementById('fp').innerHTML =
	              // 'Total Files: <b>' + fi.files.length + '</b></br >';

	          // RUN A LOOP TO CHECK EACH SELECTED FILE.
	          for (var i = 0; i <= fi.files.length - 1; i++) {

	              var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
	              var _size = fi.files.item(i).size;      // THE SIZE OF THE FILE.
	              var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
	                    		j=0;while(_size>900){_size/=1024;j++;}
	                        var exactSize = (Math.round(_size*100)/100)+' '+fSExt[j];

	              $('.wt-attachfile').append('<li class="wt-uploaded"><span class="uploadprogressbar"></span><span>'+fname+'</span><em>File size: '+exactSize+'</em></li>');
	              // $('.fileSizea').html(fsize);
	              // SHOW THE EXTRACTED DETAILS OF THE FILE.
	          }
	      }
	      else { 
	          alert('Please select a file.') 
	      }  
		}
	$( document ).ready(function() {
		var rate = $('#hourly_price').val();
		var multiply = 5 * rate;
			var fee = multiply/100;
			// alert(fee);
			var budget = rate - fee;
			// alert(budget);
			$('.service_fee').html('- ' + fee);
			$('.total_budget').html('- ' + budget);
			$('input[name="budget_receive"]').val(budget);
			$('input[name="service_fee"]').val(fee);
		
	});
		function getBudget(input){
			var multiply = 5 * input.value;
			var fee = multiply/100;
			// alert(fee);
			var budget = input.value - fee;
			// alert(budget);
			$('.service_fee').html('- ' + fee);
			$('.total_budget').html('- ' + budget);
			$('input[name="budget_receive"]').val(budget);
			$('input[name="service_fee"]').val(fee);
		}

		// var total = 0;
		// function milestoneAmount(e) {
		//     // $('input.amount').each(function() {
		//     	console.log(e.value);
		//     var total = total + e.value;
		//     alert(total);
		//     // });
		//     var multiply = 5 * total;
		//     var fee = multiply/100;
		//     var budget = total - fee;
		//     // total = numIn - numOut;

		//     $('.total_amount').html('- ' + total +'.00');
		//     $('.total_amount').fadeIn(250);
		//     $('input[name="budget"]').val(total);
		//     $('input[name="budget_receive"]').val(budget);
		// 	$('input[name="service_fee"]').val(fee);
		//     // return false;
		// }

		$(document).on("change", ".amount", function() {
		    var total = 0;
		    var multiply = 0;
		    var fee = 0;
		    var budget = 0;
		    $(".amount").each(function(){
		        total += +$(this).val();
		        multiply = 5 * total;
		        fee = multiply/100;
		        budget = total - fee;
		    });
		    $('.total_amount').html('- ' + total +'.00');
		    $('.service_fee').html('- ' + fee);
			$('.total_budget').html('- ' + budget);
	        $('.total_amount').fadeIn(250);
	        $('input[name="budget"]').val(total);
	        $('input[name="budget_receive"]').val(budget);
	    	$('input[name="service_fee"]').val(fee);
		});
</script>
@endsection