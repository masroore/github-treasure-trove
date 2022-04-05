@inject('GetCommon', 'App\Traits\GetCommon')
@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Testimonial List</h1>
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
						Update Testimonial
						<a href="{{route('testimonial.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('testimonial.update')}}" method="post" class="user" id="editor_form" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="edit_record_id" value="{{$record->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Name<span class="required">*</span></label>
									<input name="name" id="name" rows="4" class="form-control form-control-user" value="{{old('name', $record->name)}}">
									@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>User Designation<span class="required">*</span></label>
									<input name="user_post" id="user_post" rows="4" class="form-control form-control-user" value="{{old('user_post', $record->user_post)}}">
									@if ($errors->has('user_post'))
									<span class="text-danger">{{ $errors->first('user_post') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-md-6 col-12">
								<div class="form-group">
									<label>Message<span class="required">*</span></label>
									<textarea name="message" id="message" rows="5" class="form-control form-control-user" required>{{old('message', $record->message)}}</textarea>
									@if ($errors->has('message'))
									<span class="text-danger">{{ $errors->first('message') }}</span>
									@endif
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" id="image" class="form-control form-control-user"  accept="image/*"/>
                                    <input type="hidden" name="oldimage" id="oldimage" class="form-control form-control-user" value="{{$record->image}}" />
                                    @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 ">
                                <div class="form-group">
                                    
                                    @if($record->image)
										<p style="margin:0"></p>
										@php
											$type = explode(".",$record->image)[1];
											$image = $GetCommon->createThumbnail(public_path('assets/testimonial/images/'.$record->image), $type, 175, 75);
										@endphp
										@if($image)
											<img class="img-profile mt30" src="{{ 'data:image/' .$type. ';base64,' .base64_encode($image ) }}" alt="image">
										@else
											<img class="img-profile mt30" height="100" width="100" src="{{asset('backend/images/not-available.png')}}" alt="image not available">
										@endif
                                    @else
                                    <img class="img-profile mt30" height="100" width="100" src="{{asset('backend/images/not-available.png')}}" alt="image not available">
                                    @endif
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" id="location" class="form-control form-control-user" value="{{old('location', $record->location)}}"/>
                                    @if ($errors->has('location'))
                                    <span class="text-danger">{{ $errors->first('location') }}</span>
                                    @endif
                                </div>
                            </div>
						</div>

						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Status<span class="required">*</span></label>
									<div class="input-group">
										<div id="radioBtn" class="btn-group">
											<a class="btn btn-success btn-sm {{ old('status', $record->status) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status', $record->status) == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="{{ old('status', $record->status) == '1' ? '1' : '0'}}">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="save-editor-btn" name="action" value="savereport" class="btn btn-primary">Update</button>
								<a href="{{route('testimonial.list')}}" class="btn btn-light">Cancel</a>
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
    			user_post: {
    				required: true,
                    maxlength: 200,
    			},
    			message: {
    				required: true,
                    maxlength: 2500,
    			},
                image: {
                    extension: "jpg|png|jpeg"
                },
    		},
    		// Specify validation error messages
    		messages: {
    			name: {
    				required: 'Name field is required',
                    maxlength: 'Name should be less than 200 characters ',
    			},
    			user_post: {
    				required: 'User Designation field is required',
                    maxlength: 'User Designation should be less than 200 characters ',
    			},
    			message: {
    				required: 'Message field is required',
                    maxlength: 'Message should be less than 2500 characters ',
    			},
                image: {
                    extension: "Choose the image jpg,jpeg,or png format Only"
                },
    		},
    		submitHandler: function(form) {
    			form.submit();
    		}
    	});
    });
</script>
@stop