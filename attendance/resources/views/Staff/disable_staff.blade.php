@extends('layouts.main')


@section('title')
  OSMS | Disable Staff
@endsection

@section('mtitle')
  Disable Staff
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
        <h3 class="box-title">Disable Staff</h3>
      </div>
      <div class="box-body">
       <table id="example1" class="table table-bordered">
                    <thead>
                    <tr>
                      <th>img</th>
                      <th>User</th>
                      <th>user id</th>
                      <th>Status</th>
                      <th>Force Logout</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $row)
                        <tr>

                          <td>
                               @if($row->pro_pic != null)
                <img src=" {{ asset('storage' )}}/{{$row->pro_pic}}" class="img-circle" alt="User Image" width="60" height="60">
                    
                               @else
                <img src="{{ URL::to('images/user.png')}}"class="img-circle"  alt="User Image">

                               @endif
                          </td>
                          <td>{{$row->name}}</td>
                          <td>{{$row->indexnumber}}</td>
                          <td>
                            @if($row->is_active == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger" style="background-color: #dd4b39;">Inactive</span>
                            @endif
                          </td>
                           @if($row->force_logout == 0)
                          <td>

        <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('force_{{$row->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-sign-out'></i>Disable Staff</a>
  <form id="force_{{$row->id}}" 
  action="{{ route('logout-user-force-update', ['id'=> $row->id ]) }}" method="POST" style="display: none;">
                            
               @csrf
                       </form>  
                </td>
                      @else
                      <td>

        <a href="#" onclick="if(confirm('Enable User ?')){ event.preventDefault(); document.getElementById('force_{{$row->id}}').submit(); }" class="btn btn-success"><i class='fa fa-sign-out'></i>Enable User</a>
  <form id="force_{{$row->id}}" 
  action="{{ route('logout-user-force-enable', ['id'=> $row->id ]) }}" method="POST" style="display: none;">
                            
               @csrf
                       </form>  
                </td>
                @endif

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