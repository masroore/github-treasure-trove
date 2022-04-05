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
		@if(session()->get('status') == 'success')
			<div class="alert alert-success  alert-dismissible">
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
						Create Email Template
						<a href="{{route('autoresponder.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('autoresponder.create')}}" method="post" class="user" id="editor_form" enctype="multipart/form-data">@csrf
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Subject<span class="required">*</span>
									</label>
									<input type="text" name="subject" id="subject" value="{{old('subject')}}" class="form-control form-control-user" />
									@if ($errors->has('subject'))
									<span class="text-danger">{{ $errors->first('subject') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Template Name<span class="required">*</span>
									</label>
									<input type="text" name="template_name" id="template_name" value="{{old('template_name')}}" class="form-control form-control-user" readonly/>
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
									<textarea name="template" id="template" class="form-control form-control-user">{{old('template')}}</textarea>
									<p>Use these tag for name: @{{$name}}, Email: @{{$email}}, Token link: @{{$token}}, etc.</p>
									@if ($errors->has('template'))
									<span class="text-danger">{{ $errors->first('template') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Status<span class="required">*</span>
									</label>
									<div class="input-group">
										<div id="radioBtn" class="btn-group">	<a class="btn btn-success btn-sm {{ old('status') ? old('status') == '1' ? 'active' : 'notActive' : 'active'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status') == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="1">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="save-editor-btn" name="action" value="saveadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit" id="save-editor-btn" name="action" value="save" class="btn btn-primary">Save</button>	<a href="{{route('autoresponder.list')}}" class="btn btn-light">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
	<!-- container-fluid -->
	@endsection
	@section('scripts')
	<script src="https://cdn.tiny.cloud/1/g2adjiwgk9zbu2xzir736ppgxzuciishwhkpnplf46rni4g8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>
		$( document ).ready(function() {
			$("form[id='editor_form']").validate({
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
		$("form button[type=submit]").click(function(e) {
			tinymce.triggerSave();
		});
	</script>
	@stop