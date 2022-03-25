@extends('layouts.main')


@section('title')
OSMS | Record Attendance
@endsection

@section('mtitle')
 Record Attendance
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
        <h3 class="box-title">Select Criteria</h3>
      </div>
      <div class="box-body">

        <div class="row">


          <div class="col-md-6">
            <div class="form-group @error('coursecode') has-error @enderror ">
              <label>Course Code</label>
              <select name="coursecode" id="coursecode" class="form-control">
                <option></option>
                @foreach($data as $row)
                  <option value="{{ $row->code }}">{{ $row->title }} - {{ $row->code }}</option>
                @endforeach
               
              </select>
              <span class="help-block">@error('coursecode'){{ $message }}@enderror</span>

            </div>
          </div>


                    <div class="col-md-6">
                        <div class="form-group @error('entrylevel')has-error @enderror">
                            <label>Level</label>
                            <select class="form-control" name="entrylevel" id="entrylevel">
                                <option>{{ old('entrylevel') }}</option>
                                <option value="Level 100">Level 100</option>
                                <option value="Level 200">Level 200</option>
                                <option value="Level 300">Level 300</option>
                                <option value="Level 300">Level 400</option>
                            </select>
                            <span class="help-block">@error('entrylevel'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group @error('session')has-error @enderror">
                            <label>Session</label>
                            <select class="form-control" name="session" id="session">
                                <option>{{ old('session') }}</option>
                                <option value="Morning Session">Morning Session</option>
                                <option value="Evening Session">Evening Session</option>
                                <option value="Weekend Session">Weekend Session</option>
                            </select>
                            <span class="help-block">@error('session'){{ $message }}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @error('programme')has-error @enderror">
                            <label>Programme</label>
                            <select class="form-control" name="programme" id="programme">
                                <option>{{ old('programme') }}</option>
                                @foreach($prog as $row)
                                <option value="{{$row->code}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block">@error('programme'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    

          <div class="col-md-6">
            <div class="form-group @error('role') has-error @enderror ">
              <label>Current Date</label>
              <input type="date" name="attendancedate" id="attendancedate" class="form-control" value="{{now()}}">
              <span class="help-block">@error('role'){{ $message }}@enderror</span>

            </div>

            <a href="#" class="btn btn-info pull-right" id="search">Search</a>
          </div>

        </div>


        <div class="clearfix"></div>

        <br>

        <div class="table-responsive">
          <div id="showattendance"></div>
          <div id="showresult"></div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection



@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    document.getElementById('attendancedate').valueAsDate = new Date();

    $(document).on("click","#search",function(e){
      e.preventDefault();
      var level = $("#entrylevel").val();
      var programme = $("#programme").val();
      var code = $("#coursecode").val();
      var session = $("#session").val();
      var date = $("#attendancedate").val();
      var _token = $('meta[name=csrf-token]').attr('content');

      if(session == ""){
        swal("Session Cant Be Empty", {
          icon: "warning",
        });
        return;
      }

      if(date == ""){
        swal("Attendance Date Cant Be Empty", {
          icon: "warning",
        });
        return;
      }


var url = '/attendance-report-generate/'+level+'/'+code+'/'+programme+'/'+session+'/'+date;


 window.location.href = url;
 return;
console.log(url);
return;

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('attendance-fetch-student') }}',
        type: 'POST',
        data: {_token : _token ,level: level, code: code,programme: programme, session: session, date: date},
        success: function(data){ 

          $("#showattendance").html(data);

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

    });



    $(document).on("submit","#submitattendance",function(e){
      e.preventDefault();

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('lms-lec-attendance-fetch-student-save') }}',
        data: $("form").serialize(),
        type: 'POST',
        success: function(data){ 

         swal("Attendance Added Successfully!", {
          icon: "success",
        });

       },
       error: function (data) {
        console.log('Error:', data);
      }
    });  

    });






  });

</script>


@endsection