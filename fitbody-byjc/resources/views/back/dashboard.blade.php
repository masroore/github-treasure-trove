@extends('back.layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <h2 class="content-heading">Nadzorna Ploča
            <small>
                @if (auth()->user()->email == 'filip@agmedia.hr' || auth()->user()->email == 'tomislav@agmedia.hr')
                    <span class="float-right">
                        <a href="{{ route('dashboard.test') }}" class="btn btn-square btn-outline-secondary">Test</a>
                        <a href="{{ route('dashboard.test2') }}" class="btn btn-square btn-outline-secondary">Test 2</a>
                        <a href="{{ route('dashboard.test3') }}" class="btn btn-square btn-outline-secondary">Mock Message Sent</a>
                    </span>
                @endif
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="row gutters-tiny invisible" data-toggle="appear">
            @foreach ($stats as $stat)
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-shadow text-left" href="{{ $stat['url'] }}">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-right mt-10">
                                <i class="si si-{{ $stat['icon'] }} fa-3x text-{{ $stat['icon_color'] }}"></i>
                            </div>
                            <div class="font-size-h3 font-w600">{{ $stat['value'] }}</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">{{ $stat['title'] }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row gutters-tiny invisible" data-toggle="appear">
            <div class="col-md-7">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Zadnje Novosti</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-center">
                        <ul class="list-group push">
                            @foreach ($news as $page)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('page.edit', ['id' => $page->id]) }}">{{ \Illuminate\Support\Str::limit($page->name, 100) }}</a>
                                    <span class="badge badge-pill badge-info">{{ \Carbon\Carbon::make($page->created_at)->locale('hr')->format('d.m.Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Najviše Klikova</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-center">
                        <ul class="list-group push">
                            @foreach ($clicks as $page)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('page.edit', ['id' => $page->id]) }}">{{ \Illuminate\Support\Str::limit($page->name, 40) }}...</a>
                                    <span class="badge badge-pill badge-info">{{ $page->viewed }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END Page Content -->
@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/components/ag-bar-horizontal-chart.js') }}"></script>
    {{--<script src="{{ asset('js/components/ag-stats-total.js') }}"></script>
    <script src="{{ asset('js/components/ag-pie-chart.js') }}"></script>--}}

    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

    <script>
        $(() => {
            $('#order-list-canvas').slimScroll({
                height: '300px'
            });
            $('#users-list-canvas').slimScroll({
                height: '376px'
            });
        })
    </script>
@endpush
