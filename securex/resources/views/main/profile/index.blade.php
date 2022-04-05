@extends('layouts.main')

@section('title')
{{ __('nav.my_profile') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/modules/date-picker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modules/bootstrap-formhelpers.css') }}">
@endsection

@section('content')
@include('main.profile.partials.change-avatar')
@include('main.profile.partials.change-password')
@include('main.profile.partials.delete-profile')
@include('main.profile.partials.cancel-deletion')
<section class="section">
  <div class="section-header">
    <h1>{{ __('nav.my_profile') }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
      <div class="breadcrumb-item">{{ __('nav.my_profile') }}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{ __('nav.hi_user', ['user' => Auth::user()->first_name]) }}</h2>
    <p class="section-lead">
      {{ __('profile.sub_heading') }}
    </p>

    <div class="row mt-sm-4">
      <div class="col-xl-8 order-xl-1">
        {!! laraflash()->render() !!}
        @include('partials.errors')
        <div class="card bg-secondary shadow pull-up">
          <div class="card-header bg-white">
            <div class="col-8">
              <h4>{{ __('nav.my_profile') }}</h4>
            </div>
            <div class="col-4 text-right">
              @if($user->email_verified_at)
              <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.email_verified') }}">{{ __('snippets.verified') }}</button>
              @else
              <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.email_unverified') }}">{{ __('snippets.unverified') }}</button>
              @endif
              @if($user->is_2fa_enabled)
              <a href="{{ route('security.index') }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.2step_secured') }}">{{ __('snippets.secured') }}</a>
              @else
              <a href="{{ route('security.index') }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.2step_unsecured') }}">{{ __('snippets.unsecured') }}</a>
              @endif
            </div>
          </div>
          <div class="card-body">
            <!-- Profile Update Livewired -->
            @livewire('profile.update-profile')
          </div>
        </div>
      </div>
      <div class="col-xl-4 order-xl-2 mb-5 mt-5 mt-md-0 mb-xl-0">
        <div class="card card-profile shadow pull-up">
          <div class="row justify-content-center">
            <div class="col-lg-3">
              <div class="card-profile-image">
                <img src="{{ asset('img/users/avatar/'.auth()->user()->avatar) }}" class="rounded-circle profile-widget-picture">
              </div>
            </div>
          </div>
          <div class="card-body bg-secondary pt-0 pt-md-4">
            <div class="row mt-4 mt-md-0">
              <div class="col-12 text-left">
              <button type="button" data-toggle="modal" data-target="#change-avatar" class="btn btn-sm btn-dark">{{ __('profile.change_avatar_btn') }}
                  </button>
              </div>
            </div>
            <div class="row mt-5 pt-5 mt-md-0 pt-md-0">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                  <div>
                    <span class="heading">{{ $user->vaults()->count() }}</span>
                    <span class="description">{{ __('snippets.vaults') }}</span>
                  </div>
                  <div>
                    <span class="heading">{{ $user->total_folders() }}</span>
                    <span class="description">{{ __('snippets.folders') }}</span>
                  </div>
                  <div>
                    <span class="heading">{{ $user->total_sites() }}</span>
                    <span class="description">{{ __('snippets.sites') }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#change-password">{{ __('profile.change_pass_btn') }}</button>
              <a href="{{ route('profile.iplogs') }}" class="btn btn-dark btn-block">View IP Logs</a>
              @if($user->delete_on)
              <hr>
              <p>{!! Lang::get('profile.delete_on', ['delete' => $user->delete_on]) !!}</p>
              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#cancel-deletion">Cancel Account Deletion</button>
              @else
              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-profile">{{ __('profile.delete_account_btn') }}</button>
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/bootstrap-show-password.min.js') }}"></script>
<script src="{{ asset('assets/js/modules/bootstrap-formhelpers.js') }}"></script>
<script src="{{ asset('assets/js/modules/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/js/modules/date-picker.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#support_pin').mask('0000');
    $('.datepicker').datepicker();
    $('#support_pin').password();
  });
</script>
@endsection
