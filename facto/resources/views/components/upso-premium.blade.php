<div>
    <div class="w-full flex flex-wrap items-center justify-between ">
        @php
            $loop_count = 0;
        @endphp
        @foreach ($premia as $banner)
            @php
                $loop_count++;
            @endphp
            <div class="w-1/2 sm:w-1/4  flex flex-center p-1 " >
                @if( Str::startsWith( $banner->link, 'http') ) 
                    <a href="{{ $banner->link }}" target='_blank' >
                        <img src="/{{ $banner->file_name }}" class=" object-cover h-full w-full rounded-lg cursor-pointer" alt="{{ $banner->title }}"/>
                        {{-- <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $banner->file_name) ) }}" class=" object-cover h-full w-full rounded-lg cursor-pointer" alt="{{ $banner->title }}"/> --}}
                    </a>
                @else 
                    <a href="{{ $banner->link }}" >
                        <img src="/{{ $banner->file_name }}" class=" object-cover h-full w-full rounded-lg cursor-pointer" alt="{{ $banner->title }}"/>
                        {{-- <img src="{{ str_replace('//', '/', Storage::disk('public')->url( $banner->file_name) ) }}" class=" object-cover h-full w-full rounded-lg cursor-pointer" alt="{{ $banner->title }}"/> --}}
                    </a>
                @endif 
            </div>
        @endforeach

        @if( $loop_count < 4 )
            @foreach (range( 1, 4 - $loop_count  ) as $xx )
                <div class="w-1/2 sm:w-1/4 flex flex-center p-1" >
                    <a class="bg-green-400 ">
                        <img src="/images/banners/upso-premium.jpg" class="h-full w-full object-cover rounded-lg cursor-pointer">
                    </a>
                </div>
            @endforeach
        @endif 
    </div>
</div>