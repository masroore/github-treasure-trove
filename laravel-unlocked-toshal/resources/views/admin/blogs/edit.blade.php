@inject('GetCommon', 'App\Traits\GetCommon')
@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Blog List</h1>
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
						Update Blog Detail
						<a href="{{route('blogs.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('blog.update')}}" method="post" class="user" id="update_blog_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="edit_record_id" value="{{$blogDetail->id}}">
						<div class="row">
						<div class="col-lg-6 col-md-6 col-12">
							<div class="form-group">
									<label>Title<span class="required">*</span>
									</label>
                                   <input type="text" name="title" id="title" value="{{old('title',$blogDetail->title)}}" class="form-control form-control-user" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
								</div>
							</div>
                        </div>
						<div class="row">
						&nbsp;&nbsp;
								<div class="form-check form-group">
									<input class="form-check-input" type="radio" value='1' name="scheduleOn" id="flexRadioDefault1">
									<label class="form-check-label" for="flexRadioDefault1">
										Publish Now &nbsp;
									</label>
								</div>
								<div class="form-check form-group">
									<input class="form-check-input" value='2' type="radio" name="scheduleOn" id="flexRadioDefault2" checked>
									<label class="form-check-label" for="flexRadioDefault2">
										Publish On
									</label>
								</div>
							</div>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12" id="displayDiv">
								<div class="form-group">
									<label>Publish Date<span class="required"></span>
									</label>
                                   <input type="text" name="publish_date" id="publish_date" value="{{old('publish_date',$blogDetail->publish_date != null ?date('Y/m/d H:i', strtotime($blogDetail->publish_date)) : '')}}" class="form-control form-control-user datetimepicker"  autocomplete="off"/>
                                    @if ($errors->has('publish_date'))
                                        <span class="text-danger">{{ $errors->first('publish_date') }}</span>
                                    @endif
								</div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="form-group">
									<label>Content<span class="required">*</span>
									</label>
									<textarea name="content" id="content"  class="form-control form-control-user editor" >{{old('content', $blogDetail->content)}}</textarea>
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
									<input type="file" name="cover_photo" id="cover_photo" placeholder="Cover Photo" value="{{old('cover_photo',$blogDetail->cover_photo)}}"  class="form-control form-control-user"/>
									<input type="hidden" name="cover_photo_old"value="{{ $blogDetail->cover_photo}}" />
									@if ($errors->has('cover_photo'))
										<span class="text-danger">{{ $errors->first('cover_photo') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 category-img">
								<div class="form-group mt-4 pt-2">
								@if($blogDetail->cover_photo != "")
									@php
										$type = explode(".",$blogDetail->cover_photo)[1];
										$image = $GetCommon->createThumbnail(public_path('assets/blog/images/'.$blogDetail->cover_photo), $type, 175, 75);
									@endphp
										@if($image)

											<img class="img-profile mt30" style="padding-right:10px; padding-bottom:10px" src="{{ 'data:image/' .$type. ';base64,' .base64_encode($image) }}" width="100px" alt="Blog Image">

										@endif
								@else
									<img class="img-profile mt30" src="{{asset('backend/images/not-available.png')}}" alt="Image not available">
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
                                            <a class="btn btn-success btn-sm {{ old('status',$blogDetail->status) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
                                            <a class="btn btn-danger btn-sm {{ old('status',$blogDetail->status) == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
                                        </div>
                                        <input type="hidden" name="status" id="status" value="{{ old('status',$blogDetail->status) == '1' ? '1' : '0'}}">
                                    </div>
                                    @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="edit-genre-btn"  class="btn btn-primary">Update</button>
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

		jQuery("form[id='update_blog_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					title: {
						required: true,
					},
					content: {
						required: true,
					},
					cover_photo:{
						extension: "jpg|jpeg|png"
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
						extension: 'Choose the image jpg,jpeg or png format Only',
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
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