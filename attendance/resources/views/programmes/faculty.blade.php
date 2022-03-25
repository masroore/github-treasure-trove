@extends('layouts.main')


@section('title')
  OSMS | Add Faculty
@endsection

@section('mtitle')
  OSMS Add Faculty
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Faculty</h3>
      </div>
      <div class="box-body">
        <form method="POST" action="{{route('add-faculty-save')}}" >
          @csrf
          <div class="form-group  @error('name') has-error @enderror">
                 <label class="control-label" for="inputError">Faculty name</label>
                 <input type="text" class="form-control" name="name" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('name') {{ $message }} @enderror</span>
            </div>
            
            <input type="submit" name="submit" value="Add Faculty" class="btn btn-success">
        </form> 
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Facilties List</h3>
      </div>
      <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Faculty name</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($faculty as $row)
                    <tr>
                      <td>{{$row->id}}</td>
                      <td>{{$row->name}}</td>
                    <td><a href="{{route('add-faculty-delete', ['id'=>$row->id])}}" class="btn btn-danger" onclick="return confirm('Are you sure You want to Delete')" ><i class='fa fa-trash'></i>Delete</a></td>
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
