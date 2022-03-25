@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions | Purchase OSN Code')

@section('addcss')
		<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection

@section('content')
	<!-- banner -->
	<div class="banner-agile-2">
		@include('web.layouts.navigation')
	</div>
	<!-- breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ route('home') }}">Home</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Purchase OSN Code</li>
		</ol>
	</nav>
	<!-- breadcrumb -->

	<!-- osn code purchase -->

	<div class="form-w3l py-5">
	<div class="container py-xl-5 py-lg-3">
		<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">OSN PURCHASE
			<span class="font-weight-bold">form</span>
		</h3>
		<div class="register-form pt-md-4">
			<div class="col-md-8 col-md-offset-1">
				 	@if(Session::has('message'))
				 		<div class="alert alert-success">
					 		 	{{Session::get('message')}}
					 		 	<span class="pull-right"><a href="{{route('osn-payment')}}" onclass="btn btn-success">Proceed to Payment |</a></span>
					 	</div>
					@endif 	
					<div class="faq-w3agile ">
						<form method="post" action="{{route('purchase-osn-code')}}" id="purchasecode">
							@csrf
							<fieldset>Applicant Information
								<div class="form-group">
									<label>Enter Firstname</label>
									<input type="text" name="fname" id="fname" class="form-control" value="{{old('fname')}}" required>
									<span class="help-block" style="color:red;">@error('fname'){{ $message }}@enderror</span>
								</div>
								<div class="form-group">
									<label>Enter Lastname</label>
									<input type="text" name="lname" id="lname" class="form-control" value="{{old('lname')}}" required>
									<span class="help-block" style="color:red;">@error('lname'){{ $message }}@enderror</span>
								</div>
								<div class="form-group">
									<label>Enter Othernames</label>
									<input type="text" name="oname" id="oname" class="form-control" value="{{old('oname')}}">
									<span class="help-block" style="color:red;">@error('oname'){{ $message }}@enderror</span>
								</div>
								<div class="form-group">
									<label>Enter Email</label>
									<input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
									<span class="help-block" style="color:red;">@error('email'){{ $message }}@enderror</span>
								</div>
								<div class="form-group">
									<label>Enter Phone Number</label>
									<input type="number" name="pnumber" id="pnumber" class="form-control" style="background: none;" value="{{old('pnumber')}}">
									<span class="help-block" style="color:red;">@error('pnumber'){{ $message }}@enderror</span>
								</div>

								<div class="form-group" style="height: 40px;">
									<label>Select Programme [note: Diploma Cost GH&cent;180 while Degree Cost GH &cent; 200]</label>
									<select name="prog" id="prog" class="form-control" required style="height: 40px;background: none;">
										<option value=""></option>
										<option value="Degree Programme">Degree Programme</option>
										<option value="Diploma Programme">Diploma Programme</option>
									</select>
									<span class="help-block" style="color:red;">@error('prog'){{ $message }}@enderror</span>
								</div>
								
							
								<br>

								<div class="form-group">
									<input type="hidden" name="pyear" value="<?php echo date('Y');?>"id="pyear" class="form-control" required>
								</div>
								<div class="form-group">
									<input type="submit" value="Proceed to Payment" name="send" id="send" class="btn btn-info">
								</div>
								
								
							</fieldset>
						</form>
					</div>
				</div>

		</div>
	</div>
</div>
	<!-- //osn -->


<!---- Ipay Modal ---->
	<div id="ipayModal" class="modal fade m-auto" role="dialog" data-keyboard="true" data-backdrop="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<img src="https://payments.ipaygh.com/app/webroot/img/LOGO-MER01095.jpeg" class="mx-auto d-block logo">
							</div>
							<form action="https://community.ipaygh.com/gateway" id="ipay_checkout" method="post" name="ipay_checkout" target="_blank">
								<div class="modal-body">
									<legend class="text-center mt-1">Make Payment</legend>
									<input name="merchant_key" type="hidden" value="5c841bf2-d29b-11e7-aebc-f23c9170642f">
									<input id="merchant_code" type="hidden" value="TST000000000950">
									<input name="success_url" type="hidden" value="">
									<input name="cancelled_url" type="hidden" value="">
									<input id="invoice_id" name="invoice_id" type="hidden" value="">
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="text" title="Name" name="extra_name" value="" id="name" class="form-control" placeholder="First & Last Name">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="tel" title="Mobile Number" name="extra_mobile" id="number" value=""class="form-control" maxlength="10" placeholder="Contact Number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="email" name="email" id="extra_email" value=""class="form-control" placeholder="Email">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="text" name="total" class="form-control" value="" id="total" placeholder="Amount(GH₵)">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input class="form-control" type="text" value="Admission Form Payment" name="description" id="description" placeholder="Car Parking Payment">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<button type="submit" class="btn btn-primary ipay-btn btn-block" style="padding: 8px 11px;"><strong>Pay</strong></button>
										</div>
									</div>
									<div class="row">
										<div class="col-lg text-center mt-2">
											<a href="" data-dismiss="modal" id="close">Cancel</a>
										</div>
									</div>
									<div class="row">
										<div class="col-lg text-center mt-2">
											<a href="{{route('home')}}" id="close">Pay Done</a>
										</div>
									</div>
								</div>
								<div class="modal-footer justify-content-center ">
									<div class="row">
										<div class="col-lg">
											<img src="https://payments.ipaygh.com/app/webroot/img/iPay_payments.png" style="width: 100%;" class="img-fluid mr-auto" alt="Powered by iPay">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
			<script type="text/javascript">(function(){Date.prototype.today = function () { return  this.getFullYear()+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +((this.getDate() < 10)?"0":"") + this.getDate();};Date.prototype.timeNow = function () { return ((this.getHours() < 10)?"0":"") + this.getHours() +((this.getMinutes() < 10)?"0":"") + this.getMinutes() +((this.getSeconds() < 10)?"0":"") + this.getSeconds();};document.getElementById("invoice_id").value = document.getElementById("merchant_code").value+ new Date().today() + new Date().timeNow();})();</script>
	
		

	
@endsection