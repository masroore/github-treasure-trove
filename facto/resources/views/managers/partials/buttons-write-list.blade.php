
<div class="p-1 mt-2 mb-8   ">
    
    @auth
    <div class="float-right mx-1 flex items-center justify-between top-menu-color text-white text-sm py-1 px-2">
        <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M11 9.27V0l6 11-4 6H7l-4-6L9 0v9.27a2 2 0 1 0 2 0zM6 18h8v2H6v-2z"/>
        </svg>
        <div class="ml-2">
            <a href="{{ route('managers.create') }}" >
                매니저 입력
            </a>
        </div>
    </div>
    @endauth
    <div class="float-right mx-1 m flex items-center justify-between bg-gray-900 text-white text-sm py-1 px-2">
        <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M0 3h20v2H0V3zm0 4h20v2H0V7zm0 4h20v2H0v-2zm0 4h20v2H0v-2z" />
        </svg>
        <div class="ml-2">
            @if( isset( $upso ) ) 
                <a href="{{ route('managers.index', ['upso_id'=> $upso->id ]) }}" >목록</a>
            @else 
                <a href="{{ route('managers.index') }}" >목록</a>
            @endif 
            
        </div>
    </div>
</div>