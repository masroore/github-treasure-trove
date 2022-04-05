@extends('layouts.master-customer')

@section('content')
@php
if( $ccat->id == 3 ){
$pre_content = '
안녕하세요 야동공장 입니다.

제휴문의시 카톡 / 텔레그램 yagong55 로 문의주시면 더욱 빠르게 문의가 가능합니다.

제휴 양식

1. 업소명 :


2. 업 종 :

3. 위 치 :


4. 연락처 :
연락처는 반드시 출근부에 기재된 업소 연락처로 기재 바랍니다.


5. 카카오톡 :
텔레그램 :
카카오톡 또는 텔레그램 아이디 작성을 안하시면 업소제휴 및 상담이 불가능합니다
카카오톡 또는 텔레그램 아이디는 필수!로 작성 바랍니다.


6. 연락가능시간 :


7. 제휴된 사이트 :
현재 유료로 제휴된 사이트명을 기재 바랍니다.


';

} else {
$pre_content = '';
}
@endphp

<div class="container">
    <div class="row mt-6 ">
        {{ $ccat->title }}

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <div class="text-red-500 text-base"><strong>{{ $error }}</strong></div>
                @endforeach
            </ul>
        </div>
        @endif

        <div class=" mt-6  container">
            <div class="container ">
                <form class="  " method="post" action="/customers" accept-charset="UTF-8">
                    @csrf
                    <input type="hidden" name="ccat_id" value="{{ $ccat->id }}">

                    <div class="md:flex w-full mb-6">
                        <div class=" w-full sm:w-1/6">
                            <label class=" block text-gray-500 text-sm font-medium md:text-right mb-1 md:mb-0 pr-4"
                                for="inline-full-name">
                                이름
                            </label>
                        </div>
                        <div class="sm:w-2/3 ">
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" name="name" type="text"
                                value="{{ Auth::check() && Auth::user()->isAdmin() ? Auth::user()->nick : '' }}">
                        </div>
                    </div>
                    <div class="md:flex w-full   mb-6">
                        <div class=" w-full sm:w-1/6">
                            <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                                for="inline-password">
                                비밀번호
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-password" name="password" type="password" value="" placeholder="">
                        </div>
                    </div>
                    <div class="md:flex w-full   mb-6">
                        <div class=" w-full sm:w-1/6">
                            <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                                for="inline-title">
                                제목
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-title" name="title" type="text" value="">
                        </div>
                    </div>

                    <div class="md:flex w-full  mb-6">
                        <div class=" w-full sm:w-1/6">
                            <label class="block text-gray-500 font-medium md:text-right mb-1 md:mb-0 pr-4"
                                for="inline-content">
                                내용
                            </label>
                        </div>
                        <div class="md:w-2/3 ">
                            @if( $ccat->id == 3 )
                            <textarea id="inline-content"
                                class="bg-gray-100 w-full border-2 border-gray-200 rounded py-2 px-4 text-gray-700 text-sm focus:outline-none focus:bg-white focus:border-purple-500"
                                name="content" style="height:26rem;">{!! $pre_content !!}</textarea>

                            @else
                            <textarea id="inline-content"
                                class="bg-gray-100 w-full h-48 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 text-sm focus:outline-none focus:bg-white focus:border-purple-500"
                                name="content">{!! $pre_content !!}</textarea>
                            @endif

                        </div>
                    </div>


                    <div class="md:flex w-full  ">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/3">
                            <button
                                class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-medium py-2 px-4 rounded"
                                type="submit">
                                확인
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection