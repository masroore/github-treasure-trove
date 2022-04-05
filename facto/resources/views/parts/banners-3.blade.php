<div class="mt-2  flex flex-wrap items-center  justify-start ">
    @foreach( $banners as $banner)
    @if( $banner->division == 3 )

    @php
    $v = \Carbon\Carbon::parse( $banner->updated_at )->format('mdHi');
    @endphp

    <a href="/click?id={{$banner->id}}&url={{$banner->link}}" class="w-1/4 mb-1 pr-1 " target='_blank'>
        <img class="object-cover" src="/{{ $banner->file_name }}?v={{ $v }}" >
    </a>
    @endif
    @endforeach
</div>