@inject('GetCommon', 'App\Traits\GetCommon')
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
				<div class="card-body pt-2 pb-3 editVenueSection">
					<h5 class="mt-3 mb-4">
						Update Venue Detail
						<a href="{{route('venues.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('venue.update')}}" method="post" class="user" id="edit_venue_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="edit_record_id" value="{{$venueDetail->id}}">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Name<span class="required">*</span>
									</label>
									<input type="text" name="name" id="name" value="{{old('name', $venueDetail->name)}}" class="form-control form-control-user" />
									@if ($errors->has('name'))
										<span class="text-danger">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Location<span class="required">*</span>
									</label>
									<input type="text" name="location" id="location" value="{{old('location', $venueDetail->location)}}" class="form-control form-control-user" />
									@if ($errors->has('location'))
										<span class="text-danger">{{ $errors->first('location') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Contact No.<span class="required">*</span>
									</label>
									<input type="text" min="0" name="contact" id="contact" minlength="10" maxlength="12"  value="{{old('contact', $venueDetail->contact)}}" class="form-control form-control-user" />
									@if ($errors->has('contact'))
										<span class="text-danger">{{ $errors->first('contact') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Building Type<span class="required">*</span>
									</label>
									<input type="text" name="building_type" id="building_type"  value="{{old('building_type', $venueDetail->building_type)}}" class="form-control form-control-user" />
									@if ($errors->has('building_type'))
										<span class="text-danger">{{ $errors->first('building_type') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Total Room<span class="required">*</span>
									</label>
									<input type="number" min="0" name="total_room" id="total_room"  value="{{old('total_room', $venueDetail->total_room)}}" class="form-control form-control-user" />
									@if ($errors->has('total_room'))
										<span class="text-danger">{{ $errors->first('total_room') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Booking Price<span class="required">*</span>
									</label>
									<input type="number" min="1" name="booking_price" id="booking_price"  value="{{old('booking_price', $venueDetail->booking_price)}}" class="form-control form-control-user" />
									@if ($errors->has('booking_price'))
										<span class="text-danger">{{ $errors->first('booking_price') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Amenities Detail<span class="required"></span>
									</label>
									<textarea name="amenities_detail" id="amenities_detail"  class="form-control form-control-user" />{{old('amenities_detail', $venueDetail->amenities_detail)}}</textarea>
									@if ($errors->has('amenities_detail'))
										<span class="text-danger">{{ $errors->first('amenities_detail') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Other Information<span class="required"></span>
									</label>
									<textarea  name="other_information" id="other_information" class="form-control form-control-user" />{{old('other_information', $venueDetail->other_information)}}</textarea>
									@if ($errors->has('other_information'))
										<span class="text-danger">{{ $errors->first('other_information') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label for="document-0" class="document-label">Venue Images</label>
									<input type="file" name="venue_image_name[]" id="venue_image_name" placeholder="Venue Image" value="{{old('venue_image_name' , isset($venueImages->name) ? $venueImages->name : '')}}"  class="form-control form-control-user" multiple/>

									@if ($errors->has('venue_image_name'))
									<span class="text-danger">{{ $errors->first('venue_image_name') }}</span>
									@endif
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12 images-sections">
								<div class="form-group">
								@if($venueImages->count())
									@foreach($venueImages as $key => $images)
									@php
										$type = explode(".",$images->name)[1];
										$image = $GetCommon->createThumbnail(public_path('assets/venue/images/'.$images->name), $type, 175, 75);
									@endphp
										@if($image)
											<div class="main-pic">
												<img class="img-profile mt30" src="{{ 'data:image/' .$type. ';base64,' .base64_encode($image) }}" width="100px" alt="Venue Image">

												<a href="{{route('venue.delete', ['id' => $images->id, 'venue_id' => $images->venue_id,'name' => $images->name])}}">
												<img src="{{asset('backend/images/cross-icon.png')}}" alt="Image" class="cross-section"></a></div>
										@endif
									@endforeach
								@else
									<img class="img-profile mt30" width="100" height="100" src="{{asset('backend/images/not-available.png')}}" alt="Image not available">
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
										    <a class="btn btn-success btn-sm {{ old('status', $venueDetail->status) == '1' ? 'active' : 'notActive'}}" data-toggle="status" data-title="1">Enabled</a>
											<a class="btn btn-danger btn-sm {{ old('status', $venueDetail->status) == '0' ? 'active' : 'notActive'}}" data-toggle="status" data-title="0">Disabled</a>
										</div>
										<input type="hidden" name="status" id="status" value="{{ old('status',$venueDetail->status) == '1' ? '1' : '0'}}">
									</div>
									@if ($errors->has('status'))
									<span class="text-danger">{{ $errors->first('status') }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
								<button type="submit" id="edit-genre-btn" class="btn btn-primary">Update</button>
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
		$( document ).ready(function() {
			$("form[id='edit_venue_form']").validate({
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
						maxlength: 12,
						minlength: 10,
					},
					building_type :{
						required: true,
					},
					booking_price:{
						required: true,
					},
					total_room:{
						required:true
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
					contact:{
						required: 'Contact no is required',
						number: 'Contact no must be digit only',
						maxlength: 'Contact no should be of 10 to 12 digit',
						minlength: 'Contact no should be of 10 to 12 digit',
					},
					booking_price: {
						required: 'Booking price is required',
					},
					total_room: {
						required: 'Total room is required',
					},
					'venue_image_name[]':{
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