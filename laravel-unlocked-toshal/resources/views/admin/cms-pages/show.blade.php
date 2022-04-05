@extends('admin.layouts.cmlayout')
@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="row">
		<div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-left: 10px;">
    <h1 class="h3 mb-0 text-gray-800">Showing CMS Page Details</h1></div>
		<div class="d-sm-flex align-items-center justify-content-between btn-view mb-4">
			<a href="{{route('cms-pages.edit',[$record->id])}}" class="btn btn-info"> <span class="glyphicon glyphicon-pencil"></span> &nbsp;Edit
			</a>
			<a href="{{route('cms-pages.list')}}" class="btn btn-warning"> <span class="glyphicon glyphicon-list"></span> &nbsp;Return to list
			</a>
		</div>    
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
	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body pt-2 pb-3 manageClinicSection">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<strong>Page Name:</strong><br>
									{{ $record->name }}
									<hr>
								</div>
							</div>
							</div>
						<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
									<strong>Short Description:</strong><br>
									<p align="justify"><?php $string = strip_tags($record->short_description);?>{{str_replace("&nbsp;","",$string)}}</p>
							</div>
						</div>
							<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
									<strong>Page Description:</strong><br>
									<p align="justify"><?php $string = strip_tags($record->description);?>{{str_replace("&nbsp;","",$string)}}</p>
							</div>
						</div>
						<!--<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<strong>Page Slug:</strong><br>
									{{ $record->slug }}
								<hr>
								</div>
							</div>
						</div>-->
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<strong>Meta Title:</strong><br>
									{{ $record->meta_title }}
								<hr>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<strong>Meta Keyword:</strong><br>
									{{ $record->meta_keyword }}
								<hr>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
									<strong>Meta Content:</strong><br>
									<p align="justify"><?php $string = strip_tags($record->meta_content);?>{{str_replace("&nbsp;","",$string)}}</p>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<strong>Created At:</strong><br>
									{{ date('d,F,Y',strtotime($record->created_at)) }} 
								<hr>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
</div>
<!-- /.container-fluid -->
@endsection
