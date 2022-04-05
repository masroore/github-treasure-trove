@extends('layouts.app')

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('title')
    {!! SEO::generate() !!}
@endsection


@section('content')
    <section class="blog container-fluid px-0 px-xl-5 mb-5">


        <!-- BLOG DETAIL SECTION -->
        <div class="row justify-content-center px-0 px-xl-5">
            <div class="col-12 col-xl-8 text-ce-soir">

                <img src="{{asset('storage/blogs/'.$blog->detail_image)}}" alt="{{$blog->title}}"
                     class="img-fluid shadow btn-full-rounded">
                <h1 class="text-spray font-weight-bold my-4 text-uppercase text-center text-lg-left">{{$blog->title}}</h1>
                <p class="lead text-grey-suit">
                    {{$blog->date_to_publish->format('d F Y')}}

                </p>

                <div class="row">
                    <div class="col-12">

                        @foreach ($blog->tags as $tag)
                            <a href="{{route("web.getBlogByTag",[urlencode($tag->tag)])}}" class="badge badge-ce-soir p-2">
                                <i class="fas fa-tag"></i> {{$tag->tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <h3 class="mt-4">{!!$blog->poster_intro!!}</h3> 

                <div class="text-justify">
              <div class="text-grey-suit">{!!$blog->intro!!}</div>  

                <!-- BLOG DETAILS -->
                    @foreach ($blog->topics as $index => $topic)
                        <div id="topic-{{$index}}">
                            <h3 class="py-3">{{$topic->title}}</h3>
                           <div class="text-grey-suit">{!!$topic->content!!}</div> 
                        </div>
                @endforeach
                <!-- END BLOG DETAILS -->

                </div>


            </div>
            <div class="col-12 col-xl-4 d-none d-xl-block">

                <div class="sticky-top ">
                    <!-- SEARCH INPUT -->
                @include("_partials/blog/search_input")
                <!-- END SEARCH INPUT -->

                    <!-- FILTERS -->
                @include('_partials/blog_detail/filter')
                <!-- END FILTERS -->
                </div>


            </div>
        </div>

        <!-- END BLOG DETAIL SECTION -->

    </section>
@endsection()


@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $(".sticky").sticky({
                topSpacing: 90
                , zIndex: 2
                , stopper: "#YourStopperId"
            });
        });
    </script>
@endsection()


