@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Assignment Information
@endsection

@section('mtitle')
  Assignment Information
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h5>Assignment Information</h5>
            </div>
            <div class="card-block">

                <div class="card">
                    <img class="card-img-top" src="{{URL::to('images/assignment (2).jpg')}}" alt="Card image cap" width="291" height="200">
                    <div class="card-body">
                      <h5 class="card-title">{{$row->assignment_title}}</h5>
                      <p class="card-text">{{$row->assignment_description}}</p>
                      <p class="card-text"><small class="text-muted">Last updated {{\Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</small></p>
                  </div>
              </div>

            </div>
        </div>

        <div class="card" style="padding: 10px;">
          
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
 

@endsection



@section('script')

<script type="text/javascript">

</script>


@endsection