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
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{$procode->name}} 
        l
      <br> <b class="text-center">First Semester Courses </b></h3>
      </div>
      <div class="box-body">
        <h2>Check Courses To Register </h2>
            <form action="{{route('add-course-programme-BPRM-first-save', ['code'=>$procode->code])}}" method="POST">
              @csrf
              <input type="hidden" value="First Semester" class="form-control" name="semester">
              <input type="hidden" value="{{$procode->name}}" class="form-control" name="programme">
              <input type="hidden" value="{{$procode->code}}" class="form-control" name="progcode">
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Check</th>
                      <th>Course code</th>
                      <th>Title</th>
                      <th>CH</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($course as $row)
                        <tr>
                          <td>
                            <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{$row->id}}" class="custom-control-input" id="customCheck1" name="course[]">
                      </div>
                    </div>
                          </td>
                          <td>{{$row->code}}</td>
                          <td>{{$row->title}}</td>
                          <td>{{$row->credithours}} </td>
                        </tr>
                      @endforeach
                    </tbody>
                 </table>
                </div>    
               
                <input type="submit" name="submit" value="Add Course" class="btn btn-success"><hr>
                <p><a href="{{route('add-course-degreel1')}}">Cant Find Course, Add Course</a></p>
            </form> 
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <div class="box-body">
           <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th colspan="4">Level 100 First Semester Registered Courses</th>
                    </tr>
                    <tr>
                      <th>Course code</th>
                      <th>Title</th>
                      <th>CH</th>
                      <th>Del</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($procourse as $row)
                        <tr>
                          <td>{{$row->coursecode}}</td>
                          <td>{{$row->coursetitle}}</td>
                          <td>{{$row->credithours}} </td>
                        <td>
        <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$row->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-trash'></i></a>
<form id="delete_doc_{{$row->id}}" 
  action="{{ route('course-remove-first-BPRM', ['id'=> $row->id ]) }}" method="POST" style="display: none;">
                            
               @csrf
                       </form>  
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
