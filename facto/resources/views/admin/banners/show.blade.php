@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> {{ $cat->cat_name}} > 보기 </div>
                <div class="card-body">

                    <a href="{{ url('/admin/posts') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}" title="Edit Post"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    {!! Form::open([
                    'method'=>'DELETE',
                    'url' => ['admin/posts', $post->id],
                    'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-sm',
                    'title' => 'Delete Post',
                    'onclick'=>'return confirm("Confirm delete?")'
                    ))!!}
                    {!! Form::close() !!}
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th class="tdcat"> ID </th>
                                    <td>{{ $post->id }}</td>
                                </tr>
                                <tr>
                                    <th> 분류 </th>
                                    <td> {{ $post->cat->cat_name }} </td>
                                </tr>
                                <tr>
                                    <th>작성자 </th>
                                    <td>{{ $post->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th> 제목 </th>
                                    <td> {{ $post->title }} </td>
                                </tr>
                                <tr>
                                    <th> 내용 </th>
                                    <td> {!! $post->content !!} </td>
                                </tr>
                                <tr>
                                    <th> 썸네일 </th>
                                    <td><img  class="thumbnail" src="{{ $post->img }}" ></td>
                                </tr>

                                <tr>
                                    <th> 사이트이름 </th>
                                    <td>
                                    {{ $post->site_name }}

                                    </td>
                                </tr>
                                <tr>
                                    <th> 사이트 주소 </th>
                                    <td>{{ $post->site_url }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection