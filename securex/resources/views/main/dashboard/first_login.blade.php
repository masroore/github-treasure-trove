@extends('layouts.main')

@section('title')
{!! Lang::get('dashboard.kit.title', ['app' => Setting::get('app_name')]) !!}
@endsection

@section('content')
<section class="section">
	<div class="section-header">
		<h1>{!! Lang::get('dashboard.kit.title', ['app' => Setting::get('app_name')]) !!}</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="#">{!! Lang::get('dashboard.kit.created', ['user' => Auth::user()->first_name, 'date' => Auth::user()->created_at->toFormattedDateString('d-m-Y')]) !!}</a>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card card-primary">
			<div class="card-header">
				<h4>{!! Lang::get('dashboard.kit.desc', ['app' => Setting::get('app_name')]) !!}</h4>
			</div>
			<div class="card-body">
				<form>
					@csrf
					<div class="row">
						<div class="form-group col-12">
							<label for="url">{{ __('dashboard.kit.address') }}</label>
							<div class="row">
								<div class="col-md-10">
									<input type="text" id="url" name="url" class="form-control" value="{{ url('/') }}" autofocus readonly="">
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-success" name="btn" id="btn" data-clipboard-target="#url">{{ __('snippets.copy') }}</button>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="email">{{ __('dashboard.kit.email') }}</label>
						<div class="row">
							<div class="col-md-10">
								<input id="email" type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly="">
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-success" name="btn" id="btn" data-clipboard-target="#email">{{ __('snippets.copy') }}</button>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="hint">{{ __('dashboard.kit.key') }}
							<a href="javascript:;" data-toggle="popover" title="Safely Store It!" data-content="{{ __('dashboard.kit.key_info') }}" data-trigger="focus"><i class="fas fa-question-circle"></i></a>
						</label>
						<div class="row">
							<div class="col-md-10">
								<input type="text" id="access_key" name="access_key" class="form-control" value="{{ decrypt(Auth::user()->access_key) }}" readonly="">
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-success" name="btn" id="btn" data-clipboard-target="#access_key">{{ __('snippets.copy') }}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="alert alert-danger alert-has-icon">
			<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			<div class="alert-body">
				<div class="alert-title">{{ __('snippets.warning') }}!!!</div>
				{{ __('dashboard.kit.warning') }}
			</div>
		</div>
	</div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/clipboard.min.js') }}"></script>
<script type="text/javascript">
	// Clipboard
	var clipboard = new ClipboardJS('.btn');

	$(document).ready(function() {
		clipboard.on('success', function(e) {
			$(e.trigger).text("Copied!");
			e.clearSelection();
			setTimeout(function() {
				$(e.trigger).text("Copy");
			}, 2500);
		});

		clipboard.on('error', function(e) {
			$(e.trigger).text("Can't in Safari");
			setTimeout(function() {
				$(e.trigger).text("Copy");
			}, 2500);
		});

	});
</script>
@endsection