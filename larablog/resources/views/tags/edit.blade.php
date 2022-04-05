@extends('layouts.manage')
@section('title' ,'Tags')

@section('content')

    <div class="col">
        <div class="row write-tag">
            <div class="post-comments col-12">
                <h2 class="comments-title">Update an existing tag here.</h2>
                <div class="comment-respond">
                    <form action="{{ route('tag.update',$tag->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="d_flex">
                            <div class="input-field" style="width:100%">
                                <input type="text" name="name" value="{{ $tag->name }}" aria-required="true"/>
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
                            <input type="submit" class="submit" value="Update Tag" required/>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
