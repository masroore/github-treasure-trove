@extends('admin.layouts.cmlayout')
@section('body')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Booking List</h1>
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
						Add Booking Detail
						<a href="{{route('bookings.list')}}" class="float-right"><i data-feather="x"></i></a>
					</h5>
					<form action="{{route('booking.create')}}" method="post" class="user" id="add_booking_form" enctype="multipart/form-data">@csrf

						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Venue<span class="required">*</span>
									</label>
                                    <select class="form-control form-control-user" name="venue_id" id="venue_id">
                                        <option value="">Select Venue</option>
                                        @foreach($venues as $venue)
                                            <option value="{{$venue->id}}">{{$venue->name}}</option>
                                        @endforeach
									</select>
                                    @if ($errors->has('parent_id'))
                                        <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                                    @endif
								</div>
							</div>
                            <div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Select User<span class="required">*</span>
									</label>
                                    <select class="form-control form-control-user" name="user_id" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name ." ".$user->last_name}}</option>
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
									<label>Booking Name<span class="required">*</span>
									</label>
									<input type="text" name="booking_name" id="booking_name" value="{{old('booking_name')}}" class="form-control form-control-user" />
									@if ($errors->has('booking_name'))
										<span class="text-danger">{{ $errors->first('booking_name') }}</span>
									@endif
								</div>
							</div>
                            <div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Booking Email<span class="required">*</span>
									</label>
									<input type="text" name="booking_email" id="booking_email" value="{{old('booking_email')}}" class="form-control form-control-user" />
									@if ($errors->has('booking_email'))
										<span class="text-danger">{{ $errors->first('booking_email') }}</span>
									@endif
								</div>
							</div>
						</div>
                        <div class="row">
                        	<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Date<span class="required">*</span>
									</label>
									<input type="text" name="date" id="date" value="{{old('date')}}" class="booking_date form-control form-control-user"  autocomplete="off"/>
									@if ($errors->has('date'))
										<span class="text-danger">{{ $errors->first('date') }}</span>
									@endif
								</div>
							</div>
                            <!-- <div class="col-lg-4 col-md-6 col-12">
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
                            </div> -->
                        </div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">
                                <button type="submit" name="action" value="saveadd" class="btn btn-primary">Save & Add New</button>
								<button type="submit"  name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
								<a href="{{route('bookings.list')}}" class="btn btn-light">Cancel</a>
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
	<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
	jQuery( document ).ready(function() {

		$("form[id='add_booking_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					booking_name: {
						required: true,
					},
					user_id: {
						required: true,
					},
					booking_email: {
						required: true,
						email: true,
					},
					date: {
						required: true,
					},
					venue_id: {
						required: true,
					},
				},
				// Specify validation error messages
				messages: {
					booking_name: {
						required: 'Booking name is required',
					},
					user_id: {
						required: 'User name is required',
					},
					booking_email: {
						required: 'Booking email is required',
					},
					date: {
						required: 'Date is required',
					},
					venue_id: {
						required: 'Venue name is required',
					},
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
        jQuery('body').on('focus',".booking_date", function(){
		jQuery(this).datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
           });
        });
    </script>
	@stop