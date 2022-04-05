@extends('admin.layouts.cmlayout')

@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Email Template List</h1>
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
							<input type="text" class="form-control" data-model="AutoResponder" value="{{$keyword}}" data-searchcoulnm="template_name" id="search_keyword" name="search_keyword" placeholder="What are you looking for?">
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
									<th>@sortablelink('template_name', 'Template Name')</th>
									<th>@sortablelink('subject', 'Subject')</th>
									<th>@sortablelink('created_at', 'Created Date')</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
							@php $i = 1 @endphp
								@foreach($data as $key => $row)
								<tr>
									<td>{{$i++}}</td>
									<td>{{ $row->template_name ? $row->template_name : 'N/A' }}</td>
                                    <td>{{$row->template ? html_entity_decode($row->subject) : 'N/A'}}</td>
									<td>{{$row->created_at ? date('d F Y', strtotime($row->created_at)): 'N/A'}}</td>
									<td>
									<a class="anchorLess">
									   <a title="Click to Edit" href="{{route('autoresponder.edit',[$row->id])}}" class="anchorLess"><i class="fas fa-edit info" aria-hidden="true" ></i></a>
									</a>
									</td>
								</tr>
								@endforeach
								@if ($data->count() == 0)
								<tr>
									<td colspan="9" class="text-center text-dabger">No email template to display.</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{ $data->appends(request()->except('page'))->links() }}

						<p>
							Displaying {{$data->count()}} of {{ $data->total() }} email template(s).
						</p>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- /.container-fluid -->
@endsection