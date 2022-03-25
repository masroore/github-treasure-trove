          



@if (session()->has('message'))
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-success"></i> Success!</h4>
	{{ session('message') }}
</div>
@endif

@if (session()->has('messagess'))
<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
	<!-- Position it -->
	<div style="position: absolute; top: 0; right: 0;">

		<!-- Then put toasts within -->
		<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<img src="..." class="rounded mr-2" alt="...">
				<strong class="mr-auto">Bootstrap</strong>
				<small class="text-muted">just now</small>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="toast-body">
				See? Just like this.
			</div>
		</div>

		<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<img src="..." class="rounded mr-2" alt="...">
				<strong class="mr-auto">Bootstrap</strong>
				<small class="text-muted">2 seconds ago</small>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="toast-body">
				{{ session('message') }}
			</div>
		</div>
	</div>
</div>
@endif

@if (session()->has('messages'))
<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i>Warning!</h4>
	{{ session('messages') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i>Warning!</h4>
	{{ session('error') }}
</div>
@endif
<div id="showmsg"></div>
<div class="alert alert-success" id="msg" style="display: none;"></div>
<div class="alert alert-danger" id="error" style="display: none;"></div>
