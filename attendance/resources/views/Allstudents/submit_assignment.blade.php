@extends('layouts.main')


@section('title')
  OSMS | Student Portal - Submit Assignment
@endsection

@section('mtitle')
  OSMS Student Portal
@endsection


@section('mtitlesub')

@endsection



@section('main_content')
  
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Student Portal Submit Assignment</h3>
      </div>
      <div class="box-body">
          <div class="card mb-3">
              <h3 class="card-header"></h3>
              <div class="card-body">
                <h5 class="card-title"></h5>
                <h6 class="card-subtitle text-muted"></h6>
              </div>
              <img style="height: 200px; width: 100%; display: block;" src="{{URL::to('images/assignment (1).jpg')}}" alt="Card image">
            </div>
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">{{$row->assignment_title}}</h4>
                <p class="card-text">{{$row->assignment_description}}</p>
                <a href="#" class="card-link"><button type="button" class="btn btn-outline-primary">{{$row->course_code}}</button></a>
                <a href="#" class="card-link"><button type="button" class="btn btn-outline-secondary">{{$row->lname}}</button></a>
                <a href="#" class="card-link"><button type="button" class="btn btn-outline-secondary">{{\Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</button></a>
                
              </div>
            </div>

            <hr>

            @if($elapse < 0)
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oh snap!
                  Assignment Elapsed </strong>
              </div>
            @else
              @if($subs == '1')
                <div class="alert alert-dismissible alert-info">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Assignment Submitted Successfully!</strong> 
               </div>             
            @else
              <form method="post" action="{{route('students-assignment-submit')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{$assignmentid}}" name="assignmentid">
                <input type="hidden" name="stuid" value="{{auth()->user()->indexnumber}}">
                <input type="hidden" name="stuname" value="{{auth()->user()->name}}">
              
                   <div class="form-group  @error('assingmentdoc') has-error @enderror">
                       <label class="control-label" for="inputError">Upload Assignment Doc</label>
                       <input type="file" class="form-control" name="assingmentdoc" id="inputError">
                        <span class="help-block">@error('assingmentdoc') {{ $message }} @enderror</span>
                  </div>                      
                  <input type="submit" name="submit" value="Submit Assignment" class="btn btn-success">
              </form>
            @endif 
           @endif
            
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
