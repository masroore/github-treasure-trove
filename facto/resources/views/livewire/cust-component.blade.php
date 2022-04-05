<div>
    <style>
        .space-y-2 > * + *	
        {   
            margin-top: 0.5rem;
        }

        .space-y-4 > * + *	
        {   
            margin-top: 1rem;
        }

        .space-x-4 > * + *	
        {   
            margin-left: 1rem;
        }

        .space-x-6 > * + *	
        {   
            margin-left: 1.5rem;
        }


    </style>
    <div class="space-y-4 mt-6">
        <div>제목 : {{  $title  }}</div>
        <div class="text-red-500 font-normal"> 글 작성시 입력했던 비밀번호가 필요합니다. </div>
        <form wire:submit.prevent="checkPassword">
            @if( $message )
                <span class="error text-red-600 font-bold ">{{ $message }}</span> 
            @endif
            <div class="flex items-center justify-start space-y-2 space-x-6 text-base">
                <input 
                    wire:model="password"
                    type="text" class="border border-gray-600 p-2 "
                />
                <button type="submit" class="p-2 bg-red-600  text-white  text-sm rounded">확인</button>
            </div>
        </form>
    </div>
    {{-- Care about people's approval and you will be their prisoner. --}}
</div>
