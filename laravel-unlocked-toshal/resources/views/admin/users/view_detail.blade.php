@extends('admin.layouts.cmlayout')

@section('body')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">User Detail</h1>
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
							<strong>User Name</strong>
							<h5><span class="badge  badge-pill">{{ucfirst($userDetail->first_name) ." ".ucfirst($userDetail->last_name)}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Email</strong>
							<h5><span class="badge  badge-pill">{{$userDetail->email}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Status</strong>
							@if($userDetail->status == "1")
								<h5><span class="badge badge-success badge-pill">Active</span></h5>
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
							<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->address) ? $userDetail->user_detail->address :"N/A"}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Contact</strong>
							<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->mobile) ? $userDetail->user_detail->mobile : "N/A"}}</span></h5>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<strong>Zipcode</strong>
							<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->zipcode)? $userDetail->user_detail->zipcode :"N/A"}}</span></h5>
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
							<input type="text" class="form-control" data-model="User"  id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
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
                                    <th>@sortablelink('venue.name', 'Venue Name')</th>
                                    <th>@sortablelink('booking_name', 'Booking Name')</th>
                                    <th>@sortablelink('booking_email', 'Booking Email')</th>
                                    <th>@sortablelink('date', 'Booking Date')</th>
                                    <th>@sortablelink('status', 'Status')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($bookings as $key => $row)
								<tr>
									<td>{{$i++}}</td>
									<td><a href="{{route('venue.details',[$row->venue->id])}}">{{$row->venue->name ? $row->venue->name : 'N/A' }}</a></td>
									<td><a href="{{route('booking.details',[$row->id])}}">{{$row->booking_name ? $row->booking_name : 'N/A' }}</a></td>
									<td>{{$row->booking_email ? $row->booking_email : 'N/A' }}</td>
									<td>{{$row->date ? change_date_format($row->date) : 'N/A' }}</td>
									<td>@if($row->status == 1)
											<a><h5><span class="badge badge-success">Approved</span></h5></a>
										@elseif($row->status == 2)
											<a><h5><span class="badge badge-danger">Declined</span></h5></a>
										@else
										<h5><span class="badge badge-primary">New</span></h5>
										@endif
									</td>
									<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>
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