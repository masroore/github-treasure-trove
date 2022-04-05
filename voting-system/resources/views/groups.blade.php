@extends('layouts.front')
@section('page-name', 'Groups')
@section('page-content')
    <style>
        .vote {
            transition-property: background-color;
            transition-duration: 2s;
        }

    </style>
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
                        <div class="button banner_button"><a href="{{ config('app.url') }}/groups"
                                style="background-color:#f8a11c; color:white">Vote Now</a></div>
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
        <div class="banner_2_text text-center text-danger mb-4">Starts at
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
            @if ($nowDate->gte($stage->start_date) && $nowDate->lte($stage->end_date))
                @php
                    $groups = App\Models\Groups::where('stage_id', $stage->id)->get();
                @endphp
                @foreach ($groups as $item)
                    @php
                        if (Auth::user()) {
                            $check = App\Models\Votes::where('group_id', $item->id)
                                ->where('stage_id', $stage->id)
                                ->where('email', Auth::user()->email)
                                ->where('deleted_at', null)
                                ->first();
                        }
                        
                        $nominees = App\Models\Nominations::where('season_id', $season->id)
                            ->where('group_id', $item->id)
                            ->where('stage_id', $stage->id)
                            ->where('status', 0)
                            ->get();
                    @endphp
                    <div class="characteristics">
                        <div class="container">
                            <h4 class="text-center mb-4">{{ $item->name }} (<span>{{ count($nominees) }}
                                    Nominees)</span>
                            </h4>
                            <div class="banner_2_text text-center mb-4">
                                {{ Auth::user() && $check ? 'Your vote has been recorded!' : 'Tap on your favorite artist to vote.' }}
                            </div>
                            <div class="row">

                                @foreach ($nominees as $value)
                                    @php
                                        if (Auth::user()) {
                                            $checkArtist = App\Models\Votes::where('group_id', $item->id)
                                                ->where('stage_id', $stage->id)
                                                ->where('artist_id', $value->artist->id)
                                                ->where('email', Auth::user()->email)
                                                ->where('deleted_at', null)
                                                ->first();
                                        }
                                    @endphp
                                    <!-- Char. Item -->
                                    <div class="col-lg-3 col-md-6 char_col mb-2 artist_{{ $item->id }}_{{ $value->artist->id }}"
                                        style="cursor: pointer">
                                        <div class="char_item d-flex flex-row align-items-center justify-content-start artist_{{ $item->id }}_{{ $value->artist->id }} @if (Auth::user() && $checkArtist) voted @endif @if (Auth::user() && $check) @else vote
                                            @endif"
                                            data-group="{{ $item->id }}"
                                            data-artist="{{ $value->artist->id }}"
                                            data-name="{{ $value->artist->name }}">
                                            <div class="char_icon"><img src="{{ asset('assets/images/char_4.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="char_content">
                                                <div class="char_title">
                                                    {{-- <a  href="{{ config('app.url') }}/artist/{{ $value->artist->url_hash }}/{{$item->id}}">{{ $value->artist->name }}</a> --}}
                                                    <a href="#">{{ $value->artist->name }}</a>
                                                </div>
                                                <div class="char_subtitle">{{ $value->artist->genre }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="text-danger text-center mt-4">Voting starts at
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->start_date))) }} and ends at
                    {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->end_date))) }}</h4>
            @endif
        @endif
    @endif
@endsection
