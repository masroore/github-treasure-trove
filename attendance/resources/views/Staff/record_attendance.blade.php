@extends('layouts.main')


@section('title')
OSMS | Record Attendance
@endsection

@section('mtitle')
OSMS Record Attendance
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

            <div class="form-group @error('role') has-error @enderror ">
              <label>Role</label>
              <select class="form-control" name="role" id="role" required>
                <option>{{ old('role') }}</option>
                @foreach($roles as $row)
                 @if ($row->name !== 'Student')
                   <option value="{{$row->name}}">{{$row->name}}</option>
                 @endif
                @endforeach
              </select>
              <span class="help-block">@error('role'){{ $message }}@enderror</span>

            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group @error('role') has-error @enderror ">
              <label>Attendance Date</label>
              <input type="date" name="attendancedate" id="attendancedate" class="form-control" value="{{now()}}">
              <span class="help-block">@error('role'){{ $message }}@enderror</span>

            </div>

            <a href="#" class="btn btn-info pull-right" id="search">Search</a>
          </div>
        </div>


        <div class="clearfix"></div>
        <div id="showattendance"></div>
        <div id="showresult"></div>
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
      var role = $("#role").val();
      var date = $("#attendancedate").val();
      var _token = $('meta[name=csrf-token]').attr('content');

      if(role == ""){
        swal("Role Cant Be Empty", {
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

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('fetchstaff') }}',
        type: 'POST',
        data: {_token : _token , role: role, date: date},
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

        url: '{{ route('saveattendant') }}',
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