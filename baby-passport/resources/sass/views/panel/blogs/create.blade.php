@extends('layouts.panel')

@section('sectionTitle')
    <h1>BLOG</h1>

@endsection()


@section('content')
    <form id="blogForm"
          data-blog_id="{{isset($blog)?$blog->id:null}}"
          data-action="{{isset($blog)?'/blogs/'.$blog->id:'/blogs'}}"
          >

        @csrf

        <div class="container">

            <h2 class="text-center mb-3 text-ce-soir">{{isset($blog)?'EDITAR':'NUEVO'}} BLOG</h2>
            <div id="smartwizard">
                <ul>
                    <li>
                        <a href="#step-1">Información General</a>
                    </li>
                    <li>
                        <a href="#step-2">Imágenes</a>
                    </li>
                    <li>
                        <a href="#step-3">Subtemas</a>
                    </li>
                    <li>
                        <a href="#step-4">Confirmación</a>
                    </li>

                </ul>

                <div>

                    <!--STEP 1 --->
                    <div id="step-1" class="">

                        <div class="step-content-container">

                            <div class="form-group">
                                <label for="category" class="label text-ce-soir">Título de Blog</label>
                                <input type="text"
                                       class="form-control btn-full-rounded"
                                       name="blog[title]"
                                       required
                                       value="{{isset($blog)?$blog->title:''}}"
                                       data-parsley-group="general">
                            </div>

                            <div class="form-group">
                                <label for="">Categoría</label>
                                {{Form::select('blog[category_id]',$categorySelect,isset($blog)? $blog->relatedCategories[0]->category_id:null,[
                                    "class"=>"form-control selectpicker",
                                    'id'=>"categorySelect",
                                    'placeholder'=>"Seleccione una categoría",
                                    "required",
                                    "data-parsley-group"=>"general"])}}
                            </div>

                            <div class="form-group">
                                <label for="">Tags</label>
                                {{Form::select('blog_tag[]',$tagSelect,isset($blog)? $blog->relatedTags->pluck('tag_id'):null,[
                                    "class"=>"form-control selectpicker",'multiple',
                                    'id'=>"categorySelect",
                                    "data-size"=>5,
                                    "data-live-search"=>"true",
                                    "required",
                                    "data-parsley-group"=>"general"])}}
                            </div>

                            <div class="form-group">
                                <label for="category" class="label text-ce-soir">Párrafo Póster</label>
                                <textarea class="form-control btn-full-rounded"
                                          name="blog[poster_intro]"
                                          required
                                          data-parsley-group="general"
                                >{{isset($blog)? $blog->poster_intro:null}}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="category" class="label text-ce-soir">Introducción</label>
                                <textarea class="form-control btn-full-rounded froala"
                                          name="blog[intro]"
                                          required
                                          data-parsley-group="general"
                                >{!! isset($blog)? $blog->intro:null !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="category" class="label text-ce-soir">Fecha Publicación</label>
                                <input type="text"
                                       class="form-control btn-full-rounded datepicker"
                                       name="blog[date_to_publish]"
                                       value="{{isset($blog)? $blog->date_to_publish->format('Y-m-d'):null}}"
                                       required
                                       data-parsley-group="general">
                            </div>


                        </div>

                    </div>
                    <!-- END STEP 1-->


                    <!-- STEP 2 -->
                    <div id="step-2" class="">

                        <div class="step-content-container p-3">

                            <div class="form-group mb-5">
                                <label for="category" class="label text-ce-soir">Imagen Póster</label>
                                {!! Form::file('blog[poster_image]', [
                                'id'=>'',
                                 !isset($blog)? 'required':null,
                                'data-parsley-group'=>'images',
                                'data-caption'=>isset($blog)? $blog->poster_image:null,
                                'data-url'=>isset($blog)? asset('storage/blogs/'.$blog->poster_image):null]) !!}
                            </div>

                            <div class="form-group">
                                <label for="category" class="label text-ce-soir">Imagen Artículo</label>
                                {!! Form::file('blog[detail_image]', [
                                    'id'=>'',
                                    !isset($blog)? 'required':null,
                                    'data-parsley-group'=>'images',
                                    'data-caption'=>isset($blog)? $blog->detail_image:null,
                                    'data-url'=>isset($blog)? asset('storage/blogs/'.$blog->detail_image):null]) !!}
                            </div>


                        </div>

                    </div>
                    <!-- END STEP 2-->

                    <div id="step-3">

                        <div class="row mb-3">
                            <div class="col-12 text-right">
                                <button class="btn btn-ce-soir btn-full-rounded" id="addTopic" type="button">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>


                        <div class="step-content-container blog-topics">

                            @if(isset($blog))


                                @foreach($blog->topics as $topic)
                                    <div class="topic">
                                        <div class="form-group">
                                            <label>Título del subtema</label>
                                            <input type="hidden" name="blog_topic[id][]" value="{{$topic->id}}"/>
                                            <input type="text"
                                                   name="blog_topic[title][]"
                                                   required
                                                   value="{{$topic->title}}"
                                                   data-parsley-group="topics" class="form-control btn-full-rounded"/>
                                        </div>

                                        <div class="form-group">
                                            <label>Contenido</label>
                                            <textarea
                                                    class="froala form-control"
                                                    name="blog_topic[content][]"
                                                    data-parsley-group="topics"
                                                    required>{!! $topic->content !!}</textarea>
                                        </div>

                                        <div class="form-group text-center">
                                            <button
                                                    type="button"
                                                    class="btn btn-danger deleteROMTopic"
                                                    data-url="{{route('blogs.deleteTopic',[$topic->id])}}"
                                            >
                                                <i class="fas fa-trash"></i> Borrar
                                            </button>
                                        </div>
                                    </div>

                                    <hr class="my-4 border border-ce-soir">
                                @endforeach
                            @endif

                        </div>

                    </div>

                    <!--STEP 3 -->
                    <div id="step-4">
                        <div class="jumbotron text-center bg-light">
                            <h2 class="text-ce-soir"> Datos del blog capturados correctamente.</h2>
                            <p class="text-grey-suit">Si desea cambiar información regrese a los pasos
                                anteriores</p>

                            <button class="btn btn-ce-soir btn-full-rounded btn-medium">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <!--END STEP 3 -->


                </div>
            </div>


        </div>
    </form>

@endsection

@section('custom_scripts')
    <script type="text/javascript" src="{{asset(mix('js/panel/blog.js'))}}"></script>
@endsection()