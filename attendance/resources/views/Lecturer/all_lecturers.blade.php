@extends('layouts.main')


@section('title')
  OSMS | Add Lecturer
@endsection

@section('mtitle')
  OSMS Lecturer Management
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
        <h3 class="box-title">All Lecturers</h3>
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Pic</th>
                  <th>Lecture ID</th>
                  <th>Fullname</th>
                  <th>Gender</th>
                  <th>Date of Birth</th>
                  <th>Faculty</th>
                  <th>Phone Number</th>
                  <th>Joined</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($lecturer as $row)
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
                      <td>{{$row->gender}}</td>
                      <td>{{$row->dateofbirth}}</td>
                      <td>{{$row->faculty}}</td>
                      <td>{{$row->number}}</td>
                      <td>{{$row->created_at}}</td>
                    <td>
                      @foreach($user as $userinfo)
                          @if($userinfo->id == $row->user_id)                                             
                      <a href="{{route('edit-lecturer', ['id'=>$userinfo->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i>Edit</a>
                      @endif
                      @endforeach                   
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
