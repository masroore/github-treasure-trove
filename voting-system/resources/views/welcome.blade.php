@extends('layouts.front')
@section('page-name', 'Home')
@section('page-content')
    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('assets/images/bg_main.jpg') }})">
        </div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text text-white">Revolt Rap League</h1>
                        <div class="banner_product_name" style="color:rgb(255, 247, 216)">Vote for your favorite artists
                        </div>
                        <div class="button banner_button">
                            <a href="{{ config('app.url') }}/groups" style="background-color:#f8a11c; color:white">Vote
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Characteristics -->

    <div class="characteristics">
        <div class="container">
            @php
                $nowDate = Carbon\Carbon::now();
            @endphp
            {{-- if no season check --}}
            @if (!$season)
                <h4 class="text-center mb-4">Season Closed</span>
                </h4>
                <div class="banner_2_text text-center mb-4">Stay tuned for the next season! </div>
            @elseif ($nowDate->lt($season->start_date) || $nowDate->gt($season->end_date))
            <h4 class="text-center mt-4">{{$season->name}}</h4>
                <div class="banner_2_text text-center text-danger mb-4">Starts at
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($season->start_date))) }} and ends at
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($season->end_date))) }}</div>
            @else
                {{-- check stage --}}
                @if (!$stage)
                    <h4 class="text-center mb-4">Stage Closed</span>
                    </h4>
                    <div class="banner_2_text text-center mb-4">Stay tuned for the next stage! </div>
                @else
                    <h4 class="text-center mb-4">{{ $season->name }} - <span>{{ $stage->name }}</span><br>
                        <p class="text-success">
                            {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->start_date))) }} -
                            {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->end_date))) }}
                        </p>
                        {{-- <p class="text-success">{{$nowDate}}</p> --}}
                    </h4>
                    <div class="banner_2_text text-center mb-4">The company is dedicated to producing, recording, promoting,
                        branding and the releasing of some of the most talented artists around the world.</div>

                    @if ($nowDate->gte($stage->start_date) && $nowDate->lte($stage->end_date))
                        @php
                            $groups = App\Models\Groups::with('nominees')
                                ->where('stage_id', $stage->id)
                                ->get();
                        @endphp
                        <div class="row">
                            @foreach ($groups as $item)
                                <!-- Char. Item -->
                                <div class="col-lg-3 col-md-6 char_col mb-2"
                                    style="cursor: pointer">
                                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                                        <div class="char_icon"><a href="{{ config('app.url') }}/group/{{ $item->url_hash }}">
                                            <img src="{{ asset('assets/images/char_4.png') }}"
                                                alt=""></a>
                                        </div>
                                        <div class="char_content">
                                            <div class="char_title">
                                                <a href="{{ config('app.url') }}/group/{{ $item->url_hash }}">{{ $item->name }}</a>
                                            </div>
                                            <div class="char_subtitle">{{ count($item->nominees) }} Artists</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h4 class="text-danger text-center mt-4">Voting starts at
                            {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->start_date))) }} and ends at
                            {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->end_date))) }}</h4>
                    @endif
                @endif
                {{-- end check stage --}}
            @endif
            {{-- end check season --}}
        </div>
    </div>

@endsection
