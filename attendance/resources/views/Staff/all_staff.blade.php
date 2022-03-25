@extends('layouts.main')


@section('title')
  OSMS | All Staff
@endsection

@section('mtitle')
  OSMS All Staff
@endsection


@section('mtitlesub')
    
@endsection



@section('main_content')
    <div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Staff Directory</h3>
      </div>
      <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Pic</th>
                  <th>Staff ID</th>
                  <th>Fullname</th>
                  <th>Role</th>
                  <th>Faculty</th>
                  <th>Gender</th>
                  <th>Date of Birth</th>
                  <th>Faculty</th>
                  <th>Phone Number</th>
                  <th>Joined</th>
                  <th width="20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($staff as $row)
                    <tr>
                      <td>@foreach($user as $userinfo)
                          @if($userinfo->id == $row->user_id)
                          <img src="{{asset('storage')}}/{{$userinfo->pro_pic}}" class="img-circle"width="50" height="50">
                          @endif

                      @endforeach</td>
                      <td>@foreach($user as $userinfo)
                          @if($userinfo->id == $row->user_id)
                             {{$userinfo->indexnumber}}
                          @endif

                      @endforeach</td>
                      <td>{{$row->fullname}}</td>
                      <td>{{$row->role}}</td>
                      <td>{{$row->faculty}}</td>
                      <td>{{$row->gender}}</td>
                      <td>{{$row->dateofbirth}}</td>
                      <td>{{$row->faculty}}</td>
                      <td>{{$row->number}}</td>
                      <td>{{$row->created_at}}</td>
                    <td>
                        <a href="{{route('viewStaff', ['id'=>$row->user_id])}}" class="btn btn-success" ><i class='fa fa-eye'></i></a> 

                     {{--    <a href="{{route('viewStaff', ['id'=>$row->user_id])}}" class="btn btn-success" onclick="window.open('{{route('viewStaff', ['id'=>$row->user_id])}}','newwindow','width=600,height=600'); return false; " ><i class='fa fa-eye'></i>View</a> --}}

                        <a href="{{route('editStaff', ['id'=>$row->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i></a> 

                    </td>
                    </tr>
                  @endforeach
                </tbody>
             </table>
      </div>
    </div>
  </div>
</div>
    

@endsection


@section('script')

<script type="text/javascript">
    if(localStorage.getItem("total_seconds")){
    var total_seconds = localStorage.getItem("total_seconds");
} else {
    var total_seconds = 60*10;
}
var minutes = parseInt(total_seconds/60);
var seconds = parseInt(total_seconds%60);
function countDownTimer(){
    if(seconds < 10){
        seconds= "0"+ seconds ;
    }if(minutes < 10){
        minutes= "0"+ minutes ;
    }
    
    document.getElementById("quiz-time-left").innerHTML = "Time Left :"+minutes+"minutes"+seconds+"seconds";
    if(total_seconds <= 0){
        setTimeout("document.quiz.submit()",1);
    } else {
        total_seconds = total_seconds -1 ;
        minutes = parseInt(total_seconds/60);
        seconds = parseInt(total_seconds%60);
        localStorage.setItem("total_seconds",total_seconds)
        setTimeout("countDownTimer()",1000);
    }
}
setTimeout("countDownTimer()",1000);
</script>

<script type="text/javascript">
  $('document').ready(function(){
     

  });

</script>


@endsection
