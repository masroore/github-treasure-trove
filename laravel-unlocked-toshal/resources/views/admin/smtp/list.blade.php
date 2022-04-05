@extends('admin.layouts.cmlayout')
@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">SMTP Information</h1>
	</div>
	<div class="flash-message">
	@if(session()->has('status'))
	    @if(session()->get('status') == 'success')
		<div class="alert alert-success  alert-dismissible">
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
							<input type="text" class="form-control" data-model="User" data-searchcoulnm="first_name,last_name,email" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
						</div>
						<button type="submit" class="btn btn-primary ml-10">Search</button>
					</form>
					<div class="buttons-right">
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover dt-responsive nowrap">
							<thead>
								<tr>
									<th>S.No</th>
									<th>@sortablelink('host', 'Host Name')</th>
									<th>Port</th>
									<th>@sortablelink('username', 'Username')</th>
									<th>@sortablelink('from_name', 'From')</th>
									<th>@sortablelink('from_email', 'Email')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
							    @foreach($data as $key => $row)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{ $row->host ? $row->host : 'N/A' }}</td>
									<td>{{ $row->port ? $row->port : 'N/A' }}</td>
									<td>{{ $row->username ? $row->username : 'N/A' }}</td>
									<td>{{ $row->from_name ? $row->from_name : 'N/A' }}</td>
									<td>{{ $row->from_email ? $row->from_email : 'N/A' }}</td>
									<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A' }}</td>
									<td>
									    <a class="anchorLess">
									        <a title="Click to Edit" href="{{route('smtp.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true" ></i></a>
										</a>
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="9" class="text-center text-danger">No smtp to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}
						<p>Displaying {{$data->count()}} of {{ $data->total() }} smtp(s).</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
@endsection