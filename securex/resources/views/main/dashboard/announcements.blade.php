@extends('layouts.main')

@section('title')
{{ __('dashboard.announcements.title') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('dashboard.announcements.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('dashboard.announcements.title') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('snippets.hi_user', [ 'user' => Auth::user()->first_name ])}}!</h2>
        <p class="section-lead">
            {{ __('dashboard.announcements.sub') }}
        </p>

        <div class="row mt-sm-4">
            <div class="col-xl-12">
                @include('partials.alerts')
                @include('partials.errors')
                <div class="card">
                    <div class="card-header bg-secondary">
                        <div class="col-8">
                            <h4>{{ __('dashboard.announcements.title') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(! $announcements->count())
                            <p>No Announcements Available</p>
                            @else
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Announcement</th>
                                        <th>Date</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    @foreach($announcements as $announcement)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $announcement->body }}
                                        <td>
                                            <button class="btn btn-dark btn-icon icon-left">
                                                <i class="fas fa-clock"></i> {{ $announcement->created_at->diffForHumans() }}
                                            </button>
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