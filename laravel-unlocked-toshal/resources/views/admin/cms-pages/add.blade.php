@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="row page-title  no-display">
		<div class="col-md-12">
			<h4 class="mb-1 mt-0">Create CMS Page</h4>
		</div>
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
					<form action="{{route('cms-pages.create')}}" method="post" class="user" id="editor_form" enctype="multipart/form-data">
					    @csrf
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Page Name<span class="required">*</span>
									</label>
									<input type="text" name="name" id="name" value="{{old('name')}}" class="form-control form-control-user" />
									@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Short Description<span class="required">*</span>
									</label>
									<textarea name="short_description" id="short_description" class="form-control form-control-user editor">{{old('short_description')}}</textarea>
									@if ($errors->has('short_description'))
									<span class="text-danger">{{ $errors->first('short_description') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Description<span class="required">*</span>
									</label>
									<textarea name="description" id="description" class="form-control form-control-user editor">{{old('description')}}</textarea>
									@if ($errors->has('description'))
									<span class="text-danger">{{ $errors->first('description') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Slug<span class="required">*</span>
									</label>
									<input type="text" name="slug" id="slug" value="{{old('slug')}}" class="form-control form-control-user" />
									@if ($errors->has('slug'))
									<span class="text-danger">{{ $errors->first('slug') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Title<span class="required">*</span>
									</label>
									<input type="text" name="meta_title" id="meta_title" value="{{old('meta_title')}}" class="form-control form-control-user" />
									@if ($errors->has('meta_title'))
									<span class="text-danger">{{ $errors->first('meta_title') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Keyword<span class="required">*</span>
									</label>
									<input type="text" name="meta_keyword" id="meta_keyword" value="{{old('meta_keyword')}}" class="form-control form-control-user" />
									@if ($errors->has('meta_keyword'))
									<span class="text-danger">{{ $errors->first('meta_keyword') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Content<span class="required">*</span>
									</label>
									<textarea name="meta_content" id="meta_content" class="form-control form-control-user">{{old('meta_content')}}</textarea>
									@if ($errors->has('meta_content'))
									<span class="text-danger">{{ $errors->first('meta_content') }}</span>
									@endif
								</div>
							</div>
						</div>
							<!--<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Status<span class="required">*</span>
									</label>
									<div class="input-group">
										<div id="radioBtn" class="btn-group">
										    <a class="btn btn-success btn-sm active {{ old('status', 1) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status') == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="1">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
									</div>
							</div>
						</div>-->
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="save-editor-btn" name="action" value="saveandadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit" id="save-editor-btn" name="save" class="btn btn-primary">Save</button>	<a href="{{route('cms-pages.list')}}" class="btn btn-light">Cancel</a>
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
			
			$("form[id='editor_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					name: {
						required: true,
		                maxlength: 200,
					},
					slug: {
						required: true,
						minlength: 3,
		                maxlength: 200,
					},
					short_description: {
						required: true,
		                maxlength: 200,
					},
					description: {
						required: true
					},
					meta_title: {
						required: true,
						maxlength: 200,
					},
					meta_keyword: {
						required: true,
						maxlength: 200,
					},
					meta_content: {
						required: true,
						maxlength: 200,
					}
				},
				// Specify validation error messages
				messages: {
					name: {
						required: 'Page name is required',
		                maxlength: 'Page name should be less than 200 characters ',
					},
					slug: {
						required: 'Page slug is required',
		                minlength: 'Page slug should be minimum three digits.',
		                maxlength: 'Page slug should be less than 200 characters ',
					},
					short_description: {
						required: 'Short description is required',
		                maxlength: 'Page short description should be less than 200 characters ',
					},
					description: {
						required: 'Page description is required'
					},
					meta_title: {
						required: 'Meta title is required',
		                maxlength: 'Meta title should be less than 200 characters ',
					},
					meta_keyword: {
						required: 'Meta keyword is required',
		                maxlength: 'Meta keyword should be less than 200 characters ',
					},
					meta_content: {
						required: 'Meta Content is required',
		                maxlength: 'Meta Content should be less than 200 characters ',
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