    <div class="row  justify-content-center mt-3">
    <div class="col-12">
            <ul class="nav nav-pills flex-column flex-lg-row justify-content-center categories">
                @foreach ($categories as $category)
                    <li class="nav-item mt-3 mt-lg-0">
                        <a
                            class="nav-link text-{{$category->text_color}} border-0 bg-{{$category->color}}"
                            href="{{route('web.getBlogByCategory',[urlencode($category->category)])}}"">
                            {{$category->category}}
                        </a>
                    </li>
                @endforeach
            </ul>
    </div>
</div>
