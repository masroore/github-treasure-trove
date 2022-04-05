<div>
    <div class=" sm:hidden ">
        <div class="flex ml-2">
            <div class="border-b-2 border-teal-600 my-1 pb-1 font-semibold ">
                {{ $menu }} > {{ $mode }}
            </div>
            <div class=" flex-grow border-b border-gray-400 my-1 pb-1 font-semibold "> </div>
        </div>
    </div>
        
    <div class="hidden sm:block sm:flex sm:items-end sm:content-end justify-between p-2 m-1 w-full">
        <div class="border-b-2 border-red-500 text-lg font-medium">
            {{ $menu }} > {{ $mode }}
        </div>
        <div class="flex-grow  border-b border-gray-400 flex justify-end items-center  text-right  align-baseline ">
            <svg class="hidden sm:block w-3 h-3 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z" />
            </svg>
            <span class="hidden sm:block  text-xs text-gray-700 px-2">
                홈 > {{ $menu }} > {{ $mode }}
            </span>
        </div>
    </div>

    
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
</div>