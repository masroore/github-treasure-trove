@extends('layouts.frontend')

@section('content')

<section class="container side-menu-page-template">
    <div class="row">
        <div class="col-md-9 col-xl-8 mx-lg-auto pl-md-5 order-2  support-card-wrapper" id="accordion">
            <h1 class="d-none d-md-block page-title">FAQ</h1>
            @php
                $ques_index = 0;
            @endphp

            @foreach($faqCategories as $category)

                @if(count($category->questions) > 0)

                    <div class="support-block" style="padding-top:15px" id="card-{{$category->name}}" >
                        <h2 class="faq_title">{{$category->name}}</h2>
                     

                        @foreach($category->questions as $question)
                            @php
                                $rand = rand(25,150);
                            @endphp

                            <div class="card border-0">
                                <div class="card-header" id="support1">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse0-{{$rand}}" aria-expanded="{{($ques_index==0) ? 'true' : 'false'}}" aria-controls="collapse0-{{$question->id}}">{{$question->question}}</button>
                                </div>
                                <div id="collapse0-{{$rand}}" class="collapse {{($ques_index==0) ? 'show' : ''}}" aria-labelledby="support1" data-parent="#accordion" style="">
                                    <div class="card-body">{!!$question->answer!!}</div>
                                </div>
                            </div>   

                                @php
                                    $ques_index++;
                                @endphp

                        @endforeach                 
                    </div>
                @endif

                

            @endforeach

        </div>

         @include('includes.cms_links')    
        
    </div>
</section>

@endsection