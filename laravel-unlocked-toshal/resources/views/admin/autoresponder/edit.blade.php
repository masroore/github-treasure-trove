@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Email Template List</h1>
	</div>
	<div class="flash-message">
	@if(session()->has('status'))
	    @if(session()->get('status') == 'error')
		    <div class="alert alert-danger  alert-dismissible">
			    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			    {{ session()->get('message') }}
			</div>
		@endif
	@endif
	</div>
	<!-- end .flash-message -->
	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body pt-2 pb-3 manageClinicSection">
					<h5 class="mt-3 mb-4">
						Update Email Template
						<a href="{{route('autoresponder.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('autoresponder.update')}}" method="post" class="user" id="edit_autoresponder_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="edit_record_id" value="{{$record->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Subject<span class="required">*</span>
									</label>
									<input type="text" name="subject" id="subject" value="{{old('subject', $record->subject)}}" class="form-control form-control-user" />
									@if ($errors->has('subject'))
									<span class="text-danger">{{ $errors->first('subject') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Template Name<span class="required">*</span>
									</label>
									<input type="text" name="template_name" id="template_name" value="{{old('template_name', $record->template_name)}}" class="form-control form-control-user" readonly/>
									@if ($errors->has('template_name'))
									<span class="text-danger">{{ $errors->first('template_name') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-md-6 col-12">
								<div class="form-group">
									<label>Template<span class="required">*</span>
									</label>
									<textarea name="template" id="template" class="form-control form-control-user editor">{{old('template', $record->template)}}</textarea>
									<p>Use these tag for name: @{{$name}}, Email: @{{$email}}, Date: @{{$date}}.</p>
									@if ($errors->has('template'))
									<span class="text-danger">{{ $errors->first('template') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="edit-genre-btn" class="btn btn-primary">Update</button>
								<a href="{{route('autoresponder.list')}}" class="btn btn-light">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
	</div>
	<!-- container-fluid -->
	@endsection
	@section('scripts')
	<script>
		$( document ).ready(function() {
			$("form[id='edit_autoresponder_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					subject: {
						required: true,
		                maxlength: 200,
					},
					template_name: {
						required: true,
		                maxlength: 200,
					},
					template: {
						required: true,
					}
				},
				// Specify validation error messages
				messages: {
					subject: {
						required: 'Subject field is required',
		                maxlength: 'Subject should be less than 200 characters '
					},
					template_name: {
						required: 'Template name is required',
		                maxlength: 'Template name should be less than 200 characters '
					},
					template: {
						required: 'Template field is required',
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
			$("form input[type=submit]").click(function(e) {
				tinymce.triggerSave();
		  	});
	</script>
	@stop