@extends('layouts.app')

@section('content')

	<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Blogs List</h1>
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
				<div class="card-body">

					@foreach($blogs as $key => $row)
						<div class="card">
							<p><strong><h4>{{$row->title}}</h4></strong></p>
							<p>Publish Date : {{date('d M,Y - g:i A', strtotime($row->publish_date))}}</p>
							<p>{!! html_entity_decode($row->content)!!}</p>
						</div>
					@endforeach						
						@if ($blogs->count() == 0)
						
							<p colspan="10" class="text-center text-danger">No blog to display.</p>
					
						@endif					
						{{ $blogs->appends(request()->except('page'))->links() }}
						<p>
							Displaying {{$blogs->count()}} of {{ $blogs->total() }} blog(s).
						</p>
					
				</div>
			</div>
        </div>
	</div>
</div>
	<!-- container-fluid -->
	@endsection
