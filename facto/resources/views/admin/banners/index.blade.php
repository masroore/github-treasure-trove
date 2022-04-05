@extends('layouts.backend')

@section('content')
<div class="container">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="flex">
            @foreach( $divisions as $key=> $item )
            @if( $key <= 4 )
            <div class="px-3 cursor-pointer ">
              <a href="/admin/banners?division={{ $key}}">
                <span class="{{ $division == $key ? 'text-red-600 font-semibold' :'' }} ">{{ $item['title']}} </span>
              </a>
            </div>

            <div class="">|</div>
            @endif
            @endforeach
          </div>


          <div class="flex">
            @foreach( $divisions as $key=> $item )
            @if( $key > 4 )
            <div class="px-3 cursor-pointer ">
              <a href="/admin/banners?division={{ $key}}">
                <span class="{{ $division == $key ? 'text-red-600 font-semibold' :'' }} ">{{ $item['title']}} </span>
              </a>
            </div>

            <div class="">|</div>
            @endif
            @endforeach
          </div>

        </div>
        <div class="card-body">
        * {{ $divisions[ $division ]['title']}} 사이즈 ( {{ $divisions[ $division ]['range'] }} ): {{ $divisions[ $division ]['size'] }} <br />

          @include('flash-message')

          <form name="frm" action="/admin/banners" method="post" accept-charset="UTF-8" class="form-horizontal"
            enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="division" value="{{ $division }}">
            <input type="hidden" name="type" value="img">
            <input type="hidden" name="status" value="A">


            <div class="form-group">
              <table class="table table-sm mt-2">
                <tr>
                  <td>
                  </td>
                </tr>
                <tr class="mt-2">
                  <td> 1. 배너 선택 </td>
                  <td>
                    <select name="id" style="width:120px;">
                      @foreach( $banners_admin as $banner )
                      <option value="{{ $banner->id}}"> {{ $banner->id}} </option>

                      @endforeach
                    </select> 번 배너
                  </td>
                </tr>
                <tr>
                  <td>
                    2. 배너제목 입력 </td>
                  <td>
                    <input type="text" name="title" size=30 value="" class="border">
                  </td>
                </tr>
                <tr>
                  <td>
                    3. 클릭링크 입력 </td>
                  <td> <input type="text" size=30 name="link" value="" class="border">
                  </td>
                </tr>
                <tr>
                  <td>
                    4. 배너 이미지 선택 </td>
                  <td><input type="file" name="photo" id="photo" value="">
                  </td>
                </tr>
                <tr>
                  <td conspan=2>
                    {!! Form::submit( '배너 교체 확인' , ['class' => 'btn btn-primary btn-sm']) !!}
                  </td>
                </tr>

              </table>

            </div>
          </form>
          </li>


          </ul>
          <table class="table table-border">
            <tr>
              <td class="w10">번호 </td>
              <td class="w20">배너제목</td>
              <td class="w10">표출</td>
              <td class="w30">클릭링크</td>
              <td class="w30">내용</td>
            </tr>
            @foreach ( $banners_admin as $banner )
            <tr>
              <td>
                {{ $banner->id}}
              </td>
              <td>{{ $banner->title }}
              </td>
              <td>

                <form name=frmStatus{{ $banner->id}} action="{{ route('admin.banners.status', ['id'=>$banner->id] ) }}"
                  method=POST>
                  @csrf
                  {{  Form::hidden('url', Request::fullUrl() ) }}
                  <input type=hidden name="id" value="{{ $banner->id }}">
                  <select name="status" onchange="this.form.submit()">
                    <option value="A" {{ $banner->status =='A' ? ' selected' : '' }}>표출</option>
                    <option value="D" {{ $banner->status !='A' ? ' selected' : '' }}>숨김</option>
                  </select>

                </form>
              </td>

              <td>{{ $banner->link }}
              </td>
              <td>
                @if ( $banner->type =='img')
                <img src="/{!! $banner->file_name !!}?v={{ time() }}" style="max-width:400px;" />
                @else
                {!! $banner->file_name !!}
                @endif
              </td>

            </tr>
            @endforeach

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