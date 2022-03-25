@extends('layouts.main')


@section('title')
OSMS | Add Academic Year
@endsection

@section('mtitle')
OSMS Academic Year
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Academic Year</h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{route('academic-year-update-year')}}">
          @csrf
          <input type="hidden" value="{{$academic->id}}" name="hiddenid"/>
          <div class="form-group  @error('academic') has-error @enderror">
           <label class="control-label" for="inputError">Academic Year</label>
           <input type="text" class="form-control" value="{{$academic->acdemicyear}}" name="academic" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('academic') {{ $message }} @enderror</span>
         </div>
         <div class="form-group  @error('semester') has-error @enderror">
           <label class="control-label" for="inputError">Semester Year</label>
           <select name="semester" class="form-control">
             <option value="{{$academic->semester}}">{{$academic->semester}}</option>
             <option value="First Semester">First Semester</option>
             <option value="Second Semester">Second Semester</option>
           </select>
           <span class="help-block">@error('semester') {{ $message }} @enderror</span>
         </div>
         <input type="submit" name="submit" value="Update Academic Year" class="btn btn-success">

       </form> 
     </div>
   </div>
 </div>
  {{-- <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">All Branches</h3>
      </div>
      
    </div>
  </div>     --}}             
</div>


@endsection




@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    //start
    $(document).on("change",".checkit", function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      
      if ($(this).prop('checked')) {
        
        if (confirm("Confirm Academic Year Activation")) {
          $.ajax({
            url: '{{route('academic-year-update-status')}}',
            type: 'POST',
            data: {_token : _token , cid: cid, status: 1},
            dataType: 'json',
            success: function(data){
              if (data.msg) {
                swal(data.msg, {
                    icon: "success",
                });
                //alert(data.msg);
              }else{
                $("#error").text(data.error).show();
              }
              
            },
            error: function (data) {
              console.log('Error:', data);
              $("#msg").text(data.message).show();
            }
          });

        }


      }else{
       
        if (confirm("Confirm Academic Year Deactivation !")) {
          $.ajax({
            url: '{{route('academic-year-update-status')}}',
            type: 'POST',
            data: {_token : _token , cid: cid, status: 0},
            dataType: 'json',
            success: function(data){
              if (data.msg) {
                //alert(data.msg);
                swal(data.msg, {
                    icon: "success",
                });
              }else{
                $("#error").text(data.error).show();
              }
              
            },
            error: function (data) {
              console.log('Error:', data);
              $("#msg").text(data.message).show();
            }
          });

        }

      }
      
      
    });
    //end

  });

</script>


@endsection
