@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Categories List</h1>
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
							<input type="text" class="form-control" value="{{$keyword}}" data-model="User" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
						<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('category.add')}}">Add Category <i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>
									<th>@sortablelink('parent_id', 'Parent')</th>
									<th>@sortablelink('name', 'Name')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<!-- <th>@sortablelink('is_deleted', 'Deleted')</th> -->
									<th>@sortablelink('status', "Status")</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($data as $key => $row)
                                    <tr>
										<td>{{$i++}}</td>
                                        <td>{{$row->parent != null ? $row->parent->name : "N/A"}}</td>
                                        <td>{{$row->name }}</td>
										<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>
                                        <td>
										@if($row->status == 0)
											<a title="Click to Enable" href="{{route('category.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
										@else
											<a title="Click to Disable" href="{{route('category.status', ['id' => $row->id, 'status' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
										@endif
										</td>
										<td>
											<a class="anchorLess">
												<a title="Click to Edit" href="{{route('category.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit primary" aria-hidden="true" ></i></a>
												@if($row->is_deleted == 1)
													<a title="Click to Recover" href="{{route('category.delete',['id' => $row->id, 'is_deleted' => 0])}}" class="anchorLess"><i class="fas fa-trash-restore info" aria-hidden="true" ></i></a>
												@else
												<a title="Click to Delete" href="{{route('category.delete',['id' => $row->id, 'is_deleted' => 1])}}" class="tableLink delete-confirm"><i class="fas fa-trash danger"></i></a>
												@endif
											</a>
										</td>
                                    </tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="10" class="text-center text-danger">No categories to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}
						<p>
						Displaying {{$data->count()}} of {{ $data->total() }} category(s).
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
