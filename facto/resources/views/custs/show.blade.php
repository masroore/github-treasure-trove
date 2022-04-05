@extends('layouts.master-customer')

@section('content')

<div class="container ">
    <div class="row mt-6 ">


        <div class=" flex items-end content-end justify-between p-2 m-1 w-full">
            <div class="border-b-2 border-red-500 text-lg font-medium">고객센터</div>
            <div class="flex-grow  border-b border-gray-400 flex justify-end items-center  text-right  align-baseline ">
                <svg class="hidden sm:block w-3 h-3 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z"></path>
                </svg>
                <span class="text-xs text-gray-700 px-2">
                    <a href='/'>홈 </a>&gt; 고객센터 &gt; {{  $customer->ccat->title }}
                </span>
            </div>
        </div>


        <div class=" mt-6">
            <div class="flex items-center justify-between my-4">
                <div class="text-base p-2">{{  $customer->ccat->title }}</div>
                <a href="{{ route('customers.index', ['ccat_id'=> $customer->ccat->id ]) }}" class="bg-blue-800 rounded text-sm text-white py-2 px-4">리스트 보기</a>

            </div>
            <div class="flex flex-col items-center justify-between p-2 text-sm">
                <div class="mb-4 w-full flex items-center justify-between">
                    <div class="">제목  : <span class="text-gray-700 text-sm">{{ $customer->title }}</span></div>
                    <div class="">작성일시 : <span class="text-gray-700 text-sm">{{ $customer->created_at->format('m-d H:i') }}</span></div>
                </div>

                <div class="mb-4 w-full flex items-center justify-between">
                    <div class="">작성자 : <span class="text-gray-700 text-sm">{{ $customer->name }}</span></div>
                </div>
                <div class="mb-4 w-full flex items-center justify-between">
                    <div class="">내용 : </div>
                </div>
                <div class="mb-2 w-full ">
                    <div  
                        class=" w-full border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight "
                    >
                        {!! nl2br( makeClickable( strip_tags($customer->content, '<br>'))) !!}
                    </div>
                </div>
            </div>
            @if( Auth::check() &&  Auth::user()->isAdmin())
            <div class="w-full flex items-center justify-end ">
                <form action="{{ route('customers.destroy', ['customer'=> $customer->id ]) }}" 
                    method="POST" >
                    @csrf
                    @method('delete')
                    <button 
                        type='submit'
                        class="w-40 py-2 px-4 text-base leading-none text-white bg-red-500 hover:bg-indigo-600 rounded shadow text-center">
                                해당 문의 삭제
                        </button>
                </form>
            </div>
            @endif
            
            <div class=" my-4">
                <div class="text-sm text-blue-500">댓글 리스트..</div>
                @foreach ($customer->comments as $item)
                    <div class="flex flex-col border border-gray-500 rounded-md p-2 mt-6 ">
                        <div class="flex items-center justify-between border-b border-gray-300 ">
                            <div class="text-xs flex items-center text-gray-600 ">{{ $item->name }}</div>
                            <div class="text-xs flex items-center  text-gray-600">{{ $item->created_at->format('m-d H:i') }}</div>
                        </div>
                        <div class="h-auto w-full text-sm">
                            {!! nl2br( makeClickable( strip_tags($item->content, '<br>'))) !!}
                        </div>
                    </div>
                @endforeach
            </div>
            

            <div class="flex flex-col">
                <form name="frm" action="{{ route('comments.store') }}" method="POST">
                    @csrf 
                    <input type="hidden" name="customer_id" value ="{{ $customer->id }}" />
                    <div class="aaa">
                        <textarea  
                            class="bg-gray-100 w-full overflow-y-auto  h-32 appearance-none border-2 border-orange-300 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-orange-500"
                            name="content"
                            placeholder="댓글 입력..."
                        ></textarea>

                    </div>
                    <div class="flex items-center justify-around">
                        <a href="javascript: window.history.back();"
                            class="w-24 py-2 px-4 text-sm leading-none text-white bg-gray-500 hover:bg-indigo-600 rounded shadow text-center">
                                취소
                        </a>
                        <button 
                            class="w-24 py-2 px-4 text-sm leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow text-center">
                                입력완료
                        </button>
                    </div>

                </form>

                
            </div>

            <div class="flex items-center justify-between my-4">
                <div></div>
                <a href="{{ route('customers.index', ['ccat_id'=> $customer->ccat->id ]) }}" class="bg-blue-800 rounded text-sm text-white py-2 px-4">리스트 보기</a>
            </div>

        </div>
    </div>
</div>
@endsection