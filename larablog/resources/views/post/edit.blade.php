@extends('layouts.manage')
<!-- Site title -->
@section('title' ,'Edit Post')
<!-- stylesheets -->
@section('stylesheet')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
@stop
@section('content')

    <div class="col p-0 pb-5">
        <div class="edit-post">
            <div>
                <h2>Edit an existing post.</h2>
                <div>
                    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d_flex justify-between">
                            <div class="input-field">
                                <label for="title">Title</label>
                                <input type="text" name="title" value="{{$post->title}}" aria-required="true" required
                                       id="title" max="255"/>
                            </div>
                            <div class="input-field">
                                <label for="category">Category</label>
                                <select name="category_id" id="category">
                                    <option value="" disabled>Select a Category</option>
                                    @foreach ($categories as $item)
                                        <option
                                            value="{{ $item->id }}" {{ $item->id==$post->category_id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" placeholder="Slug/url*" aria-required="true" required
                                   max="100"
                                   id="slug" value="{{$post->slug}}"/>
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
                            <input type="file" name="post_img" id="image">
                            <label for="">Current Image</label><br>
                            <img data-src="{{ asset($post->post_img) }}" class="lazyload" loading="lazy" alt="old img"
                                 width="300">
                        </div>
                        <div class=" input-field">
                            <label for="post_desc">Post body</label>
                            <textarea name="details" rows="20" id="post_desc" style="height: auto;" aria-required="true"
                                      required>{{$post->details}}</textarea>
                        </div>

                        {{-- Displaying The Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Displaying The Validation Errors --}}

                        <p class="form-submit">
                            <input type="submit" class="submit" value="Update Post" required/>
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
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        // Select2 int
        $(document).ready(function () {
            $('.js-select-multiple').select2();
            var tags = []; // declare an empty array
            @foreach ($post->tags as $tag) // loop through each tags
            tags["{{$tag->id}}"] = "{{$tag->id}}"; // convert all tag id's into an associative array
            @endforeach
            $('.js-select-multiple').select2().val(tags).trigger('change'); // Notify any JS components that the value changed


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
