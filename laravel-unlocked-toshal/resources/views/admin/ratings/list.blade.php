@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Ratings List</h1>
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
				<div class="card-header py-3">
					<form class="form-inline float-left" id="search-form">
						<div class="form-group">
							<input type="text" value="{{$keyword}}" class="form-control" data-model="User" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
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
									<th>@sortablelink('venue.name', 'Venue name')</th>
									<th>@sortablelink('user.first_name', 'User Name')</th>
									<th>@sortablelink('rating', 'Rating')</th>
									<th>@sortablelink('review', 'Review')</th>
									<th>@sortablelink('status', 'Status')</th>
									<th>@sortablelink('created_at', 'Created Date')</th
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($data as $key => $row)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$row->venue->name ? $row->venue->name : 'N/A' }}</td>
									<td>{{(isset($row->user->first_name) ? $row->user->first_name : '') .' '. (isset($row->user->last_name) ? $row->user->last_name:'')}}</td>
									<td>
										@php $z = 1; @endphp
											@while ($z <= $row->rating)
											<i class="fas fa-star" style="color:#edd34e"></i>
											@php $z++ @endphp

											@endwhile
										@if($row->rating + 0.5 == $z)
												<i class="fas fa-star-half" style="color:#edd34e"></i>
										@endif
									<td>{{$row->review ? $row->review : 'N/A' }}</td>
									<td>
									@if($row->status == 0)
										<a title="Click to Enable" href="{{route('rating.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
									@else
										<a title="Click to Disable" href="{{route('rating.status', ['id' => $row->id, 'status' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
									@endif
									</td>
									<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>

								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No rating to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$data->count()}} of {{ $data->total() }} rating(s).
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

<script>
jQuery(document).ready(function(){
	jQuery("#myPopover").popover({
        html: true
    });
});

</script>
@stop