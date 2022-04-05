
<div class="p-1 mt-2 mb-8 flex items-center justify-end ">
    @auth
    <div class=" mx-1 flex bg-my-black text-white text-sm py-1 px-2">
        <div>
            <form action="{{ route('managers.destroy' ,[
                        'manager'=>$manager,
                    ] )}}" method="POST">
                <input name="_method" type="hidden" value="DELETE">
                {{ csrf_field() }}
                <div class="flex items-center">
                    <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.77 11.5l5.34 3.91c.44.33 1.24.59 1.79.59H20L6.89 6.38A3.5 3.5 0 1 0 5.5 8.37L7.73 10 5.5 11.63a3.5 3.5 0 1 0 1.38 1.99l2.9-2.12zM3.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM15.1 4.59A3.53 3.53 0 0 1 16.9 4H20l-7.5 5.5L10.45 8l4.65-3.41z"/>
                    </svg>
                    <button type="submit" class="ml-2 btn btn-primary">삭제</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class=" mx-1 flex items-center justify-between bg-my-black text-white text-sm py-1 px-2">
        <a href="{{ route('managers.edit', [
                    'manager'=>$manager
                ]) }}" class="flex items-center">
            <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
            </svg>
            <div class="ml-2">
                수정
            </div>
        </a>
    </div>

    <div class=" mx-1 flex items-center justify-between top-menu-color text-white text-sm py-1 px-2">
        <a href="{{ route('managers.create', ['upso'=> $manager->upso ]) }}" class="flex items-center" >
            <svg class="w-4 h-4 fill-current text-white " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M11 9.27V0l6 11-4 6H7l-4-6L9 0v9.27a2 2 0 1 0 2 0zM6 18h8v2H6v-2z"/>
            </svg>
            <div class="ml-2">
                작성
            </div>
        </a>
    </div>

    @endauth
</div>