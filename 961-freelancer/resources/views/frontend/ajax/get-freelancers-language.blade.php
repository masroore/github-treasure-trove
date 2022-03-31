@foreach($freelancers as $freelancer)
<div class="wt-userlistinghold">
	<figure class="wt-userlistingimg">
		@if($freelancer->freelancer->profile_image != '')
		<img src="{{asset('assets/images/user/profile/'.$freelancer->freelancer->profile_image)}}" alt="image description">
		@else
		<img src="{{asset('assets/images/user-login.png')}}" alt="image description">
		@endif
	</figure>
	<div class="wt-userlistingcontent">
		<div class="wt-contenthead">
			<div class="wt-title">
				<a href="{{ route('freelancers.show',$freelancer->freelancer->username)}}"><i class="fa fa-check-circle"></i> {{$freelancer->freelancer->first_name}} {{$freelancer->freelancer->last_name}}
				</a>
				<h2>{{$freelancer->freelancer->tagline}}</h2>
			</div>
			<ul class="wt-userlisting-breadcrumb">
				<li><span><i class="far fa-money-bill-alt"></i> ${{$freelancer->freelancer->hourly_rate}}.00 / hr</span></li>
				<li><span><!-- <img src="{{asset('assets/images/flag/img-02.png')}}" alt="img description"> -->  {{$freelancer->freelancer->country}}</span></li>
				@if(Auth::user())
				<li><a href="javascript:void(0);" onclick="saveUser({{$freelancer->freelancer->id}})" class="wt-clicksave save{{$freelancer->id}}">
					
						<i class="fal fa-heart"></i> Save
						
				</a></li>
				@else
				<li><a href="javascript:void(0);" class="wt-clicksave save{{$freelancer->freelancer->id}}"><i class="fal fa-heart"></i> Save</a></li>
				@endif
			</ul>
		</div>
		<div class="wt-rightarea">
			<?php 
				$rating_avg = 0.0;
        $total = 0;
        foreach($freelancer->freelancerRating as $rating){
          $total = $total + $rating->general_rating;
          $rating_avg = $total/$freelancer->freelancer_rating_count;
        }
			?>
			<span class="wt-starsvtwo">
				@if($rating_avg == 0 || $rating_avg < 1)
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				@elseif($rating_avg == 1 || $rating_avg < 1.5)
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				@elseif($rating_avg == 1.5 || $rating_avg < 2.5)
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				@elseif($rating_avg == 2.5 || $rating_avg < 3.5)
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star "></i>
				<i class="fa fa-star "></i>
				@elseif($rating_avg == 3.5 || $rating_avg < 4.5)
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star "></i>
				@elseif($rating_avg == 4.5 || $rating_avg < 5.5)
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				<i class="fa fa-star fill"></i>
				@endif
			</span>
			
			<span class="wt-starcontent">{{$rating_avg}}/<sub>5</sub> <em>({{$freelancer->freelancer_rating_count}} Feedback)</em></span>
		</div>
	</div>
	<div class="wt-description">
		<p>{{ \Illuminate\Support\Str::limit($freelancer->freelancer->description, 200, $end='...') }}</p>
	</div>
	<div class="wt-tag wt-widgettag">
		@foreach($freelancer->freelancer->userSkills as $skill)
		<a href="javascript:void(0);">{{ App\Models\User::skillTitle($skill->skill_id)->skill_name }}</a>
		@endforeach
	</div>
</div>
@endforeach

{{ $freelancers->links('frontend.pagination.freelancers') }}