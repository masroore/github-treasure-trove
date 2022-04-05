<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>{{ config('app.name', 'Unlocked') }} Admin</title>
	<meta name="csrf-token" content="{!! csrf_token() !!}">
	<meta name="baseurl" content="{{url('')}}">
	<link href="{{asset('backend/css/all.min.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/custom_style.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

</head>

<body class="bg-gradient-primary">
    @if(Auth::user())
	    @php
		$user = Auth::user();
		@endphp
	@endif
	@section('header')
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admindashboard')}}">
			Unlocked
			</a>
			<!-- Divider -->
			<hr class="sidebar-divider">
			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
			    <a class="nav-link" href="{{route('admindashboard')}}"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
			</li>
			<!-- Divider -->
			<hr class="sidebar-divider">
			<li class="nav-item">
				<a class="nav-link" href="{{route('users.list')}}">	<i class="fas fa-users"></i>
					<span>Users</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('owners.list')}}">	<i class="fas fa-users"></i>
					<span>Venue Owners</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('venues.list')}}">	<i class="fa fa-home"></i>
					<span>Venues</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('bookings.list')}}">	<i class="fa fa-list-alt" aria-hidden="true"></i>
					<span>Bookings</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('categories.list')}}">	<i class="fa fa-list-alt" aria-hidden="true"></i>
					<span>Categories</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('blogs.list')}}">	<i class="fa fa-id-card" aria-hidden="true"></i>
					<span>Blogs</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('commission.add')}}">	<i class="fa fa-percent" aria-hidden="true"></i>
					<span>Commissions</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('ratings.list')}}">	<i class="fa fa-star" aria-hidden="true"></i>
					<span>Ratings</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('cms-pages.list')}}">	<i class="fa fa-file" aria-hidden="true"></i>
					<span>CMS Pages</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('testimonial.list')}}">	<i class="fa fa-quote-left" aria-hidden="true"></i>
					<span>Testimonials</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('autoresponder.list')}}">	<i class="fas fa-envelope"></i>
					<span>Email Templates</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('smtp.list')}}">	<i class="fas fa-server"></i>
					<span>Config SMTP Details</span>
				</a>
			</li>
			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">
			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>
		</ul>
		<!-- End of Sidebar -->
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
					    <i class="fa fa-bars"></i>
					</button>
					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Nav Item - Search Dropdown (Visible Only XS) -->
						<li class="nav-item dropdown no-arrow d-sm-none">
							<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <i class="fas fa-search fa-fw"></i>
							</a>
							<!-- Dropdown - Messages -->
							<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
								<form class="form-inline mr-auto w-100 navbar-search">
									<div class="input-group">
										<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
										<div class="input-group-append">
											<button class="btn btn-primary" type="button">	<i class="fas fa-search fa-sm"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</li>
						<!-- Nav Item - Messages -->
						<div class="topbar-divider d-none d-sm-block"></div>
						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">	<span class="mr-2 d-none d-lg-inline text-gray-600 small captialize"> </span>
								@if(session()->has('userdetails'))
								    @php
									$userdata = session()->get('userdetails');
									@endphp
								    <img class="img-profile rounded-circle" src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}">
								@else
								    <img class="img-profile rounded-circle" src="{{asset('backend/images/dummyprofile.jpg')}}">
								@endif
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
							    <a class="dropdown-item text-center" href="javascript:void(0);">{{ $user->first_name.' '.$user->last_name}}<br><span style="font-size:12px;">Administrator</span></a>
								<div class="dropdown-divider"></div>
							
								@if (Auth()->user()->roles[0]->name == "User")
									<a class="dropdown-item" href="{{route('detail.update')}}">	<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile Setting</a>
								@else
									<a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">	<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile Setting</a>
								@endif
								<div class="dropdown-divider"></div>
								@if (Auth()->user()->roles[0]->name == "User")
									<a class="dropdown-item" href="{{route('change.password')}}" >	<i class="fa fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
									Change Password</a>
								@else
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#changepassModal">	<i class="fa fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
									Change Password</a>
								@endif
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
										{{ __('Logout') }}
									</a>
							</div>
						</li>
					</ul>
				</nav>
				<!-- End of Topbar -->@show @section('body') @show @section('footer')</div>
			<!-- End of Main Content -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">	<span>Copyright &copy; {{now()->year}}, {{ config('app.name', 'Unlocked') }} Admin</span>
					</div>
				</div>
			</footer>
		</div>
		<!-- End of Content Wrapper -->
	</div>
	<!-- End of Page Wrapper -->
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">	<i class="fas fa-angle-up"></i>
	</a>
	<!-- Profile Popup model -->
	<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitleDepP">Update Profile</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
					</button>
				</div>
				<form class="user" action="{{ route('details.update') }}" id="modalProfileSubmit" enctype="multipart/form-data">@csrf
					<div class="modal-body">
						<div id="successMsgP" class="hidden"></div>
						<div id="errorsDeprtP" class="hidden"></div>
						<input type="hidden" name="adminid" value="@if(Auth::user()){{ $user->id }}@endif">
						<div class="form-group">
							<input type="email" name="adminemail" id="adminemail" value="@if(Auth::user()){{ $user->email }}@endif" class="form-control form-control-user" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="text" name="first_name" id="profilename" value="@if(Auth::user()){{ $user->first_name }}@endif" class="form-control form-control-user" placeholder="First Name">
						</div>
						<div class="form-group">
							<input type="text" name="last_name" id="profilemail" value="@if(Auth::user()){{ $user->last_name }}@endif" class="form-control form-control-user" placeholder="Last Name">
						</div>
						<div class="form-group">
							<input type="file" name="profile_pic" id="profile_pic" class="form-control form-control-user">
						</div>
						<div class="form-group">@if(session()->has('userdetails'))
							<img class="img-profile rounded-circle" src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}">@endif</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="savedBtnP">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end Profile Popup model -->
	<!-- Change PassWord Model -->
	<div class="modal fade" id="changepassModal" tabindex="-1" role="dialog" aria-labelledby="changepassModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitleDepP">Change Password</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
					</button>
				</div>
				<form class="user" action="{{ route('password.update') }}" id="modalchangepassSubmit">@csrf
					<div class="modal-body">
						<div id="successMsgPass"></div>
						<div id="errorsDeprtPass"></div>
						<div class="form-group">
							<input type="password" name="oldpassword" id="oldpassword" class="form-control form-control-user" placeholder="Enter old password" required/>
						</div>
						<div class="form-group">
							<input type="password" name="newpassword" id="newpassword" class="form-control form-control-user" placeholder="Enter new password" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="savedBtnPass">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Change PassWord model -->@show
	<script>
		var baseurl = $('meta[name="baseurl"]').prop('content');
		var token = $('meta[name="csrf-token"]').prop('content');
	</script>
	<script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('backend/js/jquery.easing.min.js')}}"></script>
	<script src="{{asset('backend/js/script.js')}}"></script>
	<script src="{{asset('backend/js/sweetalert.min.js')}}"></script>
	<script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	<script src="{{asset('backend/js/custom.js')}}"></script>
	@yield('scripts')
	<style>
		table.dataTable.nowrap td {
			white-space: normal !important;
		}
	</style>
	<script src="https://cdn.tiny.cloud/1/g2adjiwgk9zbu2xzir736ppgxzuciishwhkpnplf46rni4g8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
selector: 'textarea.editor',
plugins: 'code',
toolbar: 'code',

content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
</script>
</body>

</html>