@extends('layouts.main')

@section('title')
{{ __('profile.notifications') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('profile.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('profile.notifications') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('profile.index') }}">{{ __('nav.my_profile') }}</a></div>
            <div class="breadcrumb-item">{{ __('profile.notifications') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('snippets.hi_user', [ 'user' => Auth::user()->first_name ])}}!</h2>
        <p class="section-lead">
            {{ __('profile.notifications_sub') }}
        </p>

        <div class="row mt-sm-4">
            <div class="col-xl-12">
                {!! laraflash()->render() !!}
                <div class="card">
                    <div class="card-header bg-secondary">
                        <div class="col-8">
                            <h4>{{ __('profile.notifications') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('profile.notifications.mark') }}" class="btn btn-primary btn-icon icon-left text-white">
                                <i class="fas fa-eye-slash"></i> {{ __('profile.mark_read') }}
                            </a>
                            <a href="{{ route('profile.notifications.delete') }}" class="btn btn-danger btn-icon icon-left text-white">
                                <i class="fas fa-trash-alt"></i> {{ __('profile.notifications_clear') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(! auth()->user()->notifications->count())
                            <p>No Notifications Available</p>
                            @else
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Notification</th>
                                        <th>Date</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    @foreach($notifications as $notification)
                                    <tr class="@if(! $notification->read_at) bg-secondary @endif">
                                        <td>{{ $no }}</td>
                                        <td>{{ $notification->data['message'] }}
                                        <td>
                                            <button class="btn btn-dark btn-icon icon-left">
                                                <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ $notification->data['url']. '?read=' .$notification->id }}" class="btn btn-primary btn-icon icon-left text-white">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection