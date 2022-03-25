@extends('layouts.main')


@section('title')
OSMS | Add Staff
@endsection

@section('mtitle')
OSMS Add Staff
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
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">

        <div class="panel panel-primary">
            <div class="panel-heading">Basic Information</div>
            <div class="panel-body">

                <form action="{{ route('savestaff') }}" id="addstaffd" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group @error('fullname')has-error @enderror">
                                <label class="control-label" for="inputSuccess">Fullname<b style="color: red;">*</b></label>
                                <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" id="inputSuccess" placeholder="Enter ..." required>
                                <span class="help-block">@error('fullname'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group @error('gender')has-error @enderror">
                                <label>Gender<b style="color: red;">*</b></label>
                                <select class="form-control" name="gender" required>
                                    <option>{{ old('gender') }}</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                                <span class="help-block">@error('gender'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            

                           <div class="form-group @error('role') has-error @enderror ">
                              <label>Role</label>
                              <select class="form-control" name="role" id="role" required>
                                <option>{{ old('role') }}</option>

                                @php
                                    $array = ['Student','is_admin','Developer'];
                                @endphp
                                
                                @foreach($roles as $row)
                                @if (!in_array($row->name, $array))
                                <option value="{{$row->name}}">{{$row->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="help-block">@error('role'){{ $message }}@enderror</span>

                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="form-group @error('faculty') has-error @enderror ">
                            <label>Faculty<b style="color: red;">*</b></label>
                            <select class="form-control" name="faculty" required>
                             <option>{{ old('faculty') }}</option>
                             @foreach($faculty as $row)
                             <option value="{{$row->name}}">{{$row->name}}</option>
                             @endforeach
                             <option>HR</option>
                             <option>Sports</option>
                             <option>Libarian</option>
                             <option>Art</option>
                             <option>Accounts</option>
                             <option>Help Desk</option>
                             <option>Admission</option>
                             <option>Academics</option>
                             <option>Others</option>
                         </select>
                         <span class="help-block">@error('faculty'){{ $message }}@enderror</span>
                     </div>
                 </div>
             </div>


             <div class="row">

                <div class="col-md-3">
                    <div class="form-group @error('dateofbirth') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Date of Birth<b style="color: red;">*</b></label>
                        <input type="date" class="form-control" value="{{ old('dateofbirth') }}"  name="dateofbirth" id="inputSuccess" placeholder="Enter ..." required>
                        <span class="help-block">@error('dateofbirth'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('religion') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Religion<b style="color: red;">*</b></label>
                        <input type="text" class="form-control" value="{{ old('religion') }}" name="religion" id="inputSuccess" placeholder="Enter ..." required>
                        <span class="help-block">@error('religion'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('mobile') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Mobile Number<b style="color: red;">*</b></label>
                        <input type="text" class="form-control" value="{{ old('mobile') }}" name="mobile" id="inputSuccess" placeholder="Enter ..." required>
                        <span class="help-block">@error('mobile'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('email') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Email<b style="color: red;">*</b></label>
                        <input type="text" class="form-control" value="{{ old('email') }}" name="email" id="inputSuccess" placeholder="Enter ..." required>
                        <span class="help-block">@error('email'){{ $message }}@enderror</span>
                    </div>
                </div>


            </div>



            <div class="row">
                <div class="col-md-3">
                    <div class="form-group @error('mstatus') has-error @enderror ">
                        <label>Marital Status<b style="color: red;">*</b></label>
                        <select class="form-control" name="mstatus" required>
                            <option>{{ old('mstatus') }}</option>
                            <option>Married</option>
                            <option>Unmarried</option>
                            <option>Divorced</option>
                            <option>Single</option>
                        </select>
                        <span class="help-block">@error('mstatus'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('mname') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Mothers Name</label>
                        <input type="text" name="mname" id="mname" class="form-control">
                        <span class="help-block">@error('mname'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('fname') has-error @enderror">
                        <label class="control-label" for="inputSuccess">Fathers Name</label>
                        <input type="text" name="fname" id="fname" class="form-control">
                        <span class="help-block">@error('fname'){{ $message }}@enderror</span>
                    </div>
                </div>

                
                <div class="col-md-3">
                    <div class="form-group @error('wrkexperience') has-error @enderror">
                        <label class="control-label" for="wrkexperience">Work Experence<b style="color: red;">*</b></label>
                        <textarea cols="4" rows="4" name="wrkexperience" class="form-control" required>{{ old('wrkexperience') }}</textarea>
                        <span class="help-block">@error('wrkexperience'){{ $message }}@enderror</span>
                    </div>
                </div>
                
                
            </div>


            <div class="row">
                <div class="col-md-3">
                    <div class="form-group @error('qualification') has-error @enderror">
                        <label class="control-label" for="qualification">Qualification<b style="color: red;">*</b></label>
                        <textarea cols="4" rows="4" name="qualification" class="form-control" required>{{ old('qualification') }}</textarea>
                        <span class="help-block">@error('qualification'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('address') has-error @enderror">
                        <label class="control-label" for="address">Address<b style="color: red;">*</b></label>
                        <textarea class="form-control" name="address" cols="4" rows="4" placeholder="Enter Address.." required>{{ old('address') }}</textarea>
                        <span class="help-block">@error('address'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group @error('image') has-error @enderror">
                        <label class="control-label" for="image">Pic<b style="color: red;">*</b></label>
                        <input type="file" class="form-control"name="image" id="image" required>
                        <span class="help-block">@error('image'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="col-md-3" id="courseshow">
                    <div class="form-group @error('courses') has-error @enderror ">
                        <label>Assgn Courses to Lecturer</label>
                        <select class="form-control select2" name="courses[]" multiple="multiple" >
                         @foreach($courses as $row)
                         <option value="{{$row->code}}">{{$row->title}} - {{$row->code}} </option>
                         @endforeach
                         
                     </select>
                 </div>
             </div>
             

             
         </div>

     </div>
 </div>


 <div class="panel panel-primary">
    <div class="panel-heading">Payroll</div>
    <div class="panel-body">

     <div class="row">

         <div class="col-md-3">
            <div class="form-group @error('grade') has-error @enderror ">
                <label>Salary Grade<b style="color: red;">*</b></label>
                <select class="form-control" name="grade" id="grade" required>
                   <option>{{ old('grade') }}</option>
                   <option>Grade 1</option>
                   <option>Grade 2</option>
                   <option>Grade 3</option>
                   <option>Grade 4</option>
                   <option>Grade 5</option>                
               </select>
               <span class="help-block">@error('grade'){{ $message }}@enderror</span>
           </div>
       </div>

       <div class="col-md-3">
        <div class="form-group @error('salary') has-error @enderror">
            <label class="control-label" for="salary">Basic Salary<b style="color: red;">*</b></label>
            <input type="number" name="salary" id="salary" class="form-control" value="{{ old('salary') }}" required>
            <span class="help-block">@error('salary'){{ $message }}@enderror</span>
        </div>
    </div>
    
</div>

</div>
</div>


<div class="panel panel-primary">
    <div class="panel-heading">Bank Account Details</div>
    <div class="panel-body">
        
     <div class="row">
        <div class="col-md-3">
            <div class="form-group @error('acctitle') has-error @enderror">
                <label class="control-label" for="acctitle">Account Title/Name</label>
                <input type="text" class="form-control"name="acctitle" id="acctitle">
                <span class="help-block">@error('acctitle'){{ $message }}@enderror</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group @error('accnumber') has-error @enderror">
                <label class="control-label" for="accnumber">Account Number</label>
                <input type="text" class="form-control"name="accnumber" id="accnumber">                        <span class="help-block">@error('accnumber'){{ $message }}@enderror</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group @error('bankname') has-error @enderror">
                <label class="control-label" for="bankname">Bank Name</label>
                <input type="text" class="form-control"name="bankname" id="bankname">
                <span class="help-block">@error('bankname'){{ $message }}@enderror</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group @error('branch') has-error @enderror ">
                <label>Branh</label>
                <input type="text" class="form-control"name="branch" id="branch">
                <span class="help-block">@error('branch'){{ $message }}@enderror</span>
            </div>
        </div>
        
    </div>

</div>
</div>


<div class="panel panel-primary">
    <div class="panel-heading">Upload Documents </div>
    <div class="panel-body">
     <div class="row">
        <div class="col-md-3">
            <div class="form-group @error('resume') has-error @enderror">
                <label class="control-label" for="resume">Resume<b style="color: red;">*</b></label>
                <input type="file" class="form-control"name="resume" id="resume">
                <span class="help-block">@error('resume'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group @error('otherdocs') has-error @enderror">
                <label class="control-label" for="otherdocs">Other Documents (Upload More Than One Document)<b style="color: red;"></b></label>
                <input type="file" class="form-control"name="otherdocs[]" id="otherdocs" multiple>
                <span class="help-block">@error('otherdocs'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>
</div>
</div>


<input type="submit" class="btn btn-info pull-right" value="Add Staff">
</form>
</div>
</div>
</div>
</div>

@endsection


@section('script')

<script type="text/javascript">
  $('document').ready(function(){

      $(document).on("change","#role",function(e){
        e.preventDefault();
        var value = $(this).val();
        //alert(value);

        if (value == 'Lecturer') {
            $("#courseshow").show();
        }else{
            $("#courseshow").hide();
        }

    });


      $(document).on("change","#grade",function(e){
        e.preventDefault();
        var value = $(this).val();
        
        if (value == 'Grade 1') {
            $("#salary").val(1000);
        }

        if (value == 'Grade 2') {
            $("#salary").val(2000);
        }

        if (value == 'Grade 3') {
            $("#salary").val(3000);
        }

        if (value == 'Grade 4') {
            $("#salary").val(4000);
        }

        if (value == 'Grade 5') {
            $("#salary").val(5000);
        }

    });

      $(document).on("submit","#addstaff",function(e){
        e.preventDefault();

        //alert('working');

        //return;

        $.ajax({
            beforeSend: function(){
              $.LoadingOverlay("show");
          },
          complete: function(){
              $.LoadingOverlay("hide");
          },

          url: '{{route('savestaff')}}',
          type: 'POST',
          data: $("form").serialize(),
          success: function(data){ 

              $("showmsg").html(data);

          },
          error: function (data) {
              console.log('Error:', data);
          }
      });  

    });






  });

</script>


@endsection
