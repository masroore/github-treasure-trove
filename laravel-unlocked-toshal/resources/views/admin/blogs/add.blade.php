@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Blogs List</h1>
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
						Add Blog Detail
						<a href="{{route('blogs.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('blog.create')}}" method="post" class="user" id="add_blog_form" enctype="multipart/form-data">@csrf
						<!-- <input type="hidden" name="edit_record_id" value=""> -->
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="form-group">
									<label>Title<span class="required">*</span>
									</label>
                                   <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control form-control-user" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
								</div>
							</div>
                        </div>
							<div class="row">
						&nbsp;&nbsp;
								<div class="form-check form-group">
									<input class="form-check-input" type="radio" value='1' name="scheduleOn" id="flexRadioDefault1"checked>
									<label class="form-check-label" for="flexRadioDefault1">
										Publish Now &nbsp;
									</label>
								</div>
								<div class="form-check form-group">
									<input class="form-check-input" value='2' type="radio" name="scheduleOn" id="flexRadioDefault2" >
									<label class="form-check-label" for="flexRadioDefault2">
										Publish On
									</label>
								</div>
							</div>
							<div class="row ">
							<div class="col-lg-6 col-md-6 col-12" id="displayDiv" style="display:none">
								<div class="form-group">
									<label><span class="required"></span>
									</label>
                                   <input type="text" name="publish_date" id="publish_date" value="{{old('publish_date')}}" class="form-control form-control-user datetimepicker" autocomplete="off"/>
                                    @if ($errors->has('publish_date'))
                                        <span class="text-danger">{{ $errors->first('publish_date') }}</span>
                                    @endif
								</div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-lg-6 col-md-6 col-12 ">
								<!-- main-contentt -->
								<div class="form-group">
									<label>Content<span class="required">*</span></label>
									<textarea name="content" id="content" class="form-control form-control-user editor" >{{old('content')}}</textarea>
									@if ($errors->has('content'))
										<span class="text-danger">{{ $errors->first('content') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="form-group">
									<label for="document-0" class="document-label">Cover Photo</label>
									<input type="file" name="cover_photo" id="cover_photo"  value="{{old('cover_photo')}}"  class="form-control form-control-user"/>
									@if ($errors->has('cover_photo'))
										<span class="text-danger">{{ $errors->first('cover_photo') }}</span>
									@endif
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Status<span class="required">*</span></label>
                                    <div class="input-group">
                                        <div id="radioBtn" class="btn-group">
                                            <a class="btn btn-success btn-sm {{ old('status') ? old('status') == '1' ? 'active' : 'notActive' : 'active'}}" data-toggle="status" data-title="1">Enabled</a>
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
                                <button type="submit" name="action" value="saveadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit"  name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
								<a href="{{route('blogs.list')}}" class="btn btn-light">Cancel</a>
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
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/g2adjiwgk9zbu2xzir736ppgxzuciishwhkpnplf46rni4g8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>
	jQuery( document ).ready(function() {
		tinymce.init({
			selector: 'textarea.editor',
			plugins: 'code',
			toolbar: 'code',
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
		});

			$("form[id='add_blog_form']").validate({
				
				// Specify validation rules
				errorPlacement: function(error, element) {
					if (element.is("textarea"))
						error.insertAfter(element.next());
					else
							error.insertAfter(element);
					},
				
				ignore: '',
				rules: {
					title: {
						required: true,
					},
					content: {
						required: true,
					},
					cover_photo: {
						extension: "jpg|jpeg|png",
					}
				},
				// Specify validation error messages
				messages: {
					title: {
						required: 'Title field is required',
					},
					content: {
						required: 'Content field is required',
					},
					cover_photo: {
						extension: 'Choose the image jpg,jpeg,or png format Only',
					}
				},
				submitHandler: function(form) {
					form.submit();
				},
					
			});
		});
		jQuery("form button[type=submit]").click(function(e) {
				tinymce.triggerSave();
		  	});

		jQuery('.datetimepicker').datetimepicker({
			minDate : 0,
			// mask:true
		});

		 jQuery("input[name='scheduleOn']").click(function() {
        var publishVal = jQuery(this).val();
			if(publishVal == '2'){
 				jQuery("#displayDiv").show();
			}else{
				jQuery("#displayDiv").hide();
			}
    	});

    </script>
	@stop