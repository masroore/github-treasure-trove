<div class="mx-1 flex items-center justify-between top-menu-color text-white text-sm py-1 px-4 cursor-pointer">

    @if( $status =='Locked')
        <div
            wire:click="setUnlock()"
            class="">
            <i class="text-white fa fa-unlock"></i>
            <span class="text-white"> 잠금해제</span>
        </div>
    @else 
        <div
            onclick="confirm('해당 포스팅을 잠그시겠습니까?') || event.stopImmediatePropagation()" 
            wire:click="setLock()" 
            class="">
            <i class="text-white fa fa-lock"></i>
            <span class="text-red-400 font-semibold" > 잠금</span>
        </div>
    @endif 
</div>
