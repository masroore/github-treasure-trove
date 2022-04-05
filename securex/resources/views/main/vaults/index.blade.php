@extends('layouts.main')

@section('title')
{{ __('nav.my_vaults') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/modules/bootstrap-colorpicker.min.css') }}">
@endsection

@section('content')
@include('main.vaults.partials.create')
<section class="section">
	<div class="section-header">
		<h1>{{ __('nav.my_vaults') }}</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
			<div class="breadcrumb-item">{{ __('nav.my_vaults') }}</div>
		</div>
	</div>
	<div class="section-body">
		@include('main.vaults.partials.stats')
		@include('main.partials.marked-for-deletion')
		@if($vaults->isEmpty())
		<h2 class="section-title">{{ __('vaults.no_active_vaults') }}</h2>
		@else
		<h2 class="section-title">{{ __('vaults.all_active_vaults') }}</h2>
		@endif
		{!! laraflash()->render() !!}
		<div class="row">
			<div class="col-12 col-sm-6 col-md-6 col-lg-3">
				<article class="article article-style-b">
					<button class="btn btn-icon icon-left btn-block btn-outline-primary" data-toggle="modal" data-target="#create-vault"><i class="fas fa-plus"></i> {{ __('vaults.create_new_vault') }}</button>
				</article>
			</div>
			@foreach($vaults as $vault)
			<div class="col-12 col-sm-6 col-md-6 col-lg-3">
				<div class="card card-primary pull-up" style="border-top: 2px solid {{ $vault->color }}">
					<div class="card-header">
						<h4>
							<a class="font-weight-bold" href="{{ route('vaults.select', $vault) }}" style="color: {{ $vault->color }}">
								<i class="fas fa-{{ $vault->icon }}"></i>
								{{ $vault->name }}
							</a>
							<br />
							<small class="text-gray">{{ $vault->description }}</small>
						</h4>
						<div class="card-header-action" style="width: 5%">
							@if($vault->password)
							@if(session()->has($vault->id.'-pass'))
							<a href="{{ route('vaults.select.lock', $vault) }}">
								<span class="text-success">
									<i class="fas fa-lock" data-toggle="tooltip" title data-original-title="Vault Unlocked. Click to Lock it."></i>
								</span>
							</a>
							@else
							<a href="{{ route('vaults.select', $vault) }}">
								<span class="text-danger">
									<i class="fas fa-lock" data-toggle="tooltip" title data-original-title="Vault Locked. Click to Unlock it."></i>
								</span>
							</a>
							@endif
							@else
							<a href="{{ route('vaults.select.settings.password', $vault) }}" class="text-gray">
								<span>
									<i class="fas fa-lock" data-toggle="tooltip" title data-original-title="This Vault is Not Protected. Click to Add Lock to it."></i>
								</span>
							</a>
							@endif
						</div>
					</div>
					<div class="card-footer bg-whitesmoke">
						<div class="row text-center">
							<div class="col-md-4 col-4">
								{{ $vault->sites_count }}
								<br />
								<i class="fas fa-database" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vaults.sites_in_vault') }}"></i>
							</div>
							<div class="col-md-4 col-4">
								{{ $vault->folders_count }}
								<br />
								<i class="fas fa-folder" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vaults.folders_in_vault') }}"></i>
							</div>
							<div class="col-md-4 col-4">
								{{ $vault->notes_count }}
								<br />
								<i class="fas fa-paperclip" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vaults.notes_in_vault') }}"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/bootstrap-show-password.min.js') }}"></script>
<script src="{{ asset('assets/js/modules/bootstrap-colorpicker.min.js') }}"></script>
<script>
	$(".colorpickerinput").colorpicker({
		format: 'hex',
		component: '.input-group-append',
	});
</script>
@endsection
