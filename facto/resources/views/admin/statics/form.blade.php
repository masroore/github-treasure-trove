
<div class="form-group{{ $errors->has('cat_id') ? 'has-error' : ''}}">
    {!! Form::label('cat_id', '분류 (분류 추가는 수정에서 가능합니다 )', ['class' => 'control-label']) !!}
    <!-- {!! Form::number('cat_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!} -->
    {{ Form::select('cat_id', $cats,  isset($cat1 ) ? $cat->id : null , ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'])   }}
    {!! $errors->first('cat_id1', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', '제목', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('img') ? 'has-error' : ''}}">
    {!! Form::label('img', '썸네일 ( 예 : https://t1.daumcdn.net/news/201903/13/yonhap/20190313091158358zcdq.jpg )', ['class' => 'control-label']) !!}
    {!! Form::text('img', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('img', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('site_name') ? 'has-error' : ''}}">
    {!! Form::label('published_at', '날짜 (예 : 2019-01-01 )', ['class' => 'control-label']) !!}
    {!! Form::text('published_at', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('site_name', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

<!-- <script>
  // var myVar = setInterval(rremove, 50);
  var cnt = 0;
  function rremove() {
    let editor = document.querySelector('#app > main > div > div > div.col-md-9 > div > div.card-body > form > div:nth-child(5) > div > div.fr-wrapper > div:nth-child(1)');
    let creator = document.querySelector('#app > main > div > div > div.col-md-9 > div > div.card-body > form > div:nth-child(4) > div > div.fr-wrapper.show-placeholder > div:nth-child(1)') ;
    let ed = editor !== null ;
    let cr = creator !== null ;
    var done = false;

    if (ed ) {
      editor.remove();
      done = true;
    }
    if ( cr){
      creator.remove();
      done = true;
    }
    if ( done || cnt > 100){
      clearInterval(myVar);
    } else {
      console.log( cnt);
    }
    cnt++;

  }
</script> -->