@extends('layouts.app')

@section('content')
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
				<div class="card-body pt-2 pb-3 ">
					<h5 class="mt-3 mb-4">
						Add Venue
					</h5>
					<form action="{{route('venue.insert')}}" method="post" class="user" id="add_venue_form" enctype="multipart/form-data">@csrf

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
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Contact<span class="required">*</span>
									</label>
									<input type="text" name="contact" id="contact" value="{{old('contact')}}" class="form-control form-control-user" />
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
									<label>Booking Price<span class="required">*</span>
									</label>
									<input type="number" minlength="1" min="1" name="booking_price" id="booking_price" value="{{old('booking_price')}}" class="form-control form-control-user" />
									@if ($errors->has('booking_price'))
									<span class="text-danger">{{ $errors->first('booking_price') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>No. of People<span class="required">*</span>
									</label>
									<input type="number" min="0" name="no_of_people" id="no_of_people" value="{{old('no_of_people')}}" class="form-control form-control-user" />
									@if ($errors->has('no_of_people'))
									<span class="text-danger">{{ $errors->first('no_of_people') }}</span>
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
							@if($amenities->count() > 0 )
							@foreach ($amenities as $key => $amenity)

							<div class="col-md-2">
								<div class="form-group ">
									<div class="col-sm-10">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="amenity_id[]" id="amenity_id{{$key}}" value="{{$amenity->id}}" {{(in_array($amenity->id, $selectedAmenities)?"checked='checked'" : '')}}>
											<label class="form-check-label" for="amenity_id{{$key}}">
												{{$amenity->name}}
											</label>
										</div>
									</div>
								</div>
							</div>
							@endforeach
							@endif
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
								<a href="{{route('home')}}" class="btn btn-light">Cancel</a>
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
				location: {
					required: true,
				},
				contact: {
					required: true,
					number: true,
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
					number: 'Contact must be digit only',
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