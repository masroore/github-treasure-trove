@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
</style>
@endsection
@section('content')
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			@if(Auth::user()->account_type == 'Client')
			<section class="wt-haslayout wt-dbsectionspace wt-proposals">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>Manage Jobs</h2>
							</div>
							@if(count($jobData) > 0)
							@foreach($jobData as $job)
							<div class="wt-dashboardboxcontent wt-rcvproposala">
								<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
									<div class="wt-userlistingcontent">
										<div class="wt-contenthead">
											<div class="wt-title">
												<a href="javascript:void(0)"><i class="fa fa-check-circle"></i> {{$job->clientInfo->first_name}} {{$job->clientInfo->last_name}}
												</a>
												<h2>{{$job->job_title}}</h2>
											</div>
											<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
												<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$job->service_level}}</span></li>
												<li><span class="wt-dashboradclock"><i class="fal fa-map-marker-alt"></i> {{$job->job_location}}</span></li>
												<li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> Type: {{$job->job_type}}</a></li>
												<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$job->job_duration}}</span></li>
											</ul>
										</div>
										<div class="wt-rightarea">
											<div class="wt-hireduserstatus">
												<h4>{{App\Models\Proposal::getProposalCount($job->job_id)}}</h4><span>Proposals Received</span>
												<ul class="wt-hireduserimgs">
													@foreach($job->proposal as $proposalUser)
													<li><figure><img src="{{asset('assets/images/user/profile/'.App\Models\Proposal::freelancer($proposalUser->user_id)->profile_image)}}" alt="img description" class="mCS_img_loaded"></figure></li>
													@endforeach
												</ul>
											</div>
										</div>
									</div>	
								</div>
								<div class="wt-freelancerholder wt-rcvproposalholder">
									<div class="wt-tabscontenttitle">
										<h2>Received Proposals</h2>
									</div>
									<div class="wt-managejobcontent">
										@foreach($job->proposal as $proposal)
										<div class="wt-userlistinghold wt-featured wt-proposalitem">
											<!-- <span class="wt-featuredtag"><img src="images/featured.png" alt="img description" data-tipso="Plus Member" class="template-content tipso_style mCS_img_loaded"></span> -->
											<figure class="wt-userlistingimg">
												<img src="{{asset('assets/images/user/profile/'.App\Models\Proposal::freelancer($proposal->user_id)->profile_image)}}" alt="image description" class="mCS_img_loaded">
											</figure>
											<div class="wt-proposaldetails">
												<div class="wt-contenthead">
													<div class="wt-title">
														<a href="{{ route('freelancers.show',App\Models\Proposal::freelancer($proposal->user_id)->username)}}"> {{App\Models\Proposal::freelancer($proposal->user_id)->first_name}} {{App\Models\Proposal::freelancer($proposal->user_id)->last_name}}</a>
													</div>
												</div>
												<div class="wt-proposalfeedback">
													<span class="wt-starsvtwo">
														<i class="fa fa-star fill"></i>
													</span>
													<span class="wt-starcontent"> {{App\Models\Job::getFeedbackAvg($proposal->user_id)}}/<i>5</i> <em> ({{App\Models\Job::getFreelancerFeedback($proposal->user_id)}} Feedback)</em></span>
												</div>													
											</div>
											<div class="wt-rightarea">
												@if($proposal->status == 1 && $job->job_status == 1)
													@if (App\Models\User::walletAmt())
	                        	@if(App\Models\User::walletAmt()->amt < $proposal->budget)
	                        	<p class="mb-0 mt-2 text-danger">You should have minimum <strong>${{$proposal->budget}}</strong> in your wallet to hire this freelancer. <a href="{{route('payments.deposit')}}">Deposit amount</a></p>
	                        	@endif
	                        @endif
	                      @endif
												<div class="wt-btnarea">
												
													@if($proposal->status == 1 && $job->job_status == 1)
													<a href="javascript:void(0);" onclick="hireNow('{{$proposal->id}}' ,'{{$proposal->job_id}}','{{$proposal->user_id}}','{{$proposal->budget}}')" class="wt-btn rounded-pill text-capitalize">Hire Now</a>
													<a href="javascript:void(0);" onclick="rejectNow('{{$proposal->id}}' ,'{{$proposal->job_id}}','{{$proposal->user_id}}')" class="wt-btn rounded-pill text-capitalize">Reject</a>
													@endif
													@if($proposal->status == 2)
													<a href="{{url('ongoing-job/'.$proposal->job->job_id)}}">View Job</a>
													<a href="javascript:void(0);" class="wt-btn rounded-pill text-capitalize">Hired</a>
													@endif
													@if($proposal->status == 3)
													<a href="javascript:void(0);" class="wt-btn rounded-pill text-capitalize">Rejected</a>
													@endif
													@if($proposal->status == 4)
													<a href="javascript:void(0);" class="wt-btn rounded-pill text-capitalize">Expired</a>
													@endif
													@if($proposal->status == 5)
													<a href="javascript:void(0);" class="wt-btn rounded-pill text-capitalize">Completed</a>
													@endif
													<form id="createChat{{$proposal->id}}" class="d-inline">
														@csrf
														<input type="hidden" id="jobId{{$proposal->id}}" name="job_id" value="{{$proposal->job_id}}">
														<input type="hidden"id="proposalId{{$proposal->id}}" name="proposal_id" value="{{$proposal->id}}">
														<input type="hidden"id="receiverId{{$proposal->id}}" name="receiver_id" value="{{$proposal->	user_id}}">
														<button type="button" name="chat" onclick="createChat({{$proposal->id}})" class="wt-btn chat-btn rounded-pill text-capitalize">Chat</button>
													</form>
												</div>												
												<div class="wt-hireduserstatus">
													@if($job->job_type == 'hourly')
													<h5>&#36;{{$proposal->budget}}<small class="fs-6 text-lowercase">/hr</small></h5>
													@else
													<h5>&#36;{{$proposal->budget}}</h5>
													@endif
													<span>In 0{{$proposal->duration}} Months</span>
												</div>
												<div class="wt-hireduserstatus cursor-pointer" data-bs-toggle="modal" data-bs-target="#coverModal{{$proposal->id}}">
													<i class="far fa-envelope"></i>
													<span>Cover Letter</span>
												</div>	
												<!-- Modal -->
												<div class="modal fade" id="coverModal{{$proposal->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title text-center" id="exampleModalLabel">Cover Letter</h5>
												        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												      </div>
												      <div class="modal-body">
												        <p>{{$proposal->cover_letter}}</p>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn wt-btn" data-bs-dismiss="modal">Close</button>
												      </div>
												    </div>
												  </div>
												</div>													
												<div class="wt-hireduserstatus cursor-pointer" data-bs-toggle="modal" data-bs-target="#attachModal{{$proposal->id}}">
													<i class="fa fa-paperclip"></i>
													<span>Attachments</span>
												</div>	
												<!-- Modal -->
												<div class="modal fade" id="attachModal{{$proposal->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title text-center" id="exampleModalLabel">Attached Files</h5>
												        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												      </div>
												      <div class="modal-body">
												        <ul class="wt-attachfile">
												        	@if ($proposal->attachments != "")
												        		@foreach(explode(',',$proposal->attachments) as $attach)
												        		<li>
												        			<span>{{$attach}}</span>
												        			<em><a href="{{asset('assets/images/proposal/'.$attach)}}" download><i class="fal fa-download"></i></a></em>
												        		</li>
												        		@endforeach
												        	@endif
												        </ul>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn wt-btn" data-bs-dismiss="modal">Close</button>
												      </div>
												    </div>
												  </div>
												</div>
												<!-- End Modal -->
											</div>

											@if($proposal->proposal_type == 'by_milestone')
											<div class="wt-userlistinghold wt-featured wt-proposalitem">
												<div class="wt-tabscontenttitle">
													<h2>Milestones</h2>
												</div>
												<div class="table-responive">
													<table class="table">
														<thead>
															<tr style="background-color: #e11a22;">
																<th class="text-white">#</th>
																<th class="text-white">Name</th>
																<th class="text-white">Amount</th>
																<th class="text-white">Due Date</th>
																<th class="text-white">Status</th>
																<th class="text-white"></th>
															</tr>
														</thead>
														<tbody>
															@foreach(App\Models\Proposal::milestones($proposal->id) as $key=>$milestone)
															<tr>
																<td>{{$key+1}}</td>
																<td>{{$milestone->detail}}</td>
																<td>{{$milestone->milestone_amount}}</td>
																<td>{{date('F d, Y', strtotime($milestone->due_date))}} </td>
																<td class="text-capitalize">{{$milestone->status}}</td>
																<td>
																	<div>
																		@if($milestone->status == 'request')
																		<form method="post" action="{{ route('milestone.depositOrReject', $milestone->id) }}">
																			@csrf
																			<input type="hidden" name="proposal_id" value="{{$proposal->id}}">
																			<input type="hidden" name="milestone_id" value="{{$milestone->id}}">
																			<input type="hidden" name="milestone_amount" value="{{$milestone->milestone_amount}}">
																			<input type="hidden" name="milestone_service_fee" value="{{$milestone->milestone_service_fee}}">
																			<input type="hidden" name="milestone_receive_amount" value="{{$milestone->milestone_receive_amount}}">
																			<input type="hidden" name="milestone_detail" value="{{$milestone->detail}}">
																			<input type="hidden" name="milestone_job_id" value="{{$milestone->job_id}}">
																			<input type="hidden" name="freelancer_id" value="{{$milestone->user_id}}">
																		<input type="submit" class="btn milestone-btn accept-btn rounded-pill" name="deposit" value="Deposit">
																		<input type="submit" name="reject" onclick=" return confirm('Are you sure you want to cancel this milestone?')" class="btn milestone-btn reject-btn rounded-pill" value="Reject">
																		</form>
																		@endif
																		@if($milestone->status == 'accept')
																		<form action="{{ route('milestone.rrd', $milestone->id) }}" method="post">
																			@csrf
																			<input type="hidden" name="proposal_id" value="{{$proposal->id}}">
																			<input type="hidden" name="milestone_job_id" value="{{$milestone->job_id}}">
																			<input type="submit" class="btn milestone-btn accept-btn rounded-pill" name="amount_release" value="Release">
																		</form>
																		@endif
																		@if($milestone->status == 'reject')
																		<button class="btn milestone-btn reject-btn rounded-pill">Rejected</button>
																		@endif
																		@if($milestone->status == 'paid')
																		<button class="btn milestone-btn accept-btn rounded-pill">Paid</button>
																		@endif
																	</div>
																</td>
															</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
											@endif
										</div>
										@endforeach		
									</div>										
								</div>
							</div>
							@endforeach
							@else
							<div class="wt-dashboardboxcontent wt-rcvproposala">
								<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
									<div class="wt-userlistingcontent">
										<div class="wt-contenthead">
											<h4>Yet you didn't receive any proposal on your posted jobs</h4>
										</div>
									</div>
								</div>
							</div>
							@endif
							{{ $jobData->links('frontend.pagination.manage-jobs') }}								
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
						<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-17.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientOngoingCount(Auth::user()->id)}}</h3>
										<span>Total Ongoing Jobs</span>
									</div>
								</div> 
							</div>
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent wt-componyfolow">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-16.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientCompletedCount(Auth::user()->id)}}</h3>
										<span>Total Completed Jobs</span>
									</div>
								</div> 
							</div>								
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent  wt-freelancelike">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-15.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientCancelledCount(Auth::user()->id)}}</h3>
										<span>Total Cancelled Jobs</span>
									</div>
								</div> 
							</div>								
						</aside>
					</div>
				</div>
			</section>
			@endif
			<!-- Freelancer -->
			@if(Auth::user()->account_type == 'Freelancer')
			<section class="wt-haslayout wt-dbsectionspace wt-proposals">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>Proposals</h2>
							</div>
							@if(count($proposals) > 0)
							@foreach($proposals as $proposal)
							<div class="wt-dashboardboxcontent wt-rcvproposala">
								<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
									<div class="wt-userlistingcontent">
										<div class="wt-contenthead">
											<div class="wt-title">
												<a href="javascript:void(0)"><i class="fa fa-check-circle"></i> {{App\Models\Job::client($proposal->job->user_id)->first_name}} {{App\Models\Job::client($proposal->job->user_id)->last_name}}
												</a>
												<h2>{{$proposal->job->job_title}}</h2>
											</div>
											<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
												<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$proposal->job->service_level}}</span></li>
												<li><span class="wt-dashboradclock"><i class="fal fa-map-marker-alt"></i> {{$proposal->job->job_location}}</span></li>
												<li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> Type: {{$proposal->job->job_type}}</a></li>
												<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$proposal->job->job_duration}}</span></li>
											</ul>
										</div>
										
									</div>	
								</div>
								<div class="wt-freelancerholder wt-rcvproposalholder">
									<div class="wt-tabscontenttitle">
										<h2>Sent Proposal</h2>
									</div>
									<div class="wt-managejobcontent">
										<div class="wt-userlistinghold wt-featured wt-proposalitem">
											<!-- <span class="wt-featuredtag"><img src="images/featured.png" alt="img description" data-tipso="Plus Member" class="template-content tipso_style mCS_img_loaded"></span> -->
											<figure class="wt-userlistingimg">
												<img src="{{asset('assets/images/user/profile/'.App\Models\Proposal::freelancer($proposal->user_id)->profile_image)}}" alt="image description" class="mCS_img_loaded">
											</figure>
											<div class="wt-proposaldetails">
												<div class="wt-contenthead">
													<div class="wt-title">
														<a href="{{ route('freelancers.show',App\Models\Proposal::freelancer($proposal->user_id)->username)}}"> {{App\Models\Proposal::freelancer($proposal->user_id)->first_name}} {{App\Models\Proposal::freelancer($proposal->user_id)->last_name}}</a>
													</div>
												</div>
												<div class="wt-proposalfeedback">
													<span class="wt-starsvtwo">
														<i class="fa fa-star fill"></i>
													</span>
													<span class="wt-starcontent"> {{$rating}}/<i>5</i> <em> ({{$proposal->rating_count}} Feedback)</em></span>
												</div>													
											</div>
											<div class="wt-rightarea">
												<div class="wt-btnarea">
													@if($proposal->status == 1 && $proposal->job->job_status == 1)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Active</a>
													@endif
													@if($proposal->status == 2)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Hired</a>
													<a href="{{url('ongoing-job/'.$proposal->job->job_id)}}">View Job</a>
													@endif
													@if($proposal->status == 3)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Reject</a>
													@endif
													@if($proposal->status == 4)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Job Closed</a>
													@endif
													@if($proposal->status == 5)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Completed</a>
													@endif
													<!-- @if($proposal->job->job_status == 4)
													<a href="javascript:void(0);" class="wt-btn rounded-pill">Job Close</a>
													@endif -->
												</div>												
												<div class="wt-hireduserstatus">
													<h5>&#36;{{$proposal->budget}}</h5>
													
													<span>In 0{{$proposal->duration}} Months</span>
												</div>
												<div class="wt-hireduserstatus cursor-pointer" data-bs-toggle="modal" data-bs-target="#coverModal{{$proposal->id}}">
													<i class="far fa-envelope"></i>
													<span>Cover Letter</span>
												</div>	
												<!-- Modal -->
												<div class="modal fade" id="coverModal{{$proposal->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title text-center" id="exampleModalLabel">Cover Letter</h5>
												        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												      </div>
												      <div class="modal-body">
												        <p>{{$proposal->cover_letter}}</p>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn wt-btn" data-bs-dismiss="modal">Close</button>
												      </div>
												    </div>
												  </div>
												</div>													
												<div class="wt-hireduserstatus cursor-pointer" data-bs-toggle="modal" data-bs-target="#attachModal{{$proposal->id}}">
													<i class="fa fa-paperclip"></i>
													<span>Attachments</span>
												</div>	
												<!-- Modal -->
												<div class="modal fade" id="attachModal{{$proposal->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title text-center" id="exampleModalLabel">Attached Files</h5>
												        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												      </div>
												      <div class="modal-body">
												        <ul class="wt-attachfile">
												        	@if ($proposal->attachments != "")
												        		@foreach(explode(',',$proposal->attachments) as $attach)
												        		<li>
												        			<span>{{$attach}}</span>
												        			<em><a href="{{asset('assets/images/proposal/'.$attach)}}" download><i class="fal fa-download"></i></a></em>
												        		</li>
												        		@endforeach
												        	@endif
												        </ul>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn wt-btn" data-bs-dismiss="modal">Close</button>
												      </div>
												    </div>
												  </div>
												</div>
												<!-- End Modal -->
											</div>
											@if($proposal->proposal_type == 'by_milestone')
											<div class="wt-userlistinghold wt-featured wt-proposalitem">
												<div class="wt-tabscontenttitle">
													<h2>Milestones</h2>
												</div>
												<div class="table-responive">
													<table class="table">
														<thead>
															<tr style="background-color: #e11a22;">
																<th class="text-white">#</th>
																<th class="text-white">Name</th>
																<th class="text-white">Amount</th>
																<th class="text-white">Due Date</th>
																<th class="text-white">Status</th>
																<th class="text-white"></th>
															</tr>
														</thead>
														<tbody>
															@foreach(App\Models\Proposal::milestones($proposal->id) as $key=>$milestone)
															<tr>
																<td>{{$key+1}}</td>
																<td>{{$milestone->detail}}</td>
																<td>{{$milestone->milestone_amount}}</td>
																<td>{{date('F d, Y', strtotime($milestone->due_date))}} </td>
																<td class="text-capitalize">{{$milestone->status}}</td>
																<td>
																	<div>
																		@if($milestone->status == 'request')
																		<button class="btn milestone-btn accept-btn rounded-pill" style="width: 100px;">Requested</button>
																		@endif
																		@if($milestone->status == 'accept')
																		<button class="btn milestone-btn accept-btn rounded-pill" style="width: 100px;">Accepted</button>
																		@endif
																		@if($milestone->status == 'reject')
																		<button class="btn milestone-btn reject-btn rounded-pill" style="width: 100px;">Rejected</button>
																		@endif
																		@if($milestone->status == 'paid')
																		<button class="btn milestone-btn accept-btn rounded-pill" style="width: 100px;">Paid</button>
																		@endif
																	</div>
																</td>
															</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
											@endif
										</div>	
									</div>										
								</div>
							</div>
							@endforeach
							@else
							<div class="wt-dashboardboxcontent wt-rcvproposala">
								<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
									<div class="wt-userlistingcontent">
										<div class="wt-contenthead">
											<h4>You haven't sent proposal to any job.</h4>
										</div>
									</div>
								</div>
							</div>
							@endif
							{{ $proposals->links('frontend.pagination.manage-jobs') }}								
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
						<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-17.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Proposal::freelancerOngoingCount(Auth::user()->id)}}</h3>
										<span>Total Ongoing Jobs</span>
									</div>
								</div> 
							</div>
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent wt-componyfolow">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-16.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Proposal::freelancerCompletedCount(Auth::user()->id)}}</h3>
										<span>Total Completed Jobs</span>
									</div>
								</div> 
							</div>								
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent  wt-freelancelike">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-15.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Proposal::freelancerCancelledCount(Auth::user()->id)}}</h3>
										<span>Total Cancelled Jobs</span>
									</div>
								</div> 
							</div>								
						</aside>
					</div>
				</div>
			</section>
			@endif
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	function hireNow(id,job_id,proposal_user){
		var obj = {
			from: "{{auth()->user()->id}}",
			to : proposal_user,
			message : "You have been hired for the project",
			noti_type : 'hire',
			status : 'unread'
		}
		$.ajax({
	    url: "{{route('hire-freelancer')}}",
	    type: 'POST',
	    data: {"proposal_id": id,"job_id": job_id},
	    
	    success: (response)=>{
	        if (response.status == 'true') {
	        	socket.emit("sendNotification", obj);
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/ongoing-jobs/";
	            
	            
	        }else{
	            $.notify(response.message , 'error');

	        }
	    },
	    error: (errorResponse)=>{
	        $.notify( errorResponse, 'error'  );


	    }
		})
	}
	function rejectNow(id,job_id,proposal_user){
		var obj = {
			from: "{{auth()->user()->id}}",
			to : proposal_user,
			message : "You proposal have been rejected by the client",
			noti_type : 'reject',
			status : 'unread'
		}
		$.ajax({
	    url: "{{route('reject-freelancer')}}",
	    type: 'POST',
	    data: {"proposal_id": id,"job_id": job_id},

	    success: (response)=>{
	        if (response.status == 'true') {
	        	socket.emit("sendNotification", obj);
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/proposals/";
	            
	            
	        }else{
	            $.notify(response.message , 'error');

	        }
	    },
	    error: (errorResponse)=>{
	        $.notify( errorResponse, 'error'  );


	    }
		})
	}


	function createChat(id){
		let createFormData = $('#createChat'+id).serialize();

		$.ajax({
	    url: "{{url('add-friend')}}",
	    type: 'POST',
	    data: createFormData,

	    success: (response)=>{
	        if (response.status == 'true') {
	            $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/messages?conversation="+response.conversation_id;
	            
	            
	        }else{
	            $.notify(response.message , 'error');

	        }
	    },
	    error: (errorResponse)=>{
	        $.notify( errorResponse, 'error'  );


	    }
		})
	}
</script>
@endsection