@foreach($reviews as $review)
    <div class="card-product__tab-reviews">
        <div class="card-product__tab-head">
            <h6>{{ optional($review->user)->name }}</h6>
            <span>{{ $review->body }}</span>
        </div>
        <div class="card-product__tab-bot">
            <div class="card-product__tab-block">
                @for($i = 1; $i < 6; $i++)
                    @if($product->reviews->avg('rating') >= $i)
                        <img src="/its-client/img/star-active.png" alt="star-{{$i}}">
                    @else
                        <img src="/its-client/img/star-off.png" alt="star-{{$i}}">
                    @endif
                @endfor
            </div>
            <div class="card-product__tab-date">
                {{ $review->created_at->format('d.m.Y') }}
            </div>
        </div>
    </div>
@endforeach