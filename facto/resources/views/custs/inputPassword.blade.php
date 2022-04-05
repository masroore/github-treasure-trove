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
            홈 &gt; 고객센터 &gt; {{  $customer->ccat->title }}
        </span>
    </div>
</div>

<div class="m-2  flex items-center justify-start">
    <a  class="p-2 text-sm {{ $ccat->id == 1 ? ' text-red-600' : '' }} " href ="{{ route('customers.index', [ 'ccat_id'=> 1] ) }}">1:1문의</a>
    <a  class="p-2 text-sm {{ $ccat->id == 2 ? ' text-red-600' : '' }} " href ="{{ route('customers.index', [ 'ccat_id'=> 2] ) }}">광고문의</a>
</div>

<div class="p-2 m-2 ">
    {{ $ccat->title }}

    @livewire('cust-component', [
        'customerid'=> $customer->id,
        'page'=>$page,
        ])
</div>
@endsection