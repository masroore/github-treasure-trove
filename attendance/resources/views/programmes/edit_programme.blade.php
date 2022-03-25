@extends('layouts.main')


@section('title')
  OSMS | Edit Programme
@endsection

@section('mtitle')
  Edit Programme
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

  <div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Programme</h3>
      </div>
      <div class="box-body">
          <form method="post" action="{{route('update-programme')}}">
          @csrf
          <input type="hidden" name="hiddenid" value="{{$program->id}}">
          <div class="form-group  @error('name') has-error @enderror">
                 <label class="control-label" for="inputError">Programme name</label>
                 <input type="text" class="form-control" value="{{$program->name}}" name="name" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('name') {{ $message }} @enderror</span>
            </div>
            <div class="form-group  @error('typeofp') has-error @enderror">
               <label class="control-label" for="inputError">Type of Programme</label>
                 <select id="prog" name="typeofp" class="form-control" required>

                <option value="{{$program->type}}">{{$program->type}}</option>
                <option value="Degree Programme">Degree Programme</option>
                <option value="Diploma Programme">Diploma Programme</option>
                <option value="Masters Programme">Masters Programme</option>
                <option value="Phd Programme">Phd Programme</option>
            </select>
              <span class="help-block">@error('typeofp') {{ $message }} @enderror</span>
            </div>
            <div class="form-group  @error('code') has-error @enderror">
                 <label class="control-label" for="inputError">Programme Code</label>
                 <input type="text" value="{{$program->code}}" class="form-control" name="code" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('code') {{ $message }} @enderror</span>
            </div>
            <div class="form-group  @error('duration') has-error @enderror">
                 <label class="control-label" for="inputError">Programme Duration</label>
                 <input type="number" value="{{$program->duration}}" class="form-control" name="duration" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('duration') {{ $message }} @enderror</span>
            </div>
            <div class="form-group  @error('department') has-error @enderror">
                 <label class="control-label" for="inputError">Department</label>
                 <input type="text" value="{{$program->department}}" class="form-control" name="department" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('department') {{ $message }} @enderror</span>
            </div>
            <input type="submit" name="submit" value="Update Programme" class="btn btn-success">
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
