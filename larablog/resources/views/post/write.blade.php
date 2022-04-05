@extends('layouts.manage')
<!-- Site title -->
@section('title' ,'Write Post')
<!-- stylesheets -->
@section('stylesheet')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
@stop
@section('content')

    <div class="col pb-5">
        <div class="write-post">
            <div>
                <h2>Write a new post here.</h2>
                <!--  Displaying The Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <!-- Displaying The Validation Errors -->
                <div>
                    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d_flex justify-between">
                            <div class="input-field">
                                <label for="title">Title</label>
                                <input type="text" name="title" placeholder="Post Title *" aria-required="true" required
                                       id="title" max="255" value="{{old('title')}}"/>
                            </div>
                            <div class="input-field">
                                <label for="category">Category</label>
                                <select name="category_id" id="category">
                                    <option value="" disabled selected>Select a Category</option>
                                    @foreach ($categories as $item)
                                        <option
                                            value="{{ $item->id }}" {{old('category_id')==$item->id  ? 'selected' : ''}}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" placeholder="Slug/url*" aria-required="true" required
                                   max="100"
                                   id="slug" value="{{old('slug')}}"/>
                        </div>
                        <!-- Tags Form Input -->
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select class="js-select-multiple form-control" name="tags[]" multiple="multiple" id="tags">
                                @forelse ($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @empty
                                    <option value="">No tag available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="input-field">
                            <label for="image">Feature Image</label>
                            <input type="file" name="post_img" id="image" value="{{old('post_img')}}">
                        </div>
                        <div class="input-field">
                            <label for="post_desc">Post body</label>
                            <textarea name="details" rows="20" placeholder="Compose your masterpiece"
                                      aria-required="true"
                                      id="post_desc" style="height: auto;">{{old('details')}}</textarea>
                        </div>

                        <p class="form-submit">
                            <input type="submit" class="submit" value="Submit your post" required/>
                        </p>
                    </form>
                </div>
                <!-- #respond -->
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script defer src="{{ asset('js/tinymce/tinymce.min.js') }}">
    </script>
    <script async src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        // Select2 int
        $(document).ready(function () {
            $('.js-select-multiple').select2();

            // TinyMCE
            tinymce.init({
                selector: 'textarea#post_desc',
                menubar: false,
                plugins: 'link code advlist lists table autosave anchor autolink emoticons media image imagetools preview print wordcount codesample',
                toolbar: 'styleselect formatting forecolor backcolor align| link image media | numlist bullist emoticons table preview print codesample code',
                codesample_languages: [
                    {text: 'HTML/XML', value: 'markup'},
                    {text: "XML", value: "xml"},
                    {text: "HTML", value: "html"},
                    {text: "SVG", value: "svg"},
                    {text: "CSS", value: "css"},
                    {text: "Javascript", value: "javascript"},
                    {text: "git", value: "git"},
                    {text: "java", value: "java"},
                    {text: "JSON", value: "json"},
                    {text: "less", value: "less"},
                    {text: "markdown", value: "markdown"},
                    {text: "PHP", value: "php"},
                    {text: "python", value: "python"},
                    {text: "sass", value: "sass"},
                    {text: "scss", value: "scss"},
                    {text: "SQL", value: "sql"},
                ],
                codesample_global_prismjs: true,
                toolbar_groups: {
                    formatting: {
                        icon: 'bold',
                        tooltip: 'Formatting',
                        items: 'bold italic underline | superscript subscript'
                    }
                },
                branding: false,
                height: 500
            });
        });
    </script>
@endsection
