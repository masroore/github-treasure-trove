@extends('layouts.front')
@section('page-name', 'Artist')
@section('page-content')
    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('assets/images/bg_main.jpg') }})">
        </div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text text-white">Revolt Rap League</h1>
                        <div class="banner_product_name" style="color:rgb(225, 186, 32)">Vote for your favorite artists
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
            <!-- Single Product -->

            @php
                if (Auth::user()) {
                    $checkArtist = App\Models\Votes::where('group_id', $group)
                        ->where('stage_id', $stage->id)
                        ->where('artist_id', $artist->id)
                        ->where('email', Auth::user()->email)
                        ->first();
                }
                
                $nomination = App\Models\Nominations::where('group_id', $group)
                    ->where('artist_id', $artist->id)
                    ->where('season_id', $season->id)
                    ->where('stage_id', $stage->id)
                    ->where('status', 0)
                    ->first();
                
            @endphp
            @if (!$nomination)
                <h4 class="text-danger text-center mt-4">Sorry, artist not found!</h4>
            @else
                <div class="single_product">
                    <div class="container">
                        <div class="row">
                            <!-- Selected Image -->
                            <div class="col-lg-5 order-lg-2 order-1 d-none d-md-block">
                                <div class="image_selected"><img src="{{ !$nomination->artist->picture ? asset('assets/blank.png')  : $nomination->artist->picture}}" alt="">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-7 order-3">
                                <div class="">
                                    <div class="product_name">{{ $nomination->artist->name }}</div>
                                    <div class="product_category">Genre: {{ $nomination->artist->genre }}</div>
                                    <div class="rating_r rating_r_4 product_rating d-block d-md-none d-sm-none">
                                        <div class="image_selected"><img src="{{ !$nomination->artist->picture ? asset('assets/blank.png')  : $nomination->artist->picture}}" alt="">
                                        </div>
                                    </div>
                                    <div class="product_text">
                                        <p>{{ $nomination->artist->about }}</p>

                                        @if ($nowDate->gte($stage->start_date) && $nowDate->lte($stage->end_date))
                                            @if (Auth::user() && $checkArtist)
                                                <button class="btn btn-xs btn-danger mb-4" width="100%">Your vote
                                                    has
                                                    been
                                                    recorded!
                                                    Thank you!</button><br>
                                            @else
                                                <button class="btn btn-xs btn-danger mb-4 vote" style="cursor: pointer"
                                                    data-group="{{ $nomination->group_id }}"
                                                    data-artist="{{ $nomination->artist->id }}"
                                                    data-name="{{ $nomination->artist->name }}"
                                                    width="100%">Vote</button><br>
                                            @endif
                                        @else
                                            <p class="text-danger mt-4">Voting starts at
                                                {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->start_date))) }} and
                                                ends at
                                                {{ strtoupper(date('j M, Y h:i:a', strtotime($stage->end_date))) }}</p>
                                        @endif


                                        <a class="btn btn-xs btn-primary mb-2" style="border-radius: 20px" target="_blank"
                                            rel="noopener noreferrer" data-size="large"
                                            href="https://twitter.com/intent/tweet?text=Hi, please visit the link below and vote for me!">
                                            Tweet
                                        </a>
                                        <a class="btn btn-xs btn-primary mb-2" style="border-radius: 20px"
                                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ config('app.url') }}/artist/{{ $nomination->artist->url_hash }}"
                                            target="_blank" rel="noopener noreferrer">
                                            Share on LinkedIn
                                        </a>
                                        <a class="btn btn-xs btn-primary mb-2" style="border-radius: 20px"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ config('app.url') }}/artist/{{ $nomination->artist->url_hash }}"
                                            target="_blank" rel="noopener noreferrer">
                                            Share on Facebook
                                        </a>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

        @endif
    @endif
@endsection
