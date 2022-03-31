@foreach($jobs as $job)
<!-- Job Listing -->
<div class="wt-userlistinghold wt-userlistingholdvtwo float-none">
	<div class="wt-userlistingcontent">
		<div class="wt-contenthead">
			<div class="wt-title">
				<a href="{{url('client/'.$job->clientInfo->username)}}"><i class="fa fa-check-circle"></i> {{$job->clientInfo->first_name}} {{$job->clientInfo->last_name}}
				</a>
				<h2>{{$job->job_title}}</h2>
			</div>
			<div class="wt-description">
				<p>{{ \Illuminate\Support\Str::limit($job->job_description, 200, $end='...') }}</p>
			</div>
			<div class="wt-tag wt-widgettag">
				@foreach(explode(',', $job->job_skills) as $skill)
				<a href="javascript:void(0);">{{$skill}}</a>
				@endforeach
			</div>
		</div>
		<div class="wt-viewjobholder">
			<ul>
				<li><span><i class="fal fa-ribbon wt-viewjobdollar"></i>{{$job->service_level}}</span></li>
				<li><span><em><i class="fal fa-map-marker-alt wt-viewjobclock"></i></em>{{$job->job_location}}</span></li>
				<li><span class="text-capitalize"><i class="far fa-folder wt-viewjobfolder"></i>Type: {{$job->job_type}}</span></li>
				<li><span><i class="far fa-clock wt-viewjobclock"></i>Duration: {{$job->job_duration}}</span></li>
				<li><span><i class="fa fa-tag wt-viewjobtag"></i>Job ID: {{$job->job_id}}</span></li>
				@if(Auth::user())
					@if(App\Models\SaveItem::jobSaved(Auth::user()->id,$job->id) == 0)
					<li><a href="javascript:void(0);" class="wt-clicklike wt-clicksave" onclick="saveJob({{$job->id}})"><i class="fal fa-heart"></i> Save</a></li>
					@else
					<li><a href="javascript:void(0);" class="wt-clicklike wt-clicksave" onclick="saveJob({{$job->id}})"><i class="fa fa-heart"></i> Saved</a></li>
					@endif
				@endif
				<li class="wt-btnarea"><a href="{{ route('job.show',$job->job_id)}}" class="wt-btn">View Job</a></li>
			</ul>
		</div>
	</div>
</div>		
@endforeach