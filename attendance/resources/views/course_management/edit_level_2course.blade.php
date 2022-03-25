@extends('layouts.main')


@section('title')
OSMS | Add Programme
@endsection

@section('mtitle')
OSMS Course Management
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <!-- left column -->
  <div class="col-md-5 col-md-offset-3">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Course Level 200 <span class="badge badge-pill badge-secondary">CODE (BGEC)</span></h3>
      </div>
      <div class="box-body">
        <form action="{{route('add-course-degreel2-save')}}" method="POST">
          @csrf
          <input type="hidden" name="hiddenid" value="{{ $course->id }}">
          <div class="form-group  @error('name') has-error @enderror">
           <label class="control-label" for="inputError">Course Title</label>
           <input type="text" value="{{ $course->title }}" class="form-control" name="name" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('name') {{ $message }} @enderror</span>
         </div>


         <div class="form-group  @error('chrs') has-error @enderror">
           <label class="control-label" for="inputError">Cource Code</label>
           <input type="text" value="{{ $course->code }}" class="form-control" name="code" id="inputError" placeholder="Enter ..." readonly>
           <span class="help-block">@error('chrs') {{ $message }} @enderror</span>
         </div>

         <div class="form-group  @error('type') has-error @enderror">
           <label class="control-label" for="inputError">Course Type</label>
           <select name="type" class="form-control">
             <option>{{ $course->type }}</option>
             <option>Core</option>
             <option>Elective</option>
           </select>
           <span class="help-block">@error('type') {{ $message }} @enderror</span>
         </div>

         <div class="form-group  @error('chrs') has-error @enderror">
           <label class="control-label" for="inputError">Credit Hours</label>
           <input type="number" value="{{ $course->credithours }}" class="form-control" name="chrs" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('chrs') {{ $message }} @enderror</span>
         </div>

         <input type="submit" name="submit" value="Update Course" class="btn btn-success">
       </form> 
     </div>
   </div>
 </div>
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
                alert(data.msg);
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
                alert(data.msg);
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
