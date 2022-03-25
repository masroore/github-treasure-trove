@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions |  OSN Payment')

<!-- @section('addcss')
		<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection -->

@section('content')
	<!-- banner -->
	<div class="banner-agile-2">
		@include('web.layouts.navigation')
	</div>
	<!-- breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.html">Home</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">OSN Payment</li>
		</ol>
	</nav>
	<!-- breadcrumb -->

	<!-- osn code purchase -->
	<div class="faq-w3l py-5">
		<div class="container py-xl-5 py-lg-3">
			<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">
				OSN PAYMENT
				<span class="font-weight-bold"></span>
			</h3>
			<div class="faq-info pt-md-4 bg-white">
				<div class="col-md-8 col-md-offset-3">
				 <!-- <h3 class="w3-head text-dark">Osn Purchase Payment</h3> -->
				 	@if(Session::has('message'))
				 		<div class="alert alert-success">
					 		 	{{Session::get('message')}}
					 	</div>
					@endif 	
					<img src="https://payments.ipaygh.com/app/webroot/img/LOGO-MER01095.jpeg" class="mx-auto d-block logo">

					<div class="faq-w3agile">
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
												<input type="text" title="Name" name="extra_name" value="{{$osn->lastname}} {{$osn->firstname}}" id="name" class="form-control" placeholder="First & Last Name">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="tel" title="Mobile Number" name="extra_mobile" id="number" value="{{$osn->phone}}"class="form-control" maxlength="10" placeholder="Contact Number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="email" name="email" id="extra_email" value="{{$osn->email}}"class="form-control" placeholder="Email">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg">
											<div class="form-group">
												<input type="text" name="total" class="form-control" value="{{$osn->amount}}" id="total" placeholder="Amount(GH₵)">
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
											<a href="{{route('osn-code-generate')}}" id="close">Pay Done</a>
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
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- //osn -->

	
@endsection