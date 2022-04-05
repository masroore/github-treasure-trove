<div class="card ">
    <div class="card-body p-5">


        <!--CATEGORIES -->
        <div class="row">
            <div class="col-12">
                <h4 class="text-ce-soir text-center">CATEGORÍAS</h4>


                <div class="section-divider bg-mandys-pink my-3"></div>

                <ul class="list-group text-grey-suit mt-3">
                    @foreach ($categories as $category)
                        <li class="list-group-item border-0">
                            <a
                                    class="nav-link text-{{$category->text_color}} border-0 bg-{{$category->color}}"
                                    href="{{route('web.getBlogByCategory',[urlencode($category->category)])}}">
                            {{$category->category}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!--END CATEGORIES -->


        <!-- RECENT POSTS -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="text-ce-soir text-center">RECIENTES</h4>


                <div class="section-divider bg-mandys-pink my-3"></div>

                <ul class="list-group text-grey-suit mt-3">
                    @foreach ($recentBlogs as $recentBlog)
                        <li class="list-group-item border-0">
                            <a href="{{route('web.getDetailBlog',[urlencode(strtolower($recentBlog->title))])}}">
                                <h5 class="text-ce-soir">
                                    <i class="fas fa-angle-double-right text-lola mr-2"></i> {{$recentBlog->title}}
                                </h5>
                                <p class="text-grey-suit">
                                    {{$recentBlog->date_to_publish->format('d F Y')}}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- END RECENT POSTS -->

        <!-- TAGS -->
        <div class="row">
            <div class="col-12 py-4">

                <h4 class="text-ce-soir text-center">ETIQUETAS</h4>
                <div class="section-divider bg-mandys-pink my-3"></div>

                @foreach ($tags as $tag)

                    <a href="{{route('web.getBlogByTag',[urlencode($tag->tag)])}}"
                       class="badge badge-ce-soir p-2  my-2 mx-1">
                        <i class="fas fa-tag"></i> {{$tag->tag}}
                    </a>

                @endforeach
            </div>
        </div>
        <!-- END TAGS -->
    </div>
</div>
