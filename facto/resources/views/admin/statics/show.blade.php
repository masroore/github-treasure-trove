@extends('layouts.backend')

@section('content')
@php

@endphp
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
            <div class="card-header"> 에피소드 보기 : <span style="color:blue;font-weight:bold;">[ {{ $webtoon->title }} ] </span></div>
                <div class="card-body">

                    <a href="{{ route('episode.index', ['webtoon_id' => $webtoon->id ]) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />



                    {!! Form::label('round', '회차', ['class' => 'control-label']) !!}
    {!! Form::text('round', isset( $episode)  ? $episode->round : '',  ['class' => 'form-control ', 'readonly']) !!}


    {!! Form::label('title', '에피소드 제목', ['class' => 'control-label']) !!}
    {!! Form::text('title', isset( $episode)  ? $episode->title : '',  ['class' => 'form-control', 'readonly']) !!}

    {!! Form::label('published_at', '발행 일자', ['class' => 'control-label']) !!}
    {!! Form::text('published_at', isset( $episode)  ? \Carbon\Carbon::parse($episode->published_at)->format('y-m-d') : date('Y-m-d'), ['class' => 'form-control', 'readonly']) !!}

<div class="form-group{{ $errors->has('status') ? 'has-error' : ''}}">
{!! Form::label('status', '사용 중 여부', ['class' => 'control-label']) !!}
{!! Form::text('status', isset( $episode) &&  $episode->status =='A' ? '사용중' : '삭제', ['class' => 'form-control', 'readonly']) !!}
</div>

<div class="form-group">
{!! Form::label('photo', '이미지리스트 ', ['class' => 'control-label']) !!}
</div>

<table class="table">
<tr>
  <td>순서</td>
  <td>파일 경로</td>
  <td>내용</td>
</tr>
@foreach( $episode->images as $image)
<tr>
  <td> {{ $image->order_no }} </td>
  <td>{{ $image->file_path }}</td>
  <td><img src="/{{ $image->file_path }}"></td>
</tr>
@endforeach

</table>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection