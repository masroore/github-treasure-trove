@extends('layouts.admin')

@section('title')
{{ __('admin.modules.social.title') }} | {{ __('nav.admin.modules') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.modules.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('admin.modules.social.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.modules.index') }}">{{ __('nav.admin.modules') }}</a></div>
            <div class="breadcrumb-item">{{ __('admin.modules.social.title') }}</div>
        </div>
    </div>
    <!-- Alerts -->
    {!! laraflash()->render() !!}
    <!-- Errors -->
    @include('partials.errors')
    <div class="section-body">
        <div class="row mt-sm-4">
            <div class="col-xl-12">
                <div class="card" id="social-card">
                    <div class="card-header bg-white">
                        <h4>{{ __('admin.modules.social.title') }}</h4>
                    </div>
                    <form id="social-settings" method="POST" action="{{ route('admin.modules.social.update') }}">
                        @csrf
                        <div class="card-body bg-secondary">
                            <p class="text-muted">{{ __('admin.modules.social.sub') }}</p>
                            <!-- Github Login -->
                            <div class="form-group row align-items-center">
                                <label for="github_enabled" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.github_enabled') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control" name="github_enabled" id="github_enabled" required>
                                        @if(setting()->get('github_enabled') == "true")
                                            <option value="true" selected>Enabled</option>
                                            <option value="false">Disable</option>
                                        @else
                                            <option value="false" selected>Disabled</option>
                                            <option value="true">Enable</option>
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="github_client_id" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.github_client_id') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="github_client_id" class="form-control" id="github_client_id" value="{{ Setting::get('github_client_id') }}">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="github_client_secret" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.github_client_secret') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="github_client_secret" class="form-control" id="github_client_secret" value="{{ Setting::get('github_client_secret') }}">
                                </div>
                            </div>
                            <hr>
                            <!-- Facebook Login -->
                            <div class="form-group row align-items-center">
                                <label for="facebook_enabled" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.facebook_enabled') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control" name="facebook_enabled" id="facebook_enabled" required>
                                        @if(setting()->get('facebook_enabled') == "true")
                                            <option value="true" selected>Enabled</option>
                                            <option value="false">Disable</option>
                                        @else
                                            <option value="false" selected>Disabled</option>
                                            <option value="true">Enable</option>
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="facebook_client_id" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.facebook_client_id') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="facebook_client_id" class="form-control" id="facebook_client_id" value="{{ Setting::get('facebook_client_id') }}">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="facebook_client_secret" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.facebook_client_secret') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="facebook_client_secret" class="form-control" id="facebook_client_secret" value="{{ Setting::get('facebook_client_secret') }}">
                                </div>
                            </div>
                            <hr>
                            <!-- Twitter Login -->
                            <div class="form-group row align-items-center">
                                <label for="twitter_enabled" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.twitter_enabled') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control" name="twitter_enabled" id="twitter_enabled" required>
                                        @if(setting()->get('twitter_enabled') == "true")
                                            <option value="true" selected>Enabled</option>
                                            <option value="false">Disable</option>
                                        @else
                                            <option value="false" selected>Disabled</option>
                                            <option value="true">Enable</option>
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="twitter_client_id" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.twitter_client_id') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="twitter_client_id" class="form-control" id="twitter_client_id" value="{{ Setting::get('twitter_client_id') }}">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="twitter_client_secret" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.social.twitter_client_secret') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="twitter_client_secret" class="form-control" id="twitter_client_secret" value="{{ Setting::get('twitter_client_secret') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-md-center">
                            <button class="btn btn-primary" id="save-btn-3">{{ __('admin.settings.update_setting') }}</button>
                            <a class="btn btn-warning" href="{{ URL::previous() }}">{{ __('snippets.go_back') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
