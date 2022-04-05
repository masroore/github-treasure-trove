@extends('layouts.backend')

@section('content')
@php
$status = $webtoon->status ;
$type = $webtoon->type ;


  if ( $type =='web' &&  $status =='Finished') {
    $div ='end';
  } elseif ( $type=='web' && ( $status=='Going' || $status=='Hold') ) {
    $div ='ing';
  } elseif ( $type=='photo') {
    $div ='photo';
  }

@endphp
    <div class="container">
    <div class="row">

        <div class="col-md-12">
            @include('flash-message')
                <div class="card">
                <div class="card-header">에피소드 입력 > <span style="color:blue;font-weight:bold;">[ {{ $webtoon->title }} ] </span></div>

                    <div class="card-body">
                        <a href="{{ route('episode.index', ['webtoon_id' => $webtoon->id ] ) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/admin/episodes/'. $webtoon->id , 'class' => 'form-horizontal', 'files' => true]) !!}


    {!! Form::label('round', '회차', ['class' => 'control-label']) !!}
    {!! Form::text('round', isset( $episode)  ? $episode->round : '', ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}


    {!! Form::label('title', '에피소드 제목', ['class' => 'control-label']) !!}
    {!! Form::text('title', isset( $episode)  ? $episode->title : '', ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

    {!! Form::label('published_at', '발행 일자', ['class' => 'control-label']) !!}
    {!! Form::text('published_at', isset( $episode)  ? $episode->published_at : date('Y-m-d'), ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

<div class="form-group{{ $errors->has('status') ? 'has-error' : ''}}">
{!! Form::label('status', '사용 또는 삭제 여부', ['class' => 'control-label']) !!}
    {{ Form::select('status', ['A'=>'사용', 'D'=>'삭제'], isset( $episode)  ? $episode->status : 'Y' , ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'])   }}
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

(  * 이미지는 순서대로 넣어야 합니다.)
@for($i = 0 ; $i < 30 ; $i++ )
<div class="form-group{{ $errors->has('photo[]') ? 'has-error' : ''}}">
{!! Form::label('photo[]', '이미지 ' . (int) ($i+1), ['class' => 'control-label']) !!}
{!! Form::file('photo[]', null) !!}
{!! $errors->first('photo[]', '<p class="help-block">:message</p>') !!}
<div class="form-group{{ $errors->has('photo[]') ? 'has-error' : ''}}">
@endfor



<div class="form-group">
    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
</div>


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>

$( document ).ready(function() {



});


</script>

@endsection
