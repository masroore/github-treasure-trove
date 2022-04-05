@extends('layouts.admin')

@section('title')
{{ __('nav.admin.pages') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.admin.pages') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('nav.admin.pages') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('admin.pages.title') }}</h2>
        <p class="section-lead">
            {{ __('admin.pages.sub') }}
        </p>
        <!-- Alerts -->
        {!! laraflash()->render() !!}
        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.pages.index') }}">{{ __('admin.pages.all') }} <span class="badge badge-white">{{ $pages->count() }}</span></a>
                            </li>
                            <li class="nav-item ml-2">
                                <a class="nav-link" href="{{ route('admin.pages.add') }}">{{ __('admin.pages.add') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix mb-3"></div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>{{ __('admin.pages.title') }}</th>
                                    <th>{{ __('admin.pages.slug') }}</th>
                                    <th>{{ __('snippets.created_at') }}</th>
                                    <th>{{ __('snippets.updated_at') }}</th>
                                    <th>{{ __('snippets.status') }}</th>
                                </tr>
                                @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->title }}
                                        <div class="table-links">
                                            <a href="{{ url('/pages/'.$page->slug) }}" target="_blank" class="text-primary"><b>View</b></a>
                                            <div class="bullet"></div>
                                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-warning"><b>Edit</b></a>
                                            <div class="bullet"></div>
                                            <a href="javascript::void(0)" data-toggle="modal" data-target="#delete-page-{{ $page->id }}" class="text-danger"><b>Delete</b></a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ url('/pages/'.$page->slug) }}" target="_blank">{{ $page->slug }}</a>
                                    </td>
                                    <td>{{ $page->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $page->updated_at->diffForHumans() }}</td>
                                    <td class="text-capitalize">
                                        @if($page->status === 'Published')
                                        <div class="badge badge-success">{{ $page->status }}</div>
                                        @else
                                        <div class="badge badge-warning">{{ $page->status }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@foreach($pages as $page)
@include('admin.pages.partials._delete_page')
@endforeach
@endsection