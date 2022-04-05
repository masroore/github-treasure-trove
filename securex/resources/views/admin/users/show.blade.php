@extends('layouts.admin')

@section('title')
{{ $user->first_name }}'s {{ __('nav.admin.profile') }}
@endsection

@section('content')
@include('admin.users.partials.change-email')
@include('admin.users.partials.verify-pin')
@include('admin.users.partials.ban-user')
@include('admin.users.partials.revoke-ban')
@include('admin.users.partials.delete-user')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $user->first_name }}'s {{ __('nav.admin.profile') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">{{ __('nav.admin.all_users') }}</a></div>
            <div class="breadcrumb-item">{{ $user->first_name }}'s {{ __('nav.admin.profile') }}</div>
        </div>
    </div>
    <div class="section-body">

        <div class="row mt-sm-4">
            <div class="col-xl-4 mb-5">
                <div class="card card-profile shadow pull-up">
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-3">
                            <div class="card-profile-image pull-up mt-5">
                                <a>
                                    <img src="{{ asset('img/users/avatar/'.$user->avatar) }}" class="rounded-circle profile-widget-picture">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary pt-0 pt-md-4">
                        <div class="row">
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
                            <button type="button" class="btn btn-warning btn-block btn-icon" data-toggle="modal" data-target="#change-email"><i class="far fa-envelope"></i> {{ __('admin.profile.change_email') }}</button>
                            <a href="{{ route('admin.users.iplogs', $user) }}" class="btn btn-dark btn-block btn-icon"><i class="fas fa-indent"></i> {{ __('profile.view_ip_logs') }}</a>
                            <button type="button" class="btn btn-info btn-block btn-icon" data-toggle="modal" data-target="#verify-pin"><i class="fas fa-key"></i> {{ __('admin.profile.verify_pin') }}</button>
                            @if($user->id != Auth::user()->id)
                            @if($user->status === 'Banned')
                            <hr>
                            <p>{!! Lang::get('admin.profile.ban_on', ['date' => $user->remark_date, 'remark' => $user->remark]) !!}</p>
                            <button type="button" class="btn btn-success btn-block btn-icon" data-toggle="modal" data-target="#revoke-ban"><i class="fas fa-redo"></i> {{ __('admin.profile.revoke_ban') }}</button>
                            @else
                            <button type="button" class="btn btn-outline-danger btn-block btn-icon" data-toggle="modal" data-target="#ban-user"><i class="fas fa-ban"></i> {{ __('admin.profile.ban_user') }}</button>
                            @endif
                            <button type="button" class="btn btn-danger btn-block btn-icon" data-toggle="modal" data-target="#delete-user"><i class="fas fa-trash-alt"></i> {{ __('admin.profile.delete_user') }}</button>
                            @endif
                            @if($user->delete_on)
                            <hr>
                            <p>{!! Lang::get('profile.delete_on', ['delete' => $user->delete_on]) !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                {!! laraflash()->render() !!}
                @include('partials.errors')
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white">
                        <div class="col-8">
                            <h4>User Account Profile</h4>
                        </div>
                        <div class="col-4 text-right">
                            @if($user->email_verified_at)
                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.email_verified') }}">{{ __('snippets.verified') }}</button>
                            @else
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.email_unverified') }}">{{ __('snippets.unverified') }}</button>
                            @endif
                            @if($user->is_2fa_enabled)
                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.2step_secured') }}">{{ __('snippets.secured') }}</button>
                            @else
                            <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('snippets.2step_unsecured') }}">{{ __('snippets.unsecured') }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form">
                            <h6 class="heading-small text-muted mb-4">{{ __('profile.personal_info') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="first_name">{{ __('profile.firstname') }}</label>
                                            <input type="text" id="first_name" name="first_name" class="form-control form-control-alternative" value="{{ $user->first_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name">{{ __('profile.lastname') }}</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control form-control-alternative" value="{{ $user->last_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="email">{{ __('profile.email') }}
                                            </label>
                                            <input type="email" class="form-control form-control-alternative" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="country">{{ __('profile.country') }}</label>
                                            <input type="text" id="country" name="country" class="form-control form-control-alternative" value="{{ $user->country }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="phone">{{ __('profile.phone') }}
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dob">{{ __('profile.dob') }}
                                                <small class="text-muted">(DD-MM-YYYY)</small>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="dob" id="dob" value="{{ $user->dob }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Billing Information -->
                            <h6 class="heading-small text-muted mb-4">{{ __('profile.billing_info') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="address_line1">{{ __('profile.address1') }}</label>
                                            <input type="text" id="address_line1" name="address_line1" class="form-control form-control-alternative" value="{{ $user->address_line1 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="address_line2">{{ __('profile.address2') }}</label>
                                            <input type="text" id="address_line2" name="address_line2" class="form-control form-control-alternative" value="{{ $user->address_line2 }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="city">{{ __('profile.city') }}</label>
                                            <input type="text" name="city" id="city" class="form-control form-control-alternative" value="{{ $user->city }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="zipcode">{{ __('profile.zipcode') }}</label>
                                            <div class="input-group">
                                                <input type="text" name="zipcode" id="zipcode" class="form-control form-control-alternative" value="{{ $user->zipcode }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="state">{{ __('profile.state') }}</label>
                                            <input type="text" name="state" id="state" class="form-control form-control-alternative" value="{{ $user->state }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Account Information -->
                            <h6 class="heading-small text-muted mb-4">{{ __('profile.account_info') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="status">{{ __('admin.profile.created_at') }}</label>
                                            <input type="text" id="created_at" name="created_at" class="form-control form-control-alternative" value="{{ $user->created_at }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="remark">{{ __('admin.profile.updated_at') }}</label>
                                            <input type="text" id="updated_at" name="updated_at" class="form-control form-control-alternative" value="{{ $user->updated_at->diffForHumans() }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="status">{{ __('admin.profile.account_status') }}</label>
                                            <input type="text" id="status" name="status" class="form-control form-control-alternative" value="{{ $user->status }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="remark">{{ __('admin.profile.remark') }} <span data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('admin.profile.remark_info') }}"><i class="fas fa-question-circle"></i></span></label>
                                            <input type="text" id="remark" name="remark" class="form-control form-control-alternative" value="{{ $user->remark }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection