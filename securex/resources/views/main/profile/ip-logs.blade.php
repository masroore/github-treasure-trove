@extends('layouts.main')

@section('title')
{{ __('profile.ip_logs_head') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('profile.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('profile.ip_logs') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('profile.index') }}">{{ __('nav.my_profile') }}</a></div>
            <div class="breadcrumb-item">{{ __('profile.ip_logs') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('snippets.hi_user', [ 'user' => Auth::user()->first_name ])}}!</h2>
        <p class="section-lead">
            {!! Lang::get('profile.ip_logs_sub', ['url1' => route('profile.index'), 'url2' => route('security.index')]) !!}
        </p>

        <div class="row mt-sm-4">
            <div class="col-xl-12">
                @include('partials.alerts')
                @include('partials.errors')
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4>{{ __('profile.ip_logs') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Logged In At</th>
                                        <th>IP Address</th>
                                        <th>Platform</th>
                                        <th>Browser</th>
                                        <th>Using</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    @foreach($logs as $log)
                                        @if($log->login_at)
                                        <?php $agent = $user->parse_agent($log->user_agent); ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>
                                                <div class="badge badge-info">{{ $log->login_at }}</div>
                                            </td>
                                            <td><a class="font-weight-bold text-decoration-none" href="http://whatismyipaddress.com/ip/{{ $log->ip_address }}" target="_blank">{{ $log->ip_address }}</a></td>
                                            <td>{{ $agent->platform() }} <small>({{ $agent->version($agent->platform()) }})</small></td>
                                            <td>{{ $agent->browser() }} <small>({{ $agent->version($agent->browser()) }})</small></td>
                                            <td>{{ $agent->device() }}</td>
                                        </tr>
                                        <?php $no++; ?>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection