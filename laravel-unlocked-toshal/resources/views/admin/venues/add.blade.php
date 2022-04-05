@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Venue List</h1>
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
						Add Venue Detail
						<a href="{{route('venues.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('venue.create')}}" method="post" class="user" id="add_venue_form" enctype="multipart/form-data">@csrf

						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Name<span class="required">*</span>
									</label>
									<input type="text" name="name" id="name" value="{{old('name')}}" class="form-control form-control-user" />
									@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Owner<span class="required">*</span>
									</label>
									<select class="form-control form-control-user" name="user_id" id="user_id">
										<option value="">Select Owner</option>
										@foreach($owners as $owner)
										<option value="{{$owner->id}}">{{$owner->first_name." ".$owner->last_name}}</option>
										@endforeach
									</select>
									@if ($errors->has('user_id'))
									<span class="text-danger">{{ $errors->first('user_id') }}</span>
									@endif
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Contact No.<span class="required">*</span>
									</label>
									<input type="number" min="0" name="contact" id="contact" minlength="10" maxlength="12" value="{{old('contact')}}" class="form-control form-control-user" />
									@if ($errors->has('contact'))
									<span class="text-danger">{{ $errors->first('contact') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Location<span class="required">*</span>
									</label>
									<input type="text" name="location" id="location" value="{{old('location')}}" class="form-control form-control-user" />
									@if ($errors->has('location'))
									<span class="text-danger">{{ $errors->first('location') }}</span>
									@endif
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Total Room<span class="required">*</span>
									</label>
									<input type="number" min="0" name="total_room" id="total_room" value="{{old('total_room')}}" class="form-control form-control-user" />
									@if ($errors->has('total_room'))
									<span class="text-danger">{{ $errors->first('total_room') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Building Type<span class="required">*</span>
									</label>
									<input type="text" name="building_type" id="building_type" value="{{old('building_type')}}" class="form-control form-control-user" />
									@if ($errors->has('building_type'))
									<span class="text-danger">{{ $errors->first('building_type') }}</span>
									@endif
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Amenities Detail<span class="required"></span>
									</label>
									<textarea name="amenities_detail" id="amenities_detail" class="form-control form-control-user" />{{old('amenities_detail')}}</textarea>
									@if ($errors->has('amenities_detail'))
									<span class="text-danger">{{ $errors->first('amenities_detail') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Booking Price<span class="required">*</span>
									</label>
									<input type="number" min="1" name="booking_price" id="booking_price" value="{{old('booking_price')}}" class="form-control form-control-user" />
									@if ($errors->has('booking_price'))
									<span class="text-danger">{{ $errors->first('booking_price') }}</span>
									@endif
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label for="document-0" class="document-label">Venue Images</label>
									<input type="file" name="venue_image_name[]" id="venue_image_name" placeholder="Venue Image" value="{{old('venue_image_name')}}" class="form-control form-control-user" multiple />

									@if ($errors->has('venue_image_name'))
									<span class="text-danger">{{ $errors->first('venue_image_name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Other Information<span class="required"></span>
									</label>
									<textarea name="other_information" id="other_information" class="form-control form-control-user" />{{old('other_information')}}</textarea>
									@if ($errors->has('other_information'))
									<span class="text-danger">{{ $errors->first('other_information') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label for="document-0" class="document-label">Category<span class="required">*</span></label>
									<select class="form-control form-control-user" name="category_id" id="category_id">
										<option value="">Select Category</option>
										@foreach($categories as $category)
										<option value="{{$category->id}}">{{$category->name}}</option>
										@endforeach
									</select>
									@if ($errors->has('category_id'))
									<span class="text-danger">{{ $errors->first('category_id') }}</span>
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
								<button type="submit" name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
								<a href="{{route('venues.list')}}" class="btn btn-light">Cancel</a>
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
	$(document).ready(function() {
		$("form[id='add_venue_form']").validate({
			// Specify validation rules
			ignore: '',
			rules: {
				name: {
					required: true,
				},
				user_id: {
					required: true,
				},
				location: {
					required: true,
				},
				contact: {
					required: true,
					number: true,
					maxlength: 12,
					minlength: 10,
				},
				building_type: {
					required: true,
				},

				booking_price: {
					required: true,
				},
				total_room: {
					required: true
				},
				"venue_image_name[]": {
					extension: "jpg|jpeg|png",

				}
			},
			// Specify validation error messages
			messages: {
				name: {
					required: 'Venue name is required',
				},
				user_id: {
					required: 'Owner name is required',
				},
				location: {
					required: 'Location is required',
				},
				building_type: {
					required: 'Building type is required',
				},
				booking_price: {
					required: 'Booking price is required',
				},
				contact: {
					required: 'Contact no is required',
					number: 'Contact no must be digit only',
					maxlength: 'Contact no should be of 10 to 12 digit',
					minlength: 'Contact no should be of 10 to 12 digit',
				},
				total_room: {
					required: 'Total room is required',
				},
				'venue_image_name[]': {
					extension: 'Choose the image jpg,jpeg or png format Only',
				}
			},
			submitHandler: function(form) {
				form.submit();
			}
		});
	});
</script>
@stop