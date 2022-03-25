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
        <h3 class="box-title">Edit Lecturer Information</h3>
      </div>
      <div class="box-body">
        <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('storage')}}/{{$user->pro_pic}}" class="img-circle"width="100" height="100">
                </div>
                
                <div class="col-md-6">

                </div>
                <hr>
                <div class="clearfix"></div>
            </div>
            <form action="{{ route('update-lecturer-info') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hiddenid" value="{{$user->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('fullname')has-error @enderror">
                        <label class="control-label" for="inputSuccess">Fullname</label>
    <input type="text" class="form-control" name="fullname" value="{{ $lecturer->fullname }}" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('fullname'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group @error('gender')has-error @enderror">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                        <option>{{ $lecturer->gender }}</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                    <span class="help-block">@error('gender'){{ $message }}@enderror</span>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('dateofbirth') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Date of Birth</label>
                        <input type="date" class="form-control" value="{{ $lecturer->dateofbirth}}"  name="dateofbirth" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('dateofbirth'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group @error('faculty') has-error @enderror">
                    <label>Faculty</label>
                    <select class="form-control" name="faculty">
                    <option>{{ $lecturer->faculty}}</option> 
                    @foreach($faculty as $row)
                    <option value="{{$row->name}}">{{$row->name}}</option>
                    @endforeach
                    </select>
                    <span class="help-block">@error('faculty'){{ $message }}@enderror</span>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('religion') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Religion</label>
                        <input type="text" class="form-control" value="{{ $lecturer->religion }}" name="religion" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('religion'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group @error('mobile') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Mobile Number</label>
                        <input type="text" class="form-control" value="{{ $lecturer->number }}" name="mobile" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('mobile'){{ $message }}@enderror</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('qualification') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Qualification</label>
                        <input type="text" class="form-control" value="{{ $lecturer->qualification }}" name="qualification" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('qualification'){{ $message }}@enderror</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group @error('email') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" name="email" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('email'){{ $message }}@enderror</span>
                    </div>
                </div>

                
            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('image') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Pic</label>
                        <input type="file" class="form-control"name="image" id="inputSuccess">
                        <span class="help-block">@error('image'){{ $message }}@enderror</span>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group @error('address') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Address</label>
                        <textarea class="form-control" name="address" cols="4" rows="4" placeholder="Enter Address..">{{ $lecturer->address }}</textarea>
                        <span class="help-block">@error('address'){{ $message }}@enderror</span>
                    </div>
                </div>
                
            </div>


                <input type="submit" class="btn btn-info pull-right mr-10" value="Update Imformation">
                
            </form>

            <hr>

            <div class="alert alert-success">
                Assign Courses To Lecture or Delete Course
            </div>

            <div class="row">
               
                <div class="col-md-6">
                    <div id="alert-here"></div>

                    <div class="form-group @error('image') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Select Course To Add</label>
                        <select class="form-control select2" id="courses" >
                          @foreach($courses as $row)
                             <option value="{{$row->code}}">{{$row->title}} - {{$row->code}} </option>
                          @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="4">Lecturer Assigned Courses</th>
                    </tr>
                <tr>
                  <th>S.N</th>
                  <th>Course</th>
                  <th>Code</th>
                  <th>Acton</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($leccources as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->course}}</td>
                            <td>{{$row->code}}</td>
                            <td>
                                <a href="#" cid="{{$row->id}}" class="delcourse btn btn-danger" ><i class='fa fa-trash'></i>Remove</a>
                            </td>
                        </tr>
                   @endforeach
                </tbody>
             </table>
            
            </div>    
                </div>
                
            </div>


      </div>
    </div>
  </div>
</div>
@endsection


@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    //start
    $(document).on("change","#courses", function(e){
      e.preventDefault();
      var cid = $(this).val();
      var lecid = '{{$lectid}}';
      var _token = $('meta[name=csrf-token]').attr('content');

      if (confirm("Add This Course To Assigned Courses...")) {
            $.ajax({
                    url: '{{route('lecturer-assign-course')}}',
                    type: 'POST',
                    data: {_token : _token , cid: cid, lecid: lecid},
                    success: function(data){
                        $("#alert-here").html(data);
                        //$('#example1').DataTable().ajax.reload();
                    },
                      error: function (data) {
                        console.log('Error:', data);
                        $("#msg").text(data.message).show();
                      }
                });

     }
          
     
    });
    

    $(document).on("click",".delcourse", function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
        
       if (confirm("Remove Course From Assigned Course..")) {
            $.ajax({
                    url: '{{route('lecturer-remove-assign-course')}}',
                    type: 'POST',
                    data: {_token : _token , cid: cid},
                    success: function(data){
                        $("#alert-here").html(data);
                        //$('#example1').DataTable().ajax.reload();
                    },
                      error: function (data) {
                        console.log('Error:', data);
                        $("#msg").text(data.message).show();
                      }
                });

     }   
     
    });



  });

</script>


@endsection
