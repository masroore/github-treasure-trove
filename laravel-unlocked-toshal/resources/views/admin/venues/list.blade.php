@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Venues List</h1>
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
		<div class="col-md-4">
			<table class="table">
				<tr>
					<th scope="col">Total Bookings</th>
					<td>{{$totalbookings}}</td>
				</tr>
				<tr>
					<th scope="col">Total Venues</th>
					<td>{{$totalVenues}}</td>
				</tr>
			</table>
		</div>
		<div class="col-xl-12 col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<form class="form-inline float-left" id="search-form">
						<div class="form-group">
							<input type="text" class="form-control" data-model="User" id="search_keyword" value="{{$keyword}}" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
						<a class=" font-weight-bold btn-department-add pull-right hover-white" href="{{route('exportvenue')}}">Export <i class="fa fa-file-csv"></i></a>&nbsp;&nbsp;
					</div>
					<div class="buttons-right">
						<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('venue.add')}}">Add New Venue <i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>
									<th>@sortablelink('id', 'Booking Count')</th>
									<th>@sortablelink('user.id', 'Owner Name')</th>
									<th>@sortablelink('name', 'Name')</th>
									<th>@sortablelink('location', 'Location')</th>
									<th>@sortablelink('contact', 'Contact')</th>
									<th>@sortablelink('building_type', 'Building type')</th>
									<th>@sortablelink('building_type', 'Building type')</th>
									<th>@sortablelink('total_room', 'Total Room')</th>
									<th>@sortablelink('booking_price', 'Booking Price')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<!-- <th>@sortablelink('is_deleted', 'Deleted')</th> -->
									<th>@sortablelink('is_featured', 'Is Featured')</th>
									<th>@sortablelink('status', 'Status')</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php $i = 1 @endphp
								@foreach($data as $key => $row)
								<tr>
									<td>{{$i++}}</td>
									<td> {{$row->booking->count()}}</td>
									<td><a href="{{route('owner.details',[$row->user->id])}}">{{ucfirst($row->user->first_name)." ". ucfirst($row->user->last_name) }}</a></td>
									<td>{{$row->name ? $row->name : 'N/A' }}</td>
									<td>{{$row->location ? $row->location : 'N/A' }}</td>
									<td>{{$row->contact ? $row->contact : 'N/A' }}</td>
									<td>{{$row->building_type ? $row->building_type : 'N/A' }}</td>
									<td>{{$row->total_room ? $row->total_room : 'N/A' }}</td>
									<td>{{$row->booking_price ? $row->booking_price : 'N/A' }}</td>

									<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>

									<td>@if($row->is_featured == 0)
										<a title="Click to Enable" href="{{route('venue.status', ['id' => $row->id, 'is_featured' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
										@else
										<a title="Click to Disable" href="{{route('venue.status', ['id' => $row->id, 'is_featured' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
										@endif
									</td>
									<td>@if($row->status == 0)
										<a title="Click to Enable" href="{{route('venue.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
										@else
										<a title="Click to Disable" href="{{route('venue.status', ['id' => $row->id, 'status' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
										@endif
									</td>
									<td>
										<a title="Click to Edit" href="{{route('venue.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true"></i></a>
										<a title="Click to View" href="{{route('venue.details',[$row->id])}}" class="anchorLess"><i class="fas fa-eye primary" aria-hidden="true"></i></a>
										&nbsp;
										@if($row->is_deleted == 1)
										<a title="Click to Recover" href="{{route('venue.delete',['id' => $row->id, 'is_deleted' => 0])}}" class="tableLink"><i class="fas fa-trash-restore info"></i></a>
										@else
										<a title="Click to Delete" href="{{route('venue.delete',['id' => $row->id, 'is_deleted' => 1])}}" class="tableLink delete-confirm"><i class="fas fa-trash danger"></i></a>
										@endif
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No venue to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$data->count()}} of {{ $data->total() }} venue(s).
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.no-margin {
		margin: 0px;
	}
</style>
<!-- /.container-fluid -->
@endsection