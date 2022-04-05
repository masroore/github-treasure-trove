@extends('layouts.manage')
@section('title' ,'Edit Category')

@section('content')

    <div class="col p-0">
        <div class="write-post">
            <div class="post-comments">
                <h2 class="comments-title">Edit an existing category.</h2>
                <div class="comment-respond">
                    <form action="{{ route('category.update',$category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="d_flex justify-between">
                            <div class="input-field">
                                <label for="">Category Name</label>
                                <input type="text" name="name" value="{{ $category->name }}" aria-required="true"
                                       id="title"/>
                            </div>
                            <div class="input-field">
                                <label for="">Category Slug</label>
                                <input type="text" name="slug" value="{{ $category->slug }}" aria-required="true"
                                       id="slug"/>
                            </div>
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
                            <input type="submit" class="submit" value="Update Category" required/>
                        </p>
                    </form>
                </div>
                <!-- #respond -->
            </div>
        </div>
    </div>
@endsection
