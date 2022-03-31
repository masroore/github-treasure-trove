@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<link href="{{URL::asset('admin-assets/assets/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('admin-assets/assets/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" />
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	.page-item.active .page-link {
    background-color: #ed1c24;
    border-color: #ed1c24;
    padding: 5px 20px;
    border-radius: 4px;
	}
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
		background: none;
		border: 0;
	}
	div.dataTables_wrapper div.dataTables_length select {
    height: auto;
    appearance: auto;
    padding: 5px 10px;
	}
	div.dataTables_wrapper div.dataTables_filter input {
    height: auto;
    padding: 5px 10px;
	}
	table.dataTable.no-footer {
	  border-bottom: 0;
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
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 float-right">
						<div class="wt-dashboardbox wt-dashboardinvocies">
							<div class="wt-dashboardboxtitle wt-titlewithsearch">
								<h2>Transactions</h2>
							</div>
							<div class="wt-dashboardboxcontent wt-categoriescontentholder wt-categoriesholder px-3 pt-4">
								<table class="trans-table">
									<thead>
										<tr>
											<th>#</th>
											<!-- <th>Transaction ID</th> -->
											<!-- <th>Job Title</th> -->
											<th>Amount</th>
											<th>Transaction</th>
											<th>Date</th>
											<!-- <th>Action</th> -->
										</tr>
									</thead>
									<tbody>
										@foreach($transactions as $key=>$transc)
										<tr>
											<td>{{$key+1}}</td>
											<td>${{$transc->amount}}</td>
											<td class="text-start">{{$transc->transaction}}</td>
											<td>{{date('d F,Y',strtotime($transc->created_at))}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{ $transactions->links('frontend.pagination.manage-jobs') }}
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-3 float-left">
						
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
<script src="{{asset('admin-assets/assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin-assets/assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin-assets/assets/js/datatable.js')}}"></script>
<script>
	$(document).ready(function() {
	    $('.trans-table').DataTable();
	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	function agree(id){
		$.ajax({
	    url: "{{url('transaction-agree')}}",
	    type: 'POST',
	    data: {"trans_id": id},

	    success: (response)=>{
	        if (response.status == 'true') {
	        	console.log(data);
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/transactions/";
	            
	            
	        }else{
	            $.notify(response.message , 'error');

	        }
	    },
	    error: (errorResponse)=>{
	        $.notify( errorResponse, 'error'  );


	    }
		})
	}
	function deliver(id){
		$.ajax({
	    url: "{{url('deliver-order')}}",
	    type: 'POST',
	    data: {"trans_id": id},

	    success: (response)=>{
	        if (response.status == 'true') {
	        	console.log(data);
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/transactions/";
	            
	            
	        }else{
	            $.notify(response.message , 'error');

	        }
	    },
	    error: (errorResponse)=>{
	        $.notify( errorResponse, 'error'  );


	    }
		})
	}
	function receive(id){
		$.ajax({
	    url: "{{url('receive-order')}}",
	    type: 'POST',
	    data: {"trans_id": id},

	    success: (response)=>{
	        if (response.status == 'true') {
	        	console.log(data);
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/transactions/";
	            
	            
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