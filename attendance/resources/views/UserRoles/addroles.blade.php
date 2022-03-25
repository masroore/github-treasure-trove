@extends('layouts.main')


@section('title')
OSMS | Add UserRole
@endsection

@section('mtitle')
OSMS User Management
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add User Roles</h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{route('user-role-save')}}">
         @csrf
         <div class="form-group  @error('role') has-error @enderror">
           <label class="control-label" for="inputError">Role name</label>
           <input type="text" class="form-control" name="role" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('role') {{ $message }} @enderror</span>
         </div>

         <input type="submit" name="submit" value="Add Role" class="btn btn-success">
       </form> 

       <hr>

				{{-- <form method="post" action="{{route('user-permission-save')}}">
					@csrf
					<div class="form-group  @error('Permission') has-error @enderror">
				         <label class="control-label" for="inputError">Add Permission</label>
				         <input type="text" class="form-control" name="Permission" id="inputError" placeholder="Enter ... Permission">
				          <span class="help-block">@error('Permission') {{ $message }} @enderror</span>
				    </div>
				    
				    <input type="submit" name="submit" value="Add Permission" class="btn btn-success">
          </form>  --}}
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="box-body">
          <table id="example3" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>User Role</th>
                <th>Assign Permission</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach($role as $row)
             <tr>
               <td>{{$loop->iteration}}</td>
               <td>{{$row->name}}</td>
               <td><a href="{{route('assingn-role-to-permission', ['id'=>$row->id])}}" class="btn btn-success" ><i class='fa fa-lock'></i> Assign</a></td>

               <td>
                <a href="{{ route('edit-role-perm', ['id'=> $row->id ]) }}" class="btn btn-info"><i class='fa fa-pencil-square-o'></i></a>

                <a href="{{ route('delete-user-role', ['id'=> $row->id ]) }}" onclick="confirm('Are You Sure ?')" class="btn btn-danger"><i class='fa fa-trash'></i></a>

              </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{-- <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <div class="box-body">
       	<table id="example1" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>#</th>
		                  <th>User Permissions</th>
		                  <th>Edit</th>
		                </tr>
		                </thead>
		                <tbody>
		                	@foreach($Permission as $row)
		                		<tr>
		                			<td>{{$loop->iteration}}</td>
		                			<td>{{$row->name}}</td>
		                			<td>
				<a href="#" onclick="document.getElementById('delete_doc_{{$row->id}}').submit();" class="btn btn-info"><i class='fa fa-pencil-square-o'></i>Edit</a>
							<form id="delete_doc_{{$row->id}}" 
								action="{{ route('edit-role-perm', ['id'=> $row->id ]) }}" method="POST" style="display: none;">			            
							<input type="hidden" name="type" value="perm">
				       			@csrf
				               </form>	
								</td>
		                	  </tr>
		                	@endforeach
		                </tbody>
		             </table>
      </div>
    </div>
  </div>   --}}                 
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
