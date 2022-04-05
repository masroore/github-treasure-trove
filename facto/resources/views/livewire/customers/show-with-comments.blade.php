<div>
    --- start 
    step :  {{  $step }} <p></p>
    {{  $old_password }}

    <div class="flex items-center justify-center">
        @if (session()->has('message'))
            <div class="text-red-500 mt-1">
                {{ session('message') }}
            </div>
        @endif
    </div>
    
    @if( $step == 1 )
        <form wire:submit.prevent='checkPassword'>
        <input 
            wire:model.lazy='password' 
            type="text" 
            class="border border-gray-500 rounded"
        >
        <button  
            type="submit" class="bg-green-500  text-white text-base">
            비밀번호 입력
        </button>

    </form>
    @elseif( $step == 2 )

    <div class="col-md-12 mt-6 ">
        <div class="w-full max-w-sm" method="post" action="/customers" accept-charset="UTF-8" class="form-horizontal">

            <div class="md:flex w-full  md:items-center mb-6 ">
                <div class=" w-full sm:w-1/3">
                    <label class="block text-gray-700 text-sm font-medium md:text-right mb-1 md:mb-0 pr-4"
                        for="inline-full-name">
                        이름
                    </label>
                </div>
                <div class="sm:w-2/3">
                    <input readonly
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" name="name" type="text" value="{{ $customer->name }}">
                </div>
            </div>
            <div class="md:flex w-full  md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                        for="inline-password">
                        비밀번호
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        readonly
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-password" name="password" type="text" value="{{ $customer->password }}"
                        >
                </div>
            </div>
            <div class="md:flex w-full  md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                        for="inline-title">
                        제목
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input readonly
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-title" name="title" type="text" value="{{ $customer->title }}">
                </div>
            </div>

            <div class="md:flex w-full  md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                        for="inline-content">
                        내용
                    </label>
                </div>
                <div class="md:w-2/3">
                    <textarea  readonly id="inline-content"
                        class="bg-gray-100 w-full h-32 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        name="content">{{ $customer->content }}
                        </textarea>
                </div>
            </div>


            <div class="md:flex w-full  md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button
                        class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-medium py-2 px-4 rounded"
                        type="button" 
                        {{-- onClick="document.location.href='/customers?ccat_id={{ $customer->ccat->id}}&page={{ $page}}'" --}}
                    >
                        확인
                    </button>
                    <form name="f1f1" action="/customers/{{ $customer->id}}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}

                        <input type="hidden" name="id" value="{{ $customer->id }}">
                        <button
                            class="shadow bg-red-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-medium py-2 px-4 rounded"
                            type="submit" >
                            삭제
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    @endif 
    {{-- Do your work, then step back. --}}

    --- end
</div>
