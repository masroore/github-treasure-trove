@extends('layouts.master')


@section('content')


@include('parts.banners')

@include('parts.image-menus')

<div v-if="popupVisible" class="sm:hidden popup-mobile ">
    <div class="  bg-green-400 border border-gray-100 ">
        <a href='http://betmoa01.com/' target='_blank'><img src="/images/betmoa1-320x220.gif" width="320" height="220" /></a>
    </div>
    <div class="flex  bg-black p-2 items-center justify-between ">
        <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
            {{-- <input class="mr-2 leading-tight" type="checkbox" v-model="hour4"> 4 시간동안 안보이기 --}}
            <button class="bg-black w-full px-1 py-1 rounded-lg" @click="closePopup1()" > 4 시간동안 다시 열람하지 않습니다. </button>

        </div>
        <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
            <button class=" bg-black text-white px-2 py-1 rounded-lg " @click="closePopup()">닫기</button>
        </div>
    </div>
</div>

<div v-if="popupVisible" class="hidden sm:block popup-pc ">
    <div class="  bg-green-400 border border-gray-100 ">
        <a href='http://betmoa01.com/' target='_blank'><img src="/images/betmoa1-320x220.gif" width="320" height="220" /></a>
    </div>
    <div class="flex  bg-black p-2 items-center justify-between ">
        <div class="p-1 w-3/4 bg-gray-900 text-white text-sm  ">
            {{-- <input class="mr-2 leading-tight" type="checkbox" v-model="hour4"> 4 시간동안 안보이기 --}}
            <button class="bg-black w-full px-1 py-1 rounded-lg cursor-pointer" @click="closePopup1()" > 4 시간동안 다시 열람하지 않습니다.</button>

        </div>
        <div class=" w-1/4  bg-white p-1 bg-gray-900 text-white text-sm  text-center ">
            <button class=" bg-black text-white px-2 py-1 rounded-lg cursor-pointer" @click="closePopup()">닫기</button>
        </div>
    </div>
</div>


@endsection
