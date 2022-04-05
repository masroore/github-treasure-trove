@extends('layouts.backend')

@section('content')

@php


@endphp
    <div class="container">
    <div class="row">

        <div class="col-md-12">
            @include('flash-message')
                <div class="card">
                    <div class="card-header"> 에피소드 수정 : <span style="color:blue;font-weight:bold;">[ {{ $webtoon->title }} ] </span></div>
                    <div class="card-body">
                        <a href="{{ route('episode.index', ['webtoon_id' => $webtoon->id] ) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($webtoon, [
                            'method' => 'PATCH',
                            'url' => ['/admin/episode/', $webtoon->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}


{!! Form::label('type', '웹툰 / 포토툰 구분 ', ['class' => 'control-label']) !!}
<select required="required" name="type" class="select_type form-control">
@foreach( $type_kor as $key=>$item)
  <option value="{{ $key }}" {{ $webtoon->type == $key ? ' selected' : '' }}> {{ $item }} </option>
@endforeach
</select>



<div class="form-group{{ $errors->has('visible') ? 'has-error' : ''}}">
{!! Form::label('status', '연재 상태 분류 ', ['class' => 'control-label']) !!}
    {{ Form::select('status', $status_kor , $webtoon->status , ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'])   }}
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>



<hr>


<div class="form-group{{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', '제목', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<!-- thumb_small_path -->
<div class="form-group{{ $errors->has('photo') ? 'has-error' : ''}}">
    {!! Form::label('photo', '썸네일 ', ['class' => 'control-label']) !!}
    {!! Form::file('photo', null) !!} ( modification not required )
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>

<!-- <div class="form-group{{ $errors->has('published_at') ? 'has-error' : ''}}">
    {!! Form::label('published_at', '날짜 (예 : 2019-01-01 )', ['class' => 'control-label']) !!}
    {!! Form::text('published_at',  date('Y-m-d'), ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('site_name', '<p class="help-block">:message</p>') !!}
</div> -->

<div class="form-group{{ $errors->has('visible') ? 'has-error' : ''}}">
{!! Form::label('visible', '웹 표출 (신규 작성일시는 에피소드를 모두 입력후  Y 으로 선택 바랍니다. ) ', ['class' => 'control-label']) !!}
    {{ Form::select('visible', ['Y'=>'Yes', 'N'=>'No'], $webtoon->visible , ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'])   }}
    {!! $errors->first('visible', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
</div>


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')


@endsection
