<div class="mt-2 ml-0 flex flex-wrap items-center  justify-start ">
    @foreach( $banners as $banner)
    @if( $banner->division == 2 )
    @php
    $v = \Carbon\Carbon::parse( $banner->updated_at )->format('mdHi');
    @endphp
    <a href="/click?id={{$banner->id}}&url={{$banner->link}}" class="w-full mb-1 pr-1 " target='_blank'>
        <img class="w-full object-fill" src="/{{ $banner->file_name }}?v={{ $v }}"
            @click="openWin('{{ $banner->link }}')">
    </a>
    @endif
    @endforeach
</div>