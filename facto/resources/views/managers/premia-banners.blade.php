<div>
    @php
        if( session('size') =='wide') {
            $hh = '180';
        } elseif( session('size') == 'mobile') {
            $hh = '137';
        }
    
    @endphp
    <div class="upso_p_top">
        <div class="w-full grid grid-cols-2 sm:grid-cols-4 gap-0 sm:gap-1  ">
            @foreach ($premia as $item)
            
                @if( strlen( $item->file_name) >3 && $item->status =='A') 

                    @php
                        if( Str::startsWith( $item->link, 'http') ){
                            $target = " target = '_blank' " ;
                        }else {
                            $target = "";
                        }
                        $vdate= Carbon\Carbon::parse( $item->updated_at)->format('mdhi');
                    @endphp
                    
                    <div class="flex flex-center " >
                        <div 
                            class="ptop item2 on bg-green-300 w-1/2 sm:w-1/4" 
                            {{-- style="background-image:url('{{ $image_server . '/' . $item->file_name . '?v=' . $vdate }}');height:{{ $hh }}px;" --}}
                        >
                            <a href="{{ $item->link }}" {{ $target }} ></a>
                        </div>
                    </div>

                @else 
                    <div class="flex flex-center " >
                        <div 
                            class="ptop item4 " 
                        >
                            프리미엄업소
                        </div>
                    </div>

                @endif 
                
            @endforeach
    
            <div class="clearfix"></div>
        </div>
    </div>
</div>