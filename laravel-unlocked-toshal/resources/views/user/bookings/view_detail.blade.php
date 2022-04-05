@extends('user.layouts.cmlayout')

@section('body')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Booking Detail</h1>
	</div>
	<div class="row">
	<div class="col-xl-4 col-md-4">
			<div class="card shadow mb-4">
				<div class="card-body">

					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Booking Name</strong>
							<h5><span class="badge  badge-pill">{{isset($bookingDetail->booking_name) ? $bookingDetail->booking_name :""}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Booking Email</strong>
							<h5><span class="badge  badge-pill">{{isset($bookingDetail->booking_email) ? $bookingDetail->booking_email :""}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Status</strong>
								@if($bookingDetail->status == 0)
									<h5><span class="badge badge-succcess  badge-pill">New</span></h5>
								@elseif($bookingDetail->status == 1)
									<h5><span class="badge badge-succcess  badge-pill">Approved</span></h5>
								@elseif($bookingDetail->status == 3)
									<h5><span class="badge badge-warning badge-pill">Cancelled</span></h5>
								@else
									<h5><span class="badge badge-danger  badge-pill">Declined</span></h5>
								@endif
						</li>
					</ul>
				</div>
			</div>
        </div>
        <div class="col-xl-4 col-md-4">
			<div class="card shadow mb-4">
				<div class="card-body">
					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Venue</strong>
							<h5><span class="badge  badge-pill">{{$bookingDetail->venue->name}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Date</strong>
							<h5><span class="badge  badge-pill">{{$bookingDetail->date ? change_date_format($bookingDetail->date) : 'N/A'}}</span></h5>
						</li>
					</ul>
				</div>
			</div>
        </div>
	</div>
</div>
@endsection