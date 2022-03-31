@extends('layouts.frontend')

@section('content')

<section class="container side-menu-page-template">
    <div class="row">
        <div class="col-md-9 col-xl-8 mx-lg-auto pl-md-5 order-2  support-card-wrapper" id="accordion">
            <h1 class="d-none d-md-block page-title">Support</h1>

            @php
                $ques_index = 0;
            @endphp

            @foreach($supportCategories as $category)

                @if(count($category->questions) > 0)

                    <div class="support-block" style="padding-top:15px" id="card-{{$category->id}}" >
                        <h2 class="faq_title">{{$category->name}}</h2>                     

                        @foreach($category->questions as $question)
                            @php
                                $rand = rand(25,150);
                            @endphp

                            <div class="card border-0">
                                <div class="card-header" id="support1">
                                    <button class="btn btn-link {{($ques_index==0) ? '' : 'collapsed'}}" data-toggle="collapse" data-target="#collapse0-{{$rand}}" aria-expanded="{{($ques_index==0) ? 'true' : 'false'}}" aria-controls="collapse0-{{$question->id}}">{{$question->question}}</button>
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

        <div class="col-md-3 col-xl-2 order-1 side-menu-wrapper">
            <h2 class="side-menu-title anchor-menu-title d-md-none">Support</h2>
            <ul class="d-md-block side-menu">
                @php
                    $ques_index = 0;
                @endphp
                @foreach($supportCategories as $category)
                    <li><a href="#card-{{$category->id}}" title="{{$category->name}}" class="btn_click {{($ques_index==0) ? 'active' : ''}}">{{$category->name}}</a></li>
                    @php
                        $ques_index++;
                    @endphp
                @endforeach 
            </ul>
        </div>
       
    </div>
</section>

<script type="text/javascript">
    
  
     $(document).on('click', 'a[href^="#"]', function(e) {
        
        $(".btn_click").removeClass('active');

        $(this).addClass('active');

          // target element id
            var id = $(this).attr('href');
            
            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }
            
            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();
            
            // top position relative to the document
            var pos = $id.offset().top;
            
            // animated top scrolling
            $('body, html').animate({scrollTop: pos});
    });

</script>


@endsection