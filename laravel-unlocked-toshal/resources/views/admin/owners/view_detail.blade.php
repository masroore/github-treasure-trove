@extends('admin.layouts.cmlayout')

@section('body')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Owner Detail</h1>
	</div>
	<div class="row">
	<div class="col-xl-6 col-md-6">
			<div class="card shadow mb-4">
				<div class="card-body">

					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>User Name</strong>
							<h5><span class="badge  badge-pill">{{ucfirst($ownerDetail->first_name) ." ".ucfirst($ownerDetail->last_name)}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Email</strong>
							<h5><span class="badge  badge-pill">{{$ownerDetail->email}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Status</strong>
							@if($ownerDetail->status == "1")
								<h5><span class="badge badge-success  badge-pill">Active</span></h5>
							@else
								<h5><span class="badge badge-danger  badge-pill">Inactive</span></h5>
							@endif
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
							<strong>Address</strong>
							<h5><span class="badge  badge-pill">{{isset($ownerDetail->user_detail->address) ? $ownerDetail->user_detail->address:"N/A"}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Contact</strong>
							<h5><span class="badge  badge-pill">{{isset($ownerDetail->user_detail->mobile) ? $ownerDetail->user_detail->mobile : "N/A"}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Zipcode</strong>
							<h5><span class="badge  badge-pill">{{isset($ownerDetail->user_detail->zipcode) ? $ownerDetail->user_detail->zipcode : "N/A"}}</span></h5>
						</li>
					</ul>
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
									<th>@sortablelink('name', 'Venue Name')</th>
									<th>Customer Name</th>
                                    <th>Booking Name</th>
                                    <th>Booking Email</th>
                                    <th>Booking Date</th>
                                    <th>@sortablelink('status','Status')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
							@foreach($venuesBooking as $key => $bookings)
								@foreach($bookings->booking as $booking)
								<tr>
									<td>{{$i++}}</td>
									<td><a href="{{route('venue.details',[$bookings->id])}}">{{$bookings->name}}</a></td>
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
							@endforeach
							@if ($venuesBooking->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No booking to display.</td>
								</tr>
							@endif
							</tbody>
						</table>
						{{ $venuesBooking->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$venuesBooking->count()}} of {{ $venuesBooking->total() }} booking(s).
						</p>
					</div>
        		</div>
			</div>
        </div>
	</div>
</div>
@endsection