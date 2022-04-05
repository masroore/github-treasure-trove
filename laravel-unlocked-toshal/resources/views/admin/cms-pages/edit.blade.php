@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Update CMS Page</h1>
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
					<form action="{{route('cms-pages.update')}}" method="post" class="user" id="edit_page_form" enctype="multipart/form-data">
					    @csrf
						<input type="hidden" name="edit_record_id" value="{{$record->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Page Name<span class="required">*</span>
									</label>
									<input type="text" name="name" id="name" value="{{old('name', $record->name)}}" class="form-control form-control-user" />
									@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Short Description<span class="required">*</span>
									</label>
									<input type="text" name="short_description" id="short_description" class="form-control form-control-user"  value="{{old('short_description', $record->short_description)}}"/>
									@if ($errors->has('short_description'))
									<span class="text-danger">{{ $errors->first('short_description') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-md-6 col-12">
								<div class="form-group">
									<label>Description<span class="required">*</span>
									</label>
									<textarea name="description" rows="5" id="description" class="form-control form-control-user editor">{{old('description', $record->description)}}</textarea>
									@if ($errors->has('description'))
									<span class="text-danger">{{ $errors->first('description') }}</span>
									@endif
								</div>
							</div>
						</div>

						<!--@if($record->slug != 'home')
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Slug<span class="required">*</span>
									</label>
									<input type="text" name="slug" id="slug" value="{{old('slug', $record->slug)}}" class="form-control form-control-user" />
									@if ($errors->has('slug'))
									<span class="text-danger">{{ $errors->first('slug') }}</span>
									@endif
								</div>
							</div>
						</div>
						@else
							<input type="hidden" name="slug" value="{{$record->slug}}"/>
						@endif-->
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Title<span class="required">*</span>
									</label>
									<input type="text" name="meta_title" id="meta_title" value="{{old('meta_title', $record->meta_title)}}" class="form-control form-control-user" />
									@if ($errors->has('meta_title'))
									<span class="text-danger">{{ $errors->first('meta_title') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Keyword<span class="required">*</span>
									</label>
									<input type="text" name="meta_keyword" id="meta_keyword" value="{{old('meta_keyword', $record->meta_keyword)}}" class="form-control form-control-user" />
									@if ($errors->has('meta_keyword'))
									<span class="text-danger">{{ $errors->first('meta_keyword') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-md-6 col-12">
								<div class="form-group">
									<label>Meta Content<span class="required">*</span>
									</label>
									<input type="text" name="meta_content" id="meta_content" value="{{old('meta_content', $record->meta_content)}}" class="form-control form-control-user" />
									@if ($errors->has('meta_content'))
									<span class="text-danger">{{ $errors->first('meta_content') }}</span>
									@endif
								</div>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label for="document" class="form-label">Upload Image</label>
									<input type="hidden" value="{{$record->image}}" name="olddocument">
									<input class="form-control form-control-user" id="document" name="document" type="file" accept="image/*"/>
									@if ($errors->has('document'))
									<span class="text-danger">{{ $errors->first('document') }}</span>
									@endif
								</div>
							</div>
						</div> -->

						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="edit-genre-btn" class="btn btn-primary">Update</button>	<a href="{{route('cms-pages.list')}}" class="btn btn-light">Cancel</a>
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
			$("form[id='edit_page_form']").validate({
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

		$("form button[type=submit]").click(function(e) {
				tinymce.triggerSave();
		  	});

	</script>
	@stop