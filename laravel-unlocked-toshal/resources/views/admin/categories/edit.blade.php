@inject('GetCommon', 'App\Traits\GetCommon')
@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Category List</h1>
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
						Update Category Detail
						<a href="{{route('categories.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('category.update')}}" method="post" class="user" id="update_category_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="edit_record_id" value="{{$categoryDetail->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Parent<span class="required"></span>
									</label>
                                    <select class="form-control form-control-user" name="parent_id" id="parent_id">
                                        <option value="">Parent</option>
                                        @foreach($pCategories as $pCategory)
                                            <option {{$categoryDetail->parent_id == $pCategory->id ? "selected" : "" }} value="{{$pCategory->id}}">{{$pCategory->name}}</option>
                                        @endforeach
									</select>
                                    @if ($errors->has('parent_id'))
                                        <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                                    @endif
								</div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Category<span class="required">*</span>
									</label>
									<input type="text" name="name" id="name" value="{{old('name',$categoryDetail->name)}}" class="form-control form-control-user" />
									@if ($errors->has('name'))
										<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label for="document-0" class="document-label">Category Image<span class="required"></span></label>
									<input type="file" name="image" id="image" placeholder="Category Image" value="{{old('image',$categoryDetail->image)}}"  class="form-control form-control-user"/>
									<input type="hidden" name="category_old_image"value="{{ $categoryDetail->image}}" />
									@if ($errors->has('image'))
										<span class="text-danger">{{ $errors->first('image') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12 category-img">
								<div class="form-group mt-4 pt-2">
								@if($categoryDetail->image != "")
									@php
										$type = explode(".",$categoryDetail->image)[1];
										$image = $GetCommon->createThumbnail(public_path('assets/category/images/'.$categoryDetail->image), $type, 175, 75);
									@endphp
										@if($image)

											<img class="img-profile mt30" style="padding-right:10px; padding-bottom:10px" src="{{ 'data:image/' .$type. ';base64,' .base64_encode($image) }}" width="100px" alt="Category Image">

										@endif
								@else
									<img class="img-profile mt30" src="{{asset('backend/images/not-available.png')}}" alt="Image not available">
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
                                            <a class="btn btn-success btn-sm {{ old('status',$categoryDetail->status) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
                                            <a class="btn btn-danger btn-sm {{ old('status',$categoryDetail->status) == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
                                        </div>
                                        <input type="hidden" name="status" id="status" value="{{ old('status',$categoryDetail->status) == '1' ? '1' : '0'}}">
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
								<a href="{{route('categories.list')}}" class="btn btn-light">Cancel</a>
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

	jQuery( document ).ready(function() {
			$("form[id='update_category_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					name: {
						required: true,
					},
					image:{
						extension: "jpg|jpeg|png"
					},
				},
				// Specify validation error messages
				messages: {
					name: {
						required: 'Category name is required',
					},
					image: {
						extension: 'Choose the image jpg,jpeg or png format Only',
					},
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
    </script>
	@stop