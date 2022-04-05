@extends('admin.layouts.cmlayout')
@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">CMS Pages List</h1>
	</div>
	<div class="flash-message">
	@if(session()->has('status'))
	    @if(session()->get('status') == 'success')
		<div class="alert alert-success  alert-dismissible">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ session()->get('message') }}
		</div>
		@endif

		@if(session()->get('status') == 'error')
		<div class="alert alert-danger  alert-dismissible">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ session()->get('message') }}
		</div>
		@endif
	@endif
	</div>
	<!-- end .flash-message -->
	<div class="row">
		<div class="col-xl-12 col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<form class="form-inline float-left" id="search-form">
						<div class="form-group">
							<input type="text" class="form-control" value="{{$keyword}}" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<!-- <div class="buttons-right">	<a class="m-0 font-weight-bold btn-department-add pull-right hover-white" href="{{route('cms-pages.add')}}">Add CMS Pages</a>
					</div> -->
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap" id="cms-data">
							<thead>
								<tr>
									<th>S.No</th>
									<th>@sortablelink('name', 'Page Name')</th>
									<th width="600px">@sortablelink('short_description', 'Short Description')</th>
									<!--<th>@sortablelink('slug', 'Slug')</th>-->
									<th>@sortablelink('meta_title', 'Meta Title')</th>
									<!-- <th>@sortablelink('status', 'Status')</th> -->
									<th>@sortablelink('created_at', 'Created Date')</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
							    @foreach($data as $key => $row)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{ $row->name ? $row->name : 'N/A' }}</td>
									<td><?php $string = strip_tags($row->short_description);?>{{str_replace("&nbsp;","",$string)}}</td>
									<!--<td>{{ $row->slug ? ($row->slug == 'home' || 'about') ? 'N/A' : $row->slug : 'N/A' }}</td>-->
									<td>{{ $row->meta_title ? $row->meta_title : 'N/A' }}</td>
									<!-- <td>
									    @if($row->status == 0)
										<a title="Click to Enable" href="{{route('cms-pages.status', ['id' => $row->id, 'status' => 1])}}" class="tableLink"><i class="fas fa-toggle-off danger"></i></a>
										@else
										<a title="Click to Disable" href="{{route('cms-pages.status', ['id' => $row->id, 'status' => 0])}}" class="tableLink"><i class="fas fa-toggle-on success"></i></a>
										@endif
									</td> -->
									<td>{{$row->created_at ? date('d F Y', strtotime($row->created_at)): 'N/A'}}</td>
									<td>
									    <a class="anchorLess">
											<!-- <a title="Click to View" href="{{route('cms-pages.show',[$row->id])}}" class="anchorLess"><i class="fas fa-eye info" aria-hidden="true" ></i></a> -->
									        <a title="Click to Edit" href="{{route('cms-pages.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true" ></i></a>
										</a>
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="7" class="text-center text-danger">No Page to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						<div class="d-flex" style="padding:30px">
                        {!! $data->links() !!}
                        </div>
						<p>Displaying {{$data->count()}} of {{ $data->total() }} CMS Page(s).</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
@endsection
