@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Testimonials List</h1>
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
							<input type="text" class="form-control" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
						<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('testimonial.add')}}">Add New Testimonial <i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>
									<th>@sortablelink('title', 'Username')</th>
									<th>@sortablelink('location', 'Location')</th>
									<th>@sortablelink('user_post', 'Designation')</th>
									<th>Message</th>
									<th>@sortablelink('status', 'Status')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($data as $key => $row)
								<tr>
									<td>{{$i++}}</td>
									<td>{{ $row->name ? $row->name : 'N/A' }}</td>
									<td>{{ $row->location ? $row->location : 'N/A' }}</td>
									<td>{{ $row->user_post ? $row->user_post : 'N/A' }}</td>
									<td>{{ $row->message ? (strlen($row->message) > 50) ? substr($row->message, 0, 50)."..." : $row->message : 'N/A' }}</td>
									<td>
									@if($row->status == 0)
										<a title="Click to Enable" href="{{route('testimonial.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
									@elseif($row->status == 2)
										<a title="Click to Enable" href="{{route('testimonial.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
									@else
										<a title="Click to Disable" href="{{route('testimonial.status', ['id' => $row->id, 'status' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
									@endif
									</td>
									<td>{{$row->created_at ? date('d F Y', strtotime($row->created_at)): 'N/A'}}</td>
									<td>
									<a class="anchorLess">
									   <a title="Click to Edit" href="{{route('testimonial.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true" ></i></a>
									   <a title="Click to Delete" href="{{route('testimonial.delete',[$row->id])}}" class="anchorLess delete-confirm"><i class="fas fa-trash danger" aria-hidden="true" ></i></a>
									</a>
									
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="9" class="text-center text-danger">No testimonial to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}

						<p>
							Displaying {{$data->count()}} of {{ $data->total() }} testimonial(s).
						</p>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- /.container-fluid -->
@endsection