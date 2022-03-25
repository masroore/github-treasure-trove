@extends('layouts.main')


@section('title')
  OSMS | All Diploma Courses
@endsection

@section('mtitle')
  All Diploma Courses
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
        <h3 class="box-title">All Diploma Courses</h3>
      </div>
      <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th colspan="4">All Diploma Registered Courses</th>
                    </tr>
                    <tr>
                      <th>Course code</th>
                      <th>Title</th>
                      <th>CH</th>
                      <th>Del</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($degree as $row)
                        <tr>
                          <td>{{$row->code}}</td>
                          <td>{{$row->title}}</td>
                          <td>{{$row->credithours}} </td>
                        <td>
        <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$row->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-trash'></i></a>
<form id="delete_doc_{{$row->id}}" 
  action="{{ route('all-deg-dip-delete', ['id'=> $row->id ]) }}" method="POST" style="display: none;">
                            
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
