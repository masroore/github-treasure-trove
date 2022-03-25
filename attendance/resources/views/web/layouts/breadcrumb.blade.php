<!-- breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.html">Home</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Admission Form</li>
			<li class="breadcrumb-item active" aria-current="page"><b class="text-info">Welcome @if(Session::has('name')) {{Session::get('name')}} @endif</b></li>
			<li><a href="{{route('admission-logout')}}" class="btn-sm btn btn-info pull-right" style="margin-right:90px;">Logout</a></li>
		</ol>
		<div class="clearfix"></div>
	</nav>
	<!-- breadcrumb -->