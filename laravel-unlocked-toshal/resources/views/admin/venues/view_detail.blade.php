@extends('admin.layouts.cmlayout')

@section('body')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Venue Detail</h1>
	</div>
	<div class="flash-message">
		@if(session()->has('status'))
			@if(session()->get('status') == 'success')
				<div class="alert alert-success  alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
				</div>
			@endif
		@endif
	</div> <!-- end .flash-message -->
	<div class="row">
        <div class="col-xl-6 col-md-6">
			<div class="card shadow mb-4">
				<div class="card-body">

					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Owner Name</strong>
							<h5><span class="badge  badge-pill">{{ucfirst($venueDetail->user->first_name)}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Venue Name</strong>
							<h5><span class="badge  badge-pill">{{$venueDetail->name}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Is Featured</strong>
								@if($venueDetail->is_featured == 1)
									<h5><span class="badge  badge-pill">Yes</span></h5>
								@else
									<h5><span class="badge  badge-pill">No</span></h5>
								@endif
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Total Room</strong>
								<h5><span class="badge  badge-pill">{{$venueDetail->total_room}}</span></h5>
						</li>

					</ul>
				</div>
			</div>
        </div>
		<div class="col-xl-6 col-md-6">
			<div class="card shadow mb-4">
				<div class="card-body">
					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Location</strong>
							<h5><span class="badge  badge-pill">{{$venueDetail->location}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Contact</strong>
							<h5><span class="badge  badge-pill">{{$venueDetail->contact}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Building Type</strong>
							<h5><span class="badge  badge-pill">{{$venueDetail->building_type}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Booking Price</strong>
							<h5><span class="badge  badge-pill">{{$venueDetail->booking_price}}</span></h5>
						</li>

					</ul>
				</div>
			</div>
        </div>
	</div>
	<div class="row">
		<div class="col-xl-6 col-md-6">
			<div class="card shadow mb-4">
				<div class="card-body">
				<strong>Amenities</strong>
				<ul class="list-group">
				<li class="list-group-item">{{$venueDetail->amenities_detail}}</li>
				</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-6 col-md-6">
			<div class="card shadow mb-4">
				<div class="card-body">
				<strong>Other Information</strong>
				<ul class="list-group">
				<li class="list-group-item">{{$venueDetail->other_information}}</li>
				</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row venue-sec">
		<div class="col-xl-12 col-md-12">
			<div class="card shadow mb-4">
				<div class="card-body">
			<strong>Venue Images</strong>
				<div>
				@if(count($venueImages))
					@foreach($venueImages as $images)

						<img class="img-profile mt30" src="{{asset('/assets/venue/images/'.$images->name)}}" width="80px" height="80px" alt="Venue Image">
					@endforeach
				@else
					<li class="list-group-item ">No Image</li>
				@endif
				</div>
				</div>
			</div>
		</div>
	</div>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Latest Bookings</h1>
	</div>
	<div class="row">
        <div class="col-xl-12 col-md-12">
			<div class="card shadow mb-4">
			<div class="card-header py-3">
					<form class="form-inline float-left" id="search-form">
						<div class="form-group">
							<input type="text" class="form-control" data-model="User" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
						<!-- <a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('exportuser')}}">Export <i class="fa fa-file-csv"></i></a> -->
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>

									<th>@sortablelink('user.first_name', 'Customer Name')</th>
                                    <th>@sortablelink('booking_name','Booking Name')</th>
                                    <th>@sortablelink('booking_email','Booking Email')</th>
                                    <th>@sortablelink('booking_date','Booking Date')</th>
                                    <th>@sortablelink('status','Status')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
								</tr>
							</thead>
							<tbody>
								@php $i = 1 @endphp
								@foreach($bookings as $booking)
								<tr>
									<td>{{$i++}}</td>

									<td><a href="{{route('user.details',[$booking->user->id])}}">{{$booking->user->first_name .' '.$booking->user->last_name}}</a></td>
									<td><a href="{{route('booking.details',[$booking->id])}}">{{$booking->booking_name}}</a></td>
									<td>{{$booking->booking_email}}</td>
									<td>{{$booking->date}}</td>
									<td>@if($booking->status == 1)
											<a><h5><span class="badge badge-success">Approved</span></h5></a>
										@elseif($booking->status == 2)
											<a><h5><span class="badge badge-danger">Declined</span></h5></a>
										@else
										<h5><span class="badge badge-primary">New</span></h5>
										@endif
									</td>
									<td>{{$booking->created_at ? change_date_format($booking->created_at) : 'N/A'}}</td>
								</tr>

							@endforeach
							@if ($bookings->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No booking to display.</td>
								</tr>
							@endif
							</tbody>
						</table>
						{{ $bookings->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$bookings->count()}} of {{ $bookings->total() }} booking(s).
						</p>
					</div>
        		</div>
			</div>
        </div>
	</div>
</div>
@endsection