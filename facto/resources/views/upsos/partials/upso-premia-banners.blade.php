<div>
    <div class="upso_p_top">
        <div class="w-full flex flex-wrap items-center justify-between ">
            @php
                $loop_count = 0;
            @endphp
            @foreach ($premia as $premium)
                @php
                    $item = $premium->upso ;
                    $loop_count++;
                @endphp
                <div class="w-1/2 sm:w-1/4 flex flex-center p-1 " >
                    <div 
                        class="ptop item2 on " 
                        style="background-image:url('{{ str_replace('//', '/', Storage::disk('public')->url($item->thumb_path) ) . '?v=' . $item->updated_at->format('mdhi') }}');height:180px;"
                    >
                    <a href="{{ route('upsos.show', ['upso'=> $item]) }}" ></a>
                    </div>
                </div>
            @endforeach

            @if( $loop_count < 4 )
                @foreach (range( 1, 4 - $loop_count  ) as $xx )
                    <div class="w-1/2 sm:w-1/4 flex flex-center p-1 " >
                        <div class="hidden sm:block ptop item4" style="height:180px;">
                            프리미엄업소
                        </div>
                    </div>
                @endforeach
            @endif 
        </div>
    </div>
</div>