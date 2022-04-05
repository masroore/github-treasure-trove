<div class="col-12 col-lg-6 col-xl-4 mt-3">

    <!-- Card -->
    <div class="card card-image"
         style="background-image: url({{asset('storage/sad/'.$ad->image)}}); background-position: center; background-size: cover;">

        <!-- Content -->
        <div class="d-flex rgba-pink-strong align-items-center text-white p-5">
            <div>
                <h1 class="h1-responsive text-left mb-3 text-shadow"><strong>{{$ad->title}}</strong></h1>
                <p class="text-justify text-shadow lead">{{$ad->content}}></p>


                <a class="btn btn-ce-soir btn-lg white-text float-right" href="{{$ad->url}}" target="_blank">
                    <i class="fas fa-clone left"></i> Conoce más
                </a>
            </div>
        </div>

    </div>
    <!-- Card -->
</div>


