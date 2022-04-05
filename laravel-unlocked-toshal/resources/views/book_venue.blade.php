@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body pt-2 pb-3 manageClinicSection">
                    <h5 class="mt-3 mb-4">
                        Book Venue
                        <a href="{{route('blogs.list')}}" class="float-right"><i data-feather="x"></i></a>
                    </h5>
                    <form action="{{route('blog.create')}}" method="post" class="user" id="add_blog_form" enctype="multipart/form-data">@csrf
                        <input type="hidden" name="edit_record_id" value="">
                        <div class="form-group">
                            <label>Name<span class="required">*</span>
                            </label>
                            <input type="text" name="booking_name" id="booking_name" value="{{old('booking_name')}}" class="form-control form-control-user" />
                            @if ($errors->has('booking_name'))
                            <span class="text-danger">{{ $errors->first('booking_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email<span class="required">*</span>
                            </label>
                            <input type="text" name="booking_email" id="booking_email" value="{{old('booking_email')}}" class="form-control form-control-user datetimepicker" autocomplete="off" />
                            @if ($errors->has('booking_email'))
                            <span class="text-danger">{{ $errors->first('booking_email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Date<span class="required">*</span></label>
                            <input name="date" id="date" value="{{old('date')}}" class="form-control form-control-user booking_date">
                            @if ($errors->has('date'))
                            <span class="text-danger">{{ $errors->first('date') }}</span>
                            @endif
                        </div>
                        <div class="mt-1 mb-1">
                            <div class="text-left d-print-none mt-4">
                                <button type="submit" name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Book</button>
                                <a href="{{route('home')}}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('body').on('focus', ".booking_date", function() {
            jQuery(this).datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0
            });
        });
    });
</script>
@stop