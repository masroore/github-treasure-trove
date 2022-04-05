@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Rating List</h1>
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
						Add Rating
					</h5>
					<form action="{{route('rating.create')}}" method="post" class="user" id="add_rating_form" enctype="multipart/form-data">@csrf
						<input type="hidden" name="venue_id" id="venue_id" value="4">					
                        <div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Rating<span class="required">*</span>
									</label>
									<div id="rating_div">
                                        <div class="star-rating">
                                            <span class="fa divya fa-star-o" data-rating="1" style="font-size:20px;"></span>
                                            <span class="fa fa-star-o" data-rating="2" style="font-size:20px;"></span>
                                            <span class="fa fa-star-o" data-rating="3" style="font-size:20px;"></span>
                                            <span class="fa fa-star-o" data-rating="4" style="font-size:20px;"></span>
                                            <span class="fa fa-star-o" data-rating="5" style="font-size:20px;"></span>
                                            <input type="hidden" name="rating" class="rating-value" value="1">
                                        </div>
	                                </div>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="form-group">
									<label>Review<span class="required"></span>
									</label>
                                        <textarea  name="review" id="review" class="form-control" ></textarea> 
                                         @if ($errors->has('review'))
                                            <span class="text-danger">{{ $errors->first('review') }}</span>
                                        @endif
                                </div>
							</div>
						</div>
						<div class="mt-1 mb-1">
							<div class="text-left d-print-none mt-4">          
								<button id="srr_rating" name="action" id="edit-genre-btn" value="save" class="btn btn-primary">Save</button>
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

    jQuery( document ).ready(function() {
        var star_rating = $('.star-rating .fa');
        var SetRatingStar = function() {
        return star_rating.each(function() {
            if (parseInt(star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
            });
        };
        star_rating.on('click', function() {
            star_rating.siblings('input.rating-value').val($(this).data('rating'));
            return SetRatingStar();
        });
        SetRatingStar();
    });

    //insert rating and reviews
    jQuery("#srr_rating").click(function() {
        var star_rating = jQuery('.star-rating .fa');
        var rating = parseInt(star_rating.siblings('input.rating-value').val());
        var review= jQuery('#review').val();
        var venue_id= jQuery('#venue_id').val();
        if(rating>0 ){
            jQuery.ajax({
                url: baseurl + '/rating/create/',
                type: "post",
                data: {
                    rating: rating,
                    review:review,
                    venue_id:venue_id			
                },
                success : function(data){
                }
            });
        }
        else{            
        }       
    });
</script>
@stop