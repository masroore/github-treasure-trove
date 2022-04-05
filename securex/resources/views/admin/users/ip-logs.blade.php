@extends('layouts.admin')

@section('title')
{{ __('profile.ip_logs') }} - {{ $user->first_name }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>{!! Lang::get('admin.profile.ip_logs_user', ['user' => $user->first_name]) !!} </h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">{{ __('nav.dashboard') }}</a></div>
    <div class="breadcrumb-item active"><a href="{{ route('admin.users.show', $user) }}">{{ $user->first_name }}'s {{ __('nav.admin.profile') }}</a></div>
    <div class="breadcrumb-item">{{ __('profile.ip_logs') }}</div>
</div>
</div>
<div class="section-body">

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
                                        <td>{{ $log->ip_address }}</td>
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