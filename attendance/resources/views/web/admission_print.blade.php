<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Print Addmission Summary</title>
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
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Testimonials-Css -->
	<link href="css/mislider.css" rel="stylesheet" type="text/css" />
	<link href="css/mislider-custom.css" rel="stylesheet" type="text/css" />
	<!-- Style-Css -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!-- Font-Awesome-Icons-Css -->
	<link rel="stylesheet" href="css/fontawesome-all.css">
	<!-- //Custom-Files -->

	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	 rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
	<!-- //Web-Fonts -->

 <style>
  *{
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-print-color-adjust: exact !important;  
    color-adjust: exact !important;       
  }


  @media print {
    body {-webkit-print-color-adjust: exact;}
  }

</style>

</head>

<body>
	<div class="container" style="border:1px solid black;background-image:url('{{URL::to('images/osms.png')}}');">
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-2">
				<img width="100" height="100"src="{{URL::to('images/logo.png')}}"/>
			</div>
			<div class="col-md-9">
				<h1>Ogua School Management System</h1>
				<div class="col-md-10">
					<h1 class="text-center"> Application Declaration </h1>
					<img class="pull-right img-circle" width="150" height="150"src="{{asset('storage')}}/{{$personal->profileimg}}"/>
				</div>
			</div>
		</div>
		<hr style="border:1px solid black;">
		<h2 class="text-center"><b> Summary of Applicant's Informaton </h2><br>
		<p> I hereby declare that the information provided by me online regarding the summary of my bio-data and my entry qualification(s) as reproduced below are authentic and reflects my true records</b></p>
		<br><br>
					<div class="box-body">
					              <table class="table table-bordered table-striped">
					                <thead>
					        
					                </thead>
					                <tbody>
					                	<tr>
                  							<td colspan="2"><b> Personnal Information </b></td>
                  							<td colspan="2"><b> Application Information </b></td>
                  						</tr>
					                	<tr>
                  							<td>Fullname</td>
                  							<td>{{$personal->surname}} {{$personal->firstnames}} {{$personal->middlename}}</td>
                  							<td>Entry Level</td>
                  							<td>{{$appinfo->entrylevel}}</td>
                  						</tr>
                  						<tr>
                  							<td>Date of birth</td>
                  							<td>{{$personal->dateofbirth}}</td>
                  							<td>Session</td>
                  							<td>{{$appinfo->session}}</td>
                  						</tr>
                  	
                  						<tr>
                  							<td>Email</td>
                  							<td>{{$personal->email}}</td>
                  							<td>First Choice</td>
                  							<td>{{$appinfo->firstchoice}}</td>
                  						</tr>
                  						<tr>
                  							<td>Phone</td>
                  							<td>{{$personal->phone}}</td>
                  							<td>Second Choice</td>
                  							<td>{{$appinfo->secondchoice}}</td>
                  						</tr>
                  						<tr>
                  						<td>Marital Status</td>
                  							<td>{{$personal->maritalstutus}}</td>
                  							<td>Third Choice</td>
                  							<td>{{$appinfo->thirdchoice}}</td>
                  						</tr>
                  					</tbody>
             						</table>
             					</div>	

           <br>
					<div class="box-body">
					              <table class="table table-bordered table-striped">
					                <thead>
					                	<tr>
                  							<td colspan="4"><b>Examination results</b></td>
                  						</tr>
					        			<tr>
						                  <th>Subject</th>
						                  <th>Grade</th>
						                  <th>Index Number</th>
						                  <th>Year of Sitting</th>
						                </tr>
					                </thead>
					                <tbody>	

					                	<!--- Results 1 -->

					                	@if($result1->subject1)
										 <tr>
                  							<td>{{$result1->subject1}}</td>
                  							<td>{{$result1->grade1}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										      @endif

										@if($result1->subject2)
										 <tr>
                  							<td>{{$result1->subject2}}</td>
                  							<td>{{$result1->grade2}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										@endif

										@if($result1->subject3)
										 <tr>
                  							<td>{{$result1->subject3}}</td>
                  							<td>{{$result1->grade3}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										@endif

										@if($result1->subject4)
										 <tr>
                  							<td>{{$result1->subject4}}</td>
                  							<td>{{$result1->grade4}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										@endif


										@if($result1->subject5)
										 <tr>
                  							<td>{{$result1->subject5}}</td>
                  							<td>{{$result1->grade5}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										@endif


										@if($result1->subject6)
										 <tr>
                  							<td>{{$result1->subject6}}</td>
                  							<td>{{$result1->grade6}}</td>
                  							<td>{{$result1->indexnumber}}</td>
                  							<td>{{$result1->examyear}}</td>
                  						 </tr>
										@endif

					                	
										<!--- Results 2 -->
                    @if(isset($result2->subject1))
  										@if($result2->subject1)
  										 <tr>
                    							<td>{{$result2->subject1}}</td>
                    							<td>{{$result2->grade1}}</td>
                    							<td>{{$result2->indexnumber}}</td>
                    							<td>{{$result2->examyear}}</td>
                    						 </tr>
  										@endif
                    @endif

                     @if(isset($result2->subject2))
    										@if($result2->subject2)
    										 <tr>
                      							<td>{{$result2->subject2}}</td>
                      							<td>{{$result2->grade2}}</td>
                      							<td>{{$result2->indexnumber}}</td>
                      							<td>{{$result2->examyear}}</td>
                      						 </tr>
    										@endif
                    @endif

                     @if(isset($result2->subject3))
										@if($result2->subject3)
										 <tr>
                  							<td>{{$result2->subject3}}</td>
                  							<td>{{$result2->grade3}}</td>
                  							<td>{{$result2->indexnumber}}</td>
                  							<td>{{$result2->examyear}}</td>
                  						 </tr>
										@endif
                    @endif



                     @if(isset($result2->subject4))
										@if($result2->subject4)
										 <tr>
                  							<td>{{$result2->subject4}}</td>
                  							<td>{{$result2->grade4}}</td>
                  							<td>{{$result2->indexnumber}}</td>
                  							<td>{{$result2->examyear}}</td>
                  						 </tr>
										@endif
                    @endif


                     @if(isset($result2->subject5))
										@if($result2->subject5)
										 <tr>
                  							<td>{{$result2->subject5}}</td>
                  							<td>{{$result2->grade5}}</td>
                  							<td>{{$result2->indexnumber}}</td>
                  							<td>{{$result2->examyear}}</td>
                  						 </tr>
										@endif
                    @endif


                     @if(isset($result2->subject6))
										@if($result2->subject6)
										 <tr>
                  							<td>{{$result2->subject6}}</td>
                  							<td>{{$result2->grade6}}</td>
                  							<td>{{$result2->indexnumber}}</td>
                  							<td>{{$result2->examyear}}</td>
                  						 </tr>
										@endif
                    @endif



								<!---- Results3 ----->

                   @if(isset($result3->subject1))
										@if($result3->subject1)
										 <tr>
                  							<td>{{$result3->subject1}}</td>
                  							<td>{{$result3->grade1}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif


                     @if(isset($result3->subject2))
										@if($result3->subject2)
										 <tr>
                  							<td>{{$result3->subject2}}</td>
                  							<td>{{$result3->grade2}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif



                     @if(isset($result3->subject3))
										@if($result3->subject3)
										 <tr>
                  							<td>{{$result3->subject3}}</td>
                  							<td>{{$result3->grade3}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif

                     @if(isset($result3->subject4))
										@if($result3->subject4)
										 <tr>
                  							<td>{{$result3->subject4}}</td>
                  							<td>{{$result3->grade4}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif


                     @if(isset($result3->subject5))
										@if($result3->subject5)
										 <tr>
                  							<td>{{$result3->subject5}}</td>
                  							<td>{{$result3->grade5}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif


                     @if(isset($result3->subject6))
										@if($result3->subject6)
										 <tr>
                  							<td>{{$result3->subject6}}</td>
                  							<td>{{$result3->grade6}}</td>
                  							<td>{{$result3->indexnumber}}</td>
                  							<td>{{$result3->examyear}}</td>
                  						 </tr>
										@endif
                    @endif










                  					</tbody>
             						</table>
             					</div>	
<br><br>
          

             <p><b>Applicant Signature: &middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;</b><span class="pull-right">Date: <?php echo date('d-M-y');?></span></p>	

             <br><br>
             <h2 class="text-center"><b>WITNESS</b></h2><br>
             <p><b>To be completed by witness:</b></p>	

             <p>I certify that the photograph endorsed by me is the true likeness of the application. <br>
             	MR/Ms/Mrs:&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot; who is personally known by me. I have inspected the certificate(s) submitted by the applicate and to the best of my knowledge, they are genuine and the grades provided above are exact replication of the grades indicated on the certificate(s).<br><br>
             	<i>The witness must be someone of high repute (Chartered member of any recodgise Professional Body. Senior Public or Head of Last Educational Institution attended by the applicant).</i>
             </p>
             <br><br>
             <br><br><br><br><br><br>
             <p style="border-bottom: 2px dotted black;">Name: </p>
             <p>Signature/Stamp: </p><br><br><br>
             <p style="border-bottom: 2px dotted black;border-top: 2px dotted black;">Status/Position:</p>
             <p style="border-bottom: 2px dotted black;">Address: </p>
             <p style="border-bottom: 2px dotted black;">Date:</p>

             <br><br><br><br>
             <p>The endorsed copy of this declaration must be submiited together with copies of the applicant's birth certificate, result slip/certificate and in the case of HND/University Diploma holders, transcript of academic records in a manila envelope to the address below by EMS</p><br><br>

             <p class="text-center">The Director of Academic Affairs</p>
             <p class="text-center">Ogua School Management System</p>
             <p class="text-center">P.O.BOX TS 367</p>
             <p class="text-center">Accra</p>

            <br>
            <p><b>Closing date for submission is <?php echo date('d-m-y'); ?></b></p>











		 <div class="row">
			<div class="col-md-12">
				<a href="#" onclick="print();" id="print"class="btn btn-success pull-right">Print Document</a>
			</div>
		 </div>
	</div>
	<!-- Js files -->
	<!-- JavaScript -->
	<script src="js/jquery-2.2.3.min.js"></script>
	<!-- Default-JavaScript-File -->
	<script src="js/bootstrap.js"></script>
	<!-- Necessary-JavaScript-File-For-Bootstrap -->

	<!-- testimonial-plugin -->
	<script src="js/mislider.js"></script>
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

	<!-- smooth scrolling -->
	<script src="js/SmoothScroll.min.js"></script>
	<!-- //smooth scrolling -->

	<!-- move-top -->
	<script src="js/move-top.js"></script>
	<!-- easing -->
	<script src="js/easing.js"></script>
	<!--  necessary snippets for few javascript files -->
	<script src="js/edulearn.js"></script>

	<!-- //Js files -->
	<script>
		$('document').ready(function(){
			//alert('go');
			window.print();
		});
	</script>

</body>

</html>