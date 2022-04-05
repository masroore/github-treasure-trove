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
						Add Category Detail
						<a href="{{route('categories.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('category.create')}}" method="post" class="user" id="add_category_form" enctype="multipart/form-data">@csrf
						<!-- <input type="hidden" name="edit_record_id" value=""> -->
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Parent<span class="required"></span>
									</label>
                                    <select class="form-control form-control-user" name="parent_id" id="parent_id">
                                        <option value="">Parent</option>
                                        @foreach($pCategories as $pCategory)
                                            <option value="{{$pCategory->id}}">{{$pCategory->name}}</option>
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
									<label for="document-0" class="document-label">Category Image<span class="required">*</span></label>
									<input type="file" name="image" id="image"  value="{{old('image')}}"  class="form-control form-control-user"/>
									@if ($errors->has('image'))
										<span class="text-danger">{{ $errors->first('image') }}</span>
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

			$("form[id='add_category_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					name: {
						required: true,
					},
					image: {
						required: true,
						extension: "jpg|jpeg|png",
					}
				},
				// Specify validation error messages
				messages: {
					name: {
						required: 'Category name is required',
					},
					image: {
						required: 'Category image is required',
						extension: 'Choose the image jpg,jpeg,or png format Only',
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
    </script>
	@stop