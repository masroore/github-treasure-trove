<div class="col-12 col-sm-10 col-md-6  col-xl-4 mt-3 blog-item">

    <div class="row mx-1  align-items-center">

        <!-- CITY IMAGE -->
        <div class="col-5 p-0">
            <img class="img img-fluid shadow rounded"
                 src="{{asset('storage/blogs/'.$blog->poster_image)}}"
                 alt="{{$blog->title}}">
            <a href="#!">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>

        <!-- END CITY IMAGE -->


        <!-- CITY CONTENT -->
        <div class="col-7 p-4">


            <h5 class="h5-responsive card-title text-ce-soir mb-0">{{$blog->title}}</h5>

            <p class="card-text text-grey-suit">
                {{$blog->date_to_publish->format('d F Y')}}
            </p>


            <a href="{{route('web.getDetailBlog',[rawurlencode($blog->title)])}}"
               class="btn btn-ce-soir btn-md white-text float-right button-border">
                <i class="fas fa-arrow-right"></i> Leer más
            </a>

        </div>

        <!-- END CITY CONTENT -->
    </div>
</div>
