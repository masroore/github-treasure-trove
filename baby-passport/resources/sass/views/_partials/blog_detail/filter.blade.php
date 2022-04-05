<div class="card ">
    <div class="card-body p-5">

        <!-- TOPICS -->
        <div class="row">
            <div class="col-12">
                <h3 class="h3-responsive text-ce-soir text-left"> SUBTEMAS</h3>

                <div class="section-divider bg-mandys-pink my-3"></div>

                <ul class="list-group border-0 text-grey-suit">
                    @foreach ($blog->topics as $index=>$topic)
                        <li class="list-group-item border-0">
                            <a href="#topic-{{$index}}" class="text-grey-suit lead">
                                <i class="fas fa-angle-double-right text-lola mr-2"></i> {{$topic->title}}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>

        <!-- END TOPICS -->


        <!-- RELATED POSTS -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="h3-responsive text-ce-soir text-left">ARTÍCULOS RELACIONADOS</h3>
                <div class="section-divider bg-mandys-pink my-3"></div>

                <ul class="list-group">
                    @foreach ($relatedPosts as $relatedPost)
                        <li class="list-group-item border-0 text-left">
                            <a href="{{route('web.getDetailBlog',[urlencode(strtolower($relatedPost->title))])}}"
                               class="text-grey-suit lead">
                                <i class="fas fa-angle-double-right text-lola mr-2"></i> {{$relatedPost->title}}
                            </a>

                            <p class="text-lola font-weight-bold mt-2 float-right clearfix">
                                {{$relatedPost->date_to_publish->format('d F Y')}}
                            </p>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- END RELATED POSTS -->



        <!-- TAGS -->
        <div class="row mt-5">
            <div class="col-12">

                <h3 class="h3-responsive text-ce-soir text-left">ETIQUETAS</h3>
                <div class="section-divider bg-mandys-pink my-3"></div>

                @foreach ($tags as $tag)

                    <a href="{{route('web.getBlogByTag',[urlencode($tag->tag)])}}" class="badge badge-ce-soir p-2 my-2 mx-1">
                        <i class="fas fa-tag"></i> {{$tag->tag}}
                    </a>

                @endforeach
            </div>
        </div>
        <!-- END TAGS -->
    </div>
</div>
