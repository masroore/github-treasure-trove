@extends('layouts.main')


@section('title')
  OSMS | User and Their Roles
@endsection

@section('mtitle')
  User and Their Roles
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
        <h3 class="box-title">User and Their Roles</h3>
      </div>
      <div class="box-body">
       <label>Users and Role</h3></label>
       <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Role</th>
                      <th>Permission(s)</th>
                      <th>Special Perm(s)</th>
                      <th>Edit Permission</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($user_roles as $row)
                        <tr>
                          <td>
                             {{$loop->iteration}}
                          </td>
                          <td>{{$row->name}}</td>
                          <td>
                            {{ implode(', ', $row->roles->pluck('name')->toArray())}}
                          </td>
                         <td>@foreach($role_pers as $role)
                            @if($role->name == implode(', ', $row->roles->pluck('name')->toArray()) )
                          {{ implode(', ', $role->permissions->pluck('name')->toArray())}}
                          @endif
                            @endforeach</td>

                          <td>@foreach($role_pers as $role)
                            @if($role->name == implode(', ', $row->roles->pluck('name')->toArray()) )
                          {{ implode(', ', $role->permissions->pluck('name')->toArray())}}
                          @endif
                            @endforeach</td>
                            
                          <td><a href="{{route('assingn-role-to-permission', ['id'=>$row->id])}}" class="btn btn-success" ><i class='fa fa-edit'></i>Edit</a></td>
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