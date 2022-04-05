@extends('layouts.front')
@section('page-name', 'Profiles')
@section('page-content')
    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('assets/images/bg_main.jpg') }})">
        </div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text text-white">Vote Results</h1>
                        {{-- <div class="banner_product_name" style="color:rgb(255, 247, 216)">Vote Results
                        </div> --}}
                        <div class="button banner_button">
                            <a href="{{ config('app.url') }}/groups" style="background-color:#f8a11c; color:white">Vote
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $nowDate = Carbon\Carbon::now();
    @endphp
    {{-- if no season check --}}
    @if (!$season)
        <h4 class="text-center mt-4">Season Closed</span>
        </h4>
        <div class="banner_2_text text-center mb-4">Stay tuned for the next season! </div>
    @elseif ($nowDate->lt($season->start_date) || $nowDate->gt($season->end_date))
        <h4 class="text-center mt-4">{{ $season->name }}</h4>
        <div class="banner_2_text text-center text-danger mb-1">Starts at
            {{ strtoupper(date('j M, Y h:i:a', strtotime($season->start_date))) }} and ends at
            {{ strtoupper(date('j M, Y h:i:a', strtotime($season->end_date))) }}</div>
    @else
        {{-- check stage --}}
        @if (!$stage)
            <h4 class="text-center mt-4">Stage Closed</span>
            </h4>
            <div class="banner_2_text text-center mb-4">Stay tuned for the next stage! </div>
        @else
            <h4 class="text-center mt-4">{{ $season->name }} - <span>{{ $stage->name }}</span><br>
                <p class="text-success">
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->start_date))) }} -
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->end_date))) }}
                </p>
                {{-- <p class="text-success">{{$nowDate}}</p> --}}
            </h4>
            <div class="characteristics">
                <div class="container">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <select id="stage" class="form-control text-dark">
                                @foreach ($stages as $item)
                                    <option {{ $stage->id == $item->id ? 'selected' : '' }}
                                        value="{{ $item->url_hash }}">
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <ul class="nav nav-tabs col-12" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#modules" role="tab" data-toggle="tab">Votes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#privileges" role="tab" data-toggle="tab">Charts</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content col-12">
                            <div role="tabpanel" class="tab-pane fade in active show" id="modules">
                                <div class="row p-3">
                                    @foreach ($groups as $item)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card border-warning gutter-b card-stretch">
                                                <div class="card-header"  style="background-color:rgb(75, 71, 71);color:white">
                                                    <div class="card-label">
                                                        <div class="font-weight-bolder">{{ $item->name }}</div>
                                                        <div class="font-size-sm text-muted mt-2"></div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @php
                                                        $nominees = App\Models\Nominations::where('season_id', $season->id)
                                                            ->where('group_id', $item->id)
                                                            ->where('stage_id', $stage->id)
                                                            ->where('status', 0)
                                                            ->get();
                                                    @endphp
                                                    @if (count($nominees) < 1)
                                                        <h5 class="text-center">No Nominees listed</h5>
                                                    @else
                                                        <div class="table-responsive">
                                                            <!--begin::Table-->
                                                            <table
                                                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                                <!--begin::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody>
                                                                    @foreach ($nominees as $value)
                                                                        @php
                                                                            
                                                                            $votes = App\Models\Votes::where('artist_id', $value->artist->id)
                                                                                ->where('stage_id', $stage->id)
                                                                                ->where('season_id', $season->id)
                                                                                ->where('group_id', $item->id)
                                                                                ->where('status', 0)
                                                                                ->count();
                                                                            
                                                                            $totalVotes = App\Models\Votes::where('stage_id', $stage->id)
                                                                                ->where('season_id', $season->id)
                                                                                ->where('group_id', $item->id)
                                                                                ->where('status', 0)
                                                                                ->count();
                                                                            
                                                                            $percentage = $votes > 0 && $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;
                                                                            
                                                                        @endphp
                                                                        <tr class="@if ($value->status
                                                                            == 1) redClass @endif
                                                                            ">
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div
                                                                                        class="d-flex justify-content-start flex-column ml-2">
                                                                                        <a href="#"
                                                                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ $value->artist->name }}</a>
                                                                                        <span
                                                                                            class="fw-bold d-block fs-7"><small>{{ $value->artist->genre }}</small></span>
                                                                                    </div>
                                                                            </td>
                                                                            <td class="text-left">
                                                                                {{ number_format($votes) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Tables Widget 9-->
                                    @endforeach
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="privileges">
                                <div class="row">
                                    @foreach ($groups as $item)
                                        <div class="col-xl-4 mt-2">
                                            <!--begin::Tiles Widget 1-->
                                            <div class="card card-custom border-warning gutter-b card-stretch">
                                                <!--begin::Header-->
                                                <div class="card-header border-dark border-0"
                                                    style="background-color:rgb(75, 71, 71);color:white">
                                                    <div class="card-title">
                                                        <div class="font-weight-bolder"><b>{{ $item->name }}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body d-flex flex-column">
                                                    <!--begin::Chart-->
                                                    <div id="vote_{{ $item->url_hash }}" class="chart-shadow"
                                                        style="height:425px;">
                                                    </div>
                                                    <!--end::Chart-->

                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Tiles Widget 1-->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <script>
        let groups = @json($groups);
        let season = {!! $season->id !!}
        groups.forEach(group =>
            new Chartisan({
                el: '#vote_' + group.url_hash,
                url: `@chart('votes')?season=${season}&group=${group.id}&stage=${group.stage_id}`,
                hooks: new ChartisanHooks()
                    .tooltip({
                        enabled: true,
                        mode: 'single',
                    })
                    .colors('#f8a11c')
                    .legend({
                        position: 'bottom'
                    })
                    .datasets('bar')
            })
        );

        $('#stage').change(function() {
            var season = {!! $season->id !!};
            var stage = this.value;

            if (!Boolean(season) && !Boolean(stage)) {
                window.location.href = `{{ config('app.url') }}/dashboard`;
                return;
            }
            window.location.href = `{{ config('app.url') }}/charts/${stage}`
        })

    </script>
@endsection
