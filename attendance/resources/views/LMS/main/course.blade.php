@extends('LMS.layout')


@section('title')
OSMS | LMS | Courses Registered
@endsection

@section('mtitle')
Courses Registered
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-5">

   @foreach ($data as $element => $value)
   <div class="card">
    <div class="card-header">
      <h5>{{$element}}</h5>
    </div>
    @foreach ($data[$element] as $ele => $val)

    <div class="card-header">
      <h5>{{$ele}}</h5>
    </div>

    <div class="card table-card">
      @foreach ($data[$element][$ele] as $elem => $vals)

      <div class="card-block">
        <div class="table-responsive">
          <table class="table m-b-0 without-header">
            <tbody>
              <tr>
                <td class="text-left">
                  <?php
                  if($vals['fvrt'] == '1'){
                    ?>

                    <input type="hidden" value="true" id="toggle_{{$vals['id']}}">
                    <a href="#" cid="{{$vals['id']}}" class="favrt fa fa-star">
                    </a>

                    <?php
                  }else{
                    ?>
                    <input type="hidden" id="toggle_{{$vals['id']}}">
                    <a href="#" cid="{{$vals['id']}}" class="favrt fa fa-star-o">
                    </a>
                    <?php
                  }
                  ?>
                  
                </td>
                <td>
                  <p style="text-align: left;">{{$vals['cource_title']}}</p>
                </td>
                <td class="text-right">
                  <h6 class="f-w-700">{{$vals['cource_code']}}</h6>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
      @endforeach
    </div>
    @endforeach
  </div>
  @endforeach



</div>
<div class="col-md-5" id="displayhere"></div>

</div>



@endsection


@section('style')

@endsection


@section('script')
<script>
  $(function () {

    $(document).on("click",".favrt",function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var val = $("#toggle_"+cid).val();
      var _token = $('meta[name=csrf-token]').attr('content');

      if(val.length == 0){
        $("#toggle_"+cid).val('true');
        $(this).removeClass('fa fa-star-o');
        $(this).addClass('fa fa-star');

      }else{

       $("#toggle_"+cid).val('');
       $(this).removeClass('fa fa-star');
       $(this).addClass('fa fa-star-o');
     }


    // alert($("#toggle_"+cid).val());


    // return;


     $.ajax({
      beforeSend: function(){
        $.LoadingOverlay("show");
      },
      complete: function(){
        $.LoadingOverlay("hide");
      },
      url: '{{ route('lms-my-courses-save') }}',
      type: 'POST',
      data: {_token:_token, cid: cid, val: $("#toggle_"+cid).val()},
      success: function(data){

        //$("#displayhere").html(data);
        swal("Refresh Page For Changes To Take Effect",{
               icon: 'success',
        });

      },
      error: function (data) {
        console.log('Error:', data);
        $("#msg").text(data.message).show();
      }

    }); 




   });

  });
</script>

@endsection