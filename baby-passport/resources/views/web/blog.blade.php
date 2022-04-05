@extends('layouts.app')

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('title')
    <title>Baby Passport | Blog</title>
@endsection


@section('content')


    <section class="blog container-fluid px-0 px-xl-5">


        <!-- BLOG SECTION -->
        <div class="row mt-5">
            <div class="col-12 col-xl-8 px-5">

                <h2 class="h1-responsive font-weight-bold text-center mb-5 text-ce-soir">Publicaciones
                    recientes</h2>


                <div class="row justify-content-center justify-content-xl-start">


                    @if (!$blogs->isEmpty())



                        @foreach ($blogs as $blogIndex=>$blog)

                            <div class="row {{$blogIndex %2 != 0 ?'flex-row-reverse ':''}} py-5 border-bottom align-items-center">

                                <!-- Grid column -->
                                <div class="col-lg-5">

                                    <!-- Featured image -->
                                    <div class="view overlay rounded z-depth-2 mb-lg-0 mb-4">
                                        <img class="img-fluid" src="{{asset('storage/blogs/'.$blog->detail_image)}}"
                                             alt="Sample image">
                                        <a>
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>

                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-lg-7">

                                    <!-- Category -->
                                    <a href="#!" class="green-text">
                                        <h6 class="font-weight-bold mb-3 text-{{$blog->categories[0]->color}}">
                                            {{$blog->categories[0]->category}}
                                            <b>({{$blog->date_to_publish->format('d F Y')}})</b>

                                        </h6>
                                    </a>
                                    <!-- Post title -->
                                    <h3 class="font-weight-bold mb-3 text-grey-suit"><strong>{{$blog->title}}</strong>
                                    </h3>
                                    <!-- Excerpt -->
                                    <p class="text-justify text-ce-soir">
                                        {{$blog->poster_intro}}
                                    </p>

                                    <!-- Read more button -->
                                    <a class="btn btn-ce-soir btn-lg white-text button-border text-left"
                                       href="{{route('web.getDetailBlog',[urlencode(strtolower($blog->title))])}}">Leer
                                        más...</a>

                                </div>
                                <!-- Grid column -->


                            </div>
                            <!-- Grid row -->

                        @endforeach

                    @else

                        <h1 class="text-ce-soir text-center">No se encontraron resultados</h1>

                    @endif

                </div>

                <div class="row justify-content-center mt-5">
                    {{ $blogs->links() }}
                </div>
            </div>
            <div class="col-12 col-xl-4 d-none d-xl-block">

                <div class="sticky-top">

                    <!-- SEARCH INPUT -->
                @include("_partials/blog/search_input")
                <!-- END SEARCH INPUT -->

                    <!-- FILTERS -->
                @include('_partials/blog/filter')
                <!-- END FILTERS -->
                </div>


            </div>
        </div>

        <!-- END BLOG SECTION -->


    </section>

@endsection



@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection

