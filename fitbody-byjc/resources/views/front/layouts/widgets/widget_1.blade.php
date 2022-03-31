<div class="container clearfix">
    @if($data->count() == 1)
        <div class="heading-block center bottommargin">
            <h2>{{ $data->first()->title }}</h2>
            <span>{{ $data->first()->subtitle }}</span>
        </div>
    @endif

    @if($data->count() == 3)
        <div class="row bottommargin topmargin">
            @foreach($data as $i => $item)
                <div class="col_one_third {{ $i == 2 ? 'col_last' : '' }}">
                    <div class="feature-box fbox-center fbox-plain">
<!--                        <div class="fbox-icon" data-animate="bounceIn">
                            <a href="#"><i class="icon-note"></i></a>
                        </div>-->
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->subtitle }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>