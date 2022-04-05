@extends('layouts.backend')

@section('content')


<div class="container">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">

          
          <div class="flex items-center justify-between">
            @foreach( $cats as $item )
            <a href="/admin/posts?cat_id={{ $item->id }}">
              <div class="text-base font-semibold {{ $item->id == $cat->id ? 'text-blue-400' : 'text-blue-900' }}">
                {{ $item->title }}
              </div>
            </a>
            @endforeach
          </div>

          <hr>
          @include('flash-message')


          <form class="form-inline mx-3 my-1" name="frm2" action="/admin/tags/" method="post">
            @csrf
            <input type="hidden" name="cat_id" value="{{ $cat->id }}" />
            <label class="sr-only" for="inlineFormInputName2">제목</label>
            <input type="text" name="name" class="form-control form-control-sm  mx-2" id="inlineFormInputName2" placeholder="신규 카테고리 입력">
            <button type="submit" class="btn btn-primary btn-sm ">카테고리 생성</button>
          </form>

          <hr>


          <form name="frm" action="/admin/posts" method="post" accept-charset="UTF-8" class="form-horizontal"
            enctype="multipart/form-data">
            <input type="hidden" name="cat_id" value="{{ $cat->id }}">
            @csrf

            <div class="py-0">


              
                <div class="flex-1  my-3 px-2 ">
                    <label for="label" class="control-label ">카테고리 ( 멀티선택 가능 ) </label>
                    <div class="border border-gray-700">
                    @foreach ($tags as $item )
                      <label class=" text-gray-500 font-light text-sm mx-2">
                        <input class="ml-2 leading-tight" type="checkbox" name="tags[]" value ="{{ $item->name }}">
                        <span class="text-sm">
                            {{ $item->name }}
                        </span>
                      </label>
  
                      @endforeach
                    </div>
                </div>
            </div>


            <div class="flex py-0">

{{-- 
              <div class="flex-1  my-3 px-2">
                <div class="form-group">
                  <label for="label" class="control-label">카테고리 ( 멀티선택 가능 ) </label>
                  <select multiple="multiple" name="tags[]" size="10" class="form-control">
                    @foreach ($tags as $item )
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div> --}}



              <div class="flex-1 my-3 px-3">

                <div class="form-group">
                  <label for="label" class="control-label">제목 :</label>
                  <input type="text" name="title" size=90 value="" class="border border-indigo-400">
                </div>

                <div class="form-group">
                  <label for="label" class="control-label">영상 링크입력: </label>
                  {{-- https://sendvid.com/embed/cb25p3zw --}}
                  <input type="text" name="outlink1" size=90 value="" class="border border-indigo-400">
                </div>

                <div class="form-group">
                  <label for="label" class="control-label">썸네일: </label>
                  <input type="file" name="photo" id="photo" value="">
                </div>




                {!! Form::submit( '업로드' , ['class' => 'btn btn-primary']) !!}
              </div>
            </div>
          </form>



          <table class="table table-border">
            <tr>
              <td class="w10">번호 </td>
              <td class="w40">제목</td>
              <td class="w20">카테고리</td>
              <td class="w20">작성시간</td>
              <td class="w20">관리</td>
            </tr>
            @foreach ( $posts as $post )
            <tr>
              <td>
                {{ $post->id}}
              </td>
              <td>{{ $post->title }}
              </td>
              <td>
                {{ $post->tags->implode('name', ', ')}}
              </td>
              <td>{{ $post->created_at }}
              </td>
              <td>
                <a href="{{ url('/posts/' . $post->id) }}"  target='_blank' title="글보기"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                {!! Form::open([
                    'method' => 'DELETE',
                    'url' => ['/admin/posts', $post->id],
                    'style' => 'display:inline'
                ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => '삭제',
                            'onclick'=>'return confirm("삭제 하시겠습니까?")'
                    )) !!}
                {!! Form::close() !!}
                
              </td>

            </tr>
            @endforeach

            <tr>
              <td colspan="4">
                {{ $posts->links() }}
              </td>

            </tr>

          </table>



        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $( document ).ready(function() {

  $(".table-img").css("display", "block");
  $(".table-text").css("display", "none");
  $(".table-html").css("display", "none");

  $('.select_type').on('change', function(){

    var type= $(this).val();
    if ( type =='img') {
      showImg();

    } else if( type =='text') {
      showText();

    }else if ( type =='html') {
      showHTML();
    }
  });


  function showImg(){
      $(".table-img").css("display", "block");
      $(".table-text").css("display", "none");
      $(".table-html").css("display", "none");
  }

  function showText( ){
      $(".table-img").css("display", "none");
      $(".table-text").css("display", "block");
      $(".table-html").css("display", "none");
  }
  function showHTML( ){
    $(".table-img").css("display", "none");
    $(".table-text").css("display", "none");
    $(".table-html").css("display", "block");
  }

});


</script>

@endsection