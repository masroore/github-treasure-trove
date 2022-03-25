@extends('layouts.main')


@section('title')
OSMS | Add Student
@endsection

@section('mtitle')
OSMS Admission Management
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
        <h3 class="box-title">Add A Student</h3>
    </div>
    <div class="box-body">
       <form action="{{ route('add-students-save') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="panel panel-primary">
            <div class="panel panel-heading">Personal Information</div>
            <div class="panel panel-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @error('title')has-error @enderror">
                            <label class="control-label" for="inputSuccess">Title</label>
                            <select name="title" id="" class="form-control">
                                <option>{{ old('title') }}</option>
                                <option>Mr</option>
                                <option>Mrs</option>
                                <option>Miss</option>
                                <option>Ms</option>
                            </select>
                            <span class="help-block">@error('title'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('fullname')has-error @enderror">
                            <label class="control-label" for="inputSuccess">Fullname</label>
                            <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('fullname'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('gender')has-error @enderror">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option>{{ old('gender') }}</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                            <span class="help-block">@error('gender'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    

                </div>



                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group @error('dateofbirth') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Date of Birth</label>
                            <input type="date" class="form-control" value="{{ old('dateofbirth') }}"  name="dateofbirth" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('dateofbirth'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('denomination') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Denomination</label>
                            <input type="text" class="form-control" value="{{ old('denomination') }}" name="denomination" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('denomination'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('religion') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Religion</label>
                            <input type="text" class="form-control" value="{{ old('religion') }}" name="religion" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('religion'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    
                </div>


                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group @error('mobile') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Mobile Number</label>
                            <input type="text" class="form-control" value="{{ old('mobile') }}" name="mobile" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('mobile'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('placeofbirth') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Place of Birth</label>
                            <input type="text" class="form-control" value="{{ old('placeofbirth') }}" name="placeofbirth" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('placeofbirth'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('nationality') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Nationality</label>
                            <input type="text" class="form-control" value="{{ old('nationality') }}" name="nationality" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('nationality'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    

                </div>





                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group @error('hometown') has-error @enderror">
                            <label class="control-label" for="inputSuccess">HomeTown</label>
                            <input type="text" class="form-control" value="{{ old('hometown') }}" name="hometown" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('hometown'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('disability')has-error @enderror">
                            <label>Disability</label>
                            <select class="form-control" name="disability">
                                <option>{{ old('disability') }}</option>
                                <option>Disabled</option>
                                <option>No</option>
                            </select>
                            <span class="help-block">@error('disability'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('postcode') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Post Code</label>
                            <input type="text" class="form-control" value="{{ old('postcode') }}" name="postcode" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('postcode'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    

                    
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group @error('email') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Email</label>
                            <input type="text" class="form-control" value="{{ old('email') }}" name="email" id="inputSuccess" placeholder="Enter ...">
                            <span class="help-block">@error('email'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('maritalstatus')has-error @enderror">
                            <label>Marital Status</label>
                            <select class="form-control" name="maritalstatus">
                                <option>{{ old('maritalstatus') }}</option>
                                <option>Married</option>
                                <option>Single</option>
                                <option>Divorced</option>
                            </select>
                            <span class="help-block">@error('maritalstatus'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group @error('address') has-error @enderror">
                            <label class="control-label" for="inputSuccess">Address</label>
                            <textarea class="form-control" name="address" cols="4" rows="4" placeholder="Enter Address..">{{ old('address') }}</textarea>
                            <span class="help-block">@error('address'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel panel-heading">Academic Information</div>
            <div class="panel panel-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @error('entrylevel')has-error @enderror">
                            <label>Entry Level</label>
                            <select class="form-control" name="entrylevel">
                                <option>{{ old('entrylevel') }}</option>
                                <option value="Level 100">Level 100</option>
                                <option value="Level 200">Level 200</option>
                                <option value="Level 300">Level 300</option>
                                <option value="Level 300">Level 400</option>
                            </select>
                            <span class="help-block">@error('entrylevel'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group @error('session')has-error @enderror">
                            <label>Session</label>
                            <select class="form-control" name="session">
                                <option>{{ old('session') }}</option>
                                <option value="Morning Session">Morning Session</option>
                                <option value="Evening Session">Evening Session</option>
                                <option value="Weekend Session">Weekend Session</option>
                            </select>
                            <span class="help-block">@error('session'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @error('programme')has-error @enderror">
                            <label>Programme</label>
                            <select class="form-control" name="programme">
                                <option>{{ old('programme') }}</option>
                                @foreach($prog as $row)
                                <option value="{{$row->name}} - {{$row->code}} - {{$row->duration}} - {{$row->type}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block">@error('programme'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    
                </div>


            </div>
        </div>


        <div class="panel panel-primary">
            <div class="panel panel-heading">Gurdian Information</div>
            <div class="panel panel-body">
               <div class="row">
                <div class="col-md-4">
                    <div class="form-group @error('guidianfullname') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Gurdian Fullname</label>
                        <input type="text" class="form-control" value="{{ old('guidianfullname') }}" name="guidianfullname" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('guidianfullname'){{ $message }}@enderror</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group @error('relationship') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Relationship</label>
                        <input type="text" class="form-control" value="{{ old('relationship') }}" name="relationship" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('relationship'){{ $message }}@enderror</span>
                    </div>
                </div>  

                <div class="col-md-4">
                    <div class="form-group @error('guidianoccupation') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Occupation</label>
                        <input type="text" class="form-control" value="{{ old('guidianoccupation') }}" name="guidianoccupation" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('guidianoccupation'){{ $message }}@enderror</span>
                    </div>
                </div>     
            </div>


            <div class="row">

                
                <div class="col-md-4">
                    <div class="form-group @error('mobnumber') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Mobile Number</label>
                        <input type="text" class="form-control" value="{{ old('mobnumber') }}" name="mobnumber" id="inputSuccess" placeholder="Enter ...">
                        <span class="help-block">@error('mobnumber'){{ $message }}@enderror</span>
                    </div>
                </div>  
                
                
                <div class="col-md-4">
                    <div class="form-group @error('employed')has-error @enderror">
                        <label>Employed</label>
                        <select class="form-control" name="employed">
                            <option>{{ old('employed') }}</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <span class="help-block">@error('employed'){{ $message }}@enderror</span>
                    </div>
                </div>
                
                
                
            </div>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel panel-heading">Profile Image</div>
        <div class="panel panel-body">

            <div class="row">
              

                <div class="col-md-4">
                    <div class="form-group @error('image') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Pic</label>
                        <input type="file" class="form-control"name="image" id="inputSuccess">
                        <span class="help-block">@error('image'){{ $message }}@enderror</span>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
    

    <input type="submit" class="btn btn-info" value="Add Student">
</form>   
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
