@extends('layouts.master-customer')

@section('content')

<div class="hidden sm:block sm:flex sm:items-end sm:content-end justify-between p-2 m-1 w-full">
    <div class="border-b-2 border-red-500 text-lg font-medium">
                        고객센터
    </div>
    <div class="flex-grow  border-b border-gray-400 flex justify-end items-center  text-right  align-baseline ">
        <svg class="hidden sm:block w-3 h-3 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z"></path>
        </svg>
        <span class="hidden sm:block  text-xs text-gray-700 px-2">
            홈 &gt; 고객센터 &gt; {{  $ccat->title }}
        </span>
    </div>
</div>

<div class="m-2  flex items-center justify-start">
    <a  class="p-2 text-sm {{ $ccat->id == 1 ? ' text-red-600' : '' }} " href ="{{ route('customers.index', [ 'ccat_id'=> 1] ) }}">1:1문의</a>
    <a  class="p-2 text-sm {{ $ccat->id == 2 ? ' text-red-600' : '' }} " href ="{{ route('customers.index', [ 'ccat_id'=> 2] ) }}">광고문의</a>
    <a  class="p-2 text-sm {{ $ccat->id == 3 ? ' text-red-600' : '' }} " href ="{{ route('customers.index', [ 'ccat_id'=> 3] ) }}">업소제휴문의</a>
</div>

<div class="p-2 m-2 ">
    {{ $ccat->title }}
    <table class="table-auto w-full mt-2">
        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                <a href="{{  route('customers.create', [
                    'ccat_id'=>$ccat->id,
                ])}}">
                <button 
                    {{-- wire:click="setMode('create')" --}}
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full my-2">
                    글쓰기
                </button>
                </a>
            </td>
        </tr>

        <tr>
            <td class="border p-1 m-1 text-sm w-1/12 text-center">
                번호 
            </td>
            <td class="border p-1 m-1 text-sm w-6/12 text-center">제목 </td>
            <td class="border p-1 m-1 text-sm w-2/12 text-center">이름</td>
            <td class="border p-1 m-1 text-sm w-2/12 text-center">날짜</td>
        </tr>
        @foreach( $customers as $item)
        {{-- {{ print_r($item)}} --}}
            <tr class="{{ isset( $customer) &&  $customer->id  == $item->id ? 'bg-gray-300': '' }}">
                <td class="border p-1 m-1 text-sm text-center">
                {{ $item->id  }}
                </td>
                <td class="border p-1 m-1 text-sm ">
                <div class="px-2">
                    <a href="{{ route('customers.show', [
                            'customer'=> $item->id ,
                            'page'=> $customers->currentPage(),
                        ]) }}" class="px-2 flex" >
                    <svg class="w-4 h-4 fill-current text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"/>
                    </svg>
                    
                    <div class="px-2">
                        {{ $item->title  }}
                        <span class="text-red-500 text-xs">( {{ $item->comments->count() }} )</span>
                    </div>
                    </a>
                </div>
                </td>
                <td class="border p-1 m-1 text-sm text-center">
                    {{ $item->name  }}
                </td>
                <td class="border p-1 m-1 text-sm text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('m:d H:i')  }}</td>
            </tr>
        @endforeach 

        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                {{ $customers->appends(request()->query())->links('vendor.pagination.tailwindcss') }}
            </td>
        </tr>
        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                <a href="{{  route('customers.create', [
                    'ccat_id'=>$ccat->id,
                ])}}">
                <button 
                    {{-- wire:click="setMode('create')" --}}
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full my-2">
                    글쓰기
                </button>
                </a>
            </td>
        </tr>
    </table>

</div>
@endsection