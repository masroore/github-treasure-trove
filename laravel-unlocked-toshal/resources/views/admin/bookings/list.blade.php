@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Bookings List</h1>
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
        <div class="col-xl-12 col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header booking-lst py-3">
					<form class="form-inline float-left" id="search-form">
						<div class="form-group">
							<input type="text" class="form-control" data-model="User" value="{{$keyword}}" data-searchcoulnm="first_name,last_name,email" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<div class="ml-2 form-group">
							<input type="text" class="form-control" id="daterange_filter" value="{{$daterange}}" name="daterange_filter"  placeholder="Select Date" readonly>
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
						<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('exportbooking')}}">Export <i class="fa fa-file-csv"></i></a>&nbsp;
					</div>
					<div class="buttons-right">
						<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('booking.add')}}">Add New Booking <i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>@sortablelink('venue.name', 'Venue Name')</th>
                                    <th>@sortablelink('user.first_name', 'User Name')</th>
                                    <!-- <th>@sortablelink('user.id', 'Customer LastName')</th> -->
                                    <th>@sortablelink('booking_name', 'Booking Name')</th>
                                    <th>@sortablelink('booking_email', 'Booking Email')</th>
                                    <th>@sortablelink('date', 'Booking Date')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<th>@sortablelink('status', 'Status')</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($data as $key => $row)

								<tr>
									<td>{{$i++}}</td>
                                    <td><a href="{{route('venue.details',[$row->venue->id])}}">{{$row->venue->name ? $row->venue->name : 'N/A' }}</a></td>
                                    <td><a href="{{route('user.details',[$row->user->id])}}">{{ucfirst($row->user->first_name) ." ".ucfirst($row->user->last_name) }}</a></td>
                        			<td>{{$row->booking_name ? $row->booking_name : 'N/A' }}</td>
                                    <td>{{$row->booking_email ? $row->booking_email : 'N/A' }}</td>
                                    <td>{{$row->date ? change_date_format($row->date) : 'N/A' }}</td>
									<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>
									<td>
									<a class="anchorLess">
										 @if($row->status == 1)
											<a><h5><span class="badge badge-success">Approved</span></h5></a>
										@elseif($row->status == 2)
											<a><h5><span class="badge badge-danger">Declined</span></h5></a>
										@else
											<a data-placement="bottom"  class="btn-xs myPopover" data-toggle="popover" data-content="<div><h5>
												<a  href='{{route("booking.confirm",["id" => $row->id,"status" => 1])}}' class='badge badge-success'>Approve</a>
												<a  href='{{route("booking.confirm",["id" => $row->id,"status" => 2])}}' class='badge badge-danger'>Decline</a></h5></div>"  id="" >
												<h5><span class="badge badge-primary">New</span></h5>
											</a>
										@endif
									</a>
									</td>
									<td style="display:flex">
										<a class="anchorLess">
											<a title="Click to Edit" href="{{route('booking.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true" ></i>
											</a>
											<a title="Click to View" href="{{route('booking.details',[$row->id])}}" class="anchorLess"><i class="fas fa-eye primary" aria-hidden="true" ></i>
											</a>
											<!-- @if($row->is_deleted == 0)<a title="Click to Delete" href="{{route('booking.delete',[$row->id])}}" class="anchorLess delete-confirm"><i class="fas fa-trash danger" aria-hidden="true" ></i>
											</a>
											@endif -->
										</a>
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No booking to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$data->count()}} of {{ $data->total() }} booking(s).
						</p>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<style>
.no-margin{margin:0px;}
</style>
<!-- /.container-fluid -->
@endsection
@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
jQuery(document).ready(function(){
	
	jQuery(".myPopover").popover({
		html: true
	});

	var today = new Date();
	jQuery("#daterange_filter").daterangepicker({
		format: 'YYYY-MM-DD',
		autoclose:true,
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	jQuery('#daterange_filter').on('apply.daterangepicker', function(ev, picker) {
		jQuery(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
	});
	jQuery('#daterange_filter').on('cancel.daterangepicker', function(ev, picker) {
		jQuery(this).val('');
	});
});
</script>
@stop