@extends('layouts.main')


@section('title')
OSMS | Lecturers Course(s) Assign
@endsection

@section('mtitle')
Lecturers Course(s) Assign
@endsection


@section('mtitlesub')

@endsection



@section('main_content')
<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{asset('storage')}}/{{$staff->pro_pic}}" width="100" height="100" alt="User profile picture">

        <h3 class="profile-username text-center">{{$staff->name}}</h3>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>StaffID</b> <a class="pull-right">
              {{$staff->staff->eployid}}
            </a>
          </li>
          <li class="list-group-item">
            <b>Role</b> <a class="pull-right">{{$staff->staff->role}}</a>
          </li>
          <li class="list-group-item">
            <b>Basic Salary</b> <a class="pull-right">Gh&cent;{{$staff->staff->salary}}</a>
          </li>
          <li class="list-group-item">
            <b>Gained Admission</b> <a class="pull-right">{{$staff->staff->created_at}}</a>
          </li>
        </ul>

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">About Me</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <strong><i class="fa fa-book margin-r-5"></i>Qualification</strong>

        <p class="text-muted">
          {{$staff->staff->qualification}}
        </p>

        <hr>

        <strong><i class="fa fa-map-marker margin-r-5"></i>Location</strong>

        <p class="text-muted">{{$staff->staff->address}}</p>

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
        <li><a href="#leccourses" data-toggle="tab">Assigned Course(s)</a></li>
        {{-- <li><a href="#payroll" data-toggle="tab">Payroll</a></li>
        <li><a href="#leave" data-toggle="tab">Leave</a></li>
        <li><a href="#attendance" data-toggle="tab">Attendance</a></li> --}}
        {{-- <li><a href="#document" data-toggle="tab">Document</a></li> --}}
      </ul>
      <div class="tab-content">

        <div class="active tab-pane" id="profile">

          <div class="panel panel-primary">
            <div class="panel panel-heading">Personal Information</div>
            <div class="panel-body">
             <table id="example1" class="table table-bordered table-striped">
              <tbody>
                <tr>
                  <td>Phone</td>
                  <td>{{$staff->staff->number}}</td>
                </tr>

                <tr>
                  <td>Staff Email</td>
                  <td>{{$staff->email}}</td>
                </tr>

                <tr>
                  <td>Your Email</td>
                  <td>{{$staff->regemail}}</td>
                </tr>

                <tr>
                  <td>Gender</td>
                  <td>{{$staff->staff->gender}}</td>
                </tr>

                <tr>
                  <td>Date of Birth</td>
                  <td>{{$staff->staff->dateofbirth}}</td>
                </tr>

                <tr>
                  <td>Marital Status</td>
                  <td>{{$staff->staff->maritalstatus}}</td>
                </tr>

                <tr>
                  <td>Fathers Name</td>
                  <td>{{$staff->staff->fathername}}</td>
                </tr>

                <tr>
                  <td>Mothers Name</td>
                  <td>{{$staff->staff->mothername}}</td>
                </tr>

                <tr>
                  <td>Work Experence</td>
                  <td>{{$staff->staff->workexperience}}</td>
                </tr>

              </tbody>
            </table>
          </div>  
        </div>


        <div class="panel panel-primary">
          <div class="panel panel-heading">Address</div>
          <div class="panel-body">
           <table id="example1" class="table table-bordered table-striped">
            <tbody>
              <tr>
                <td>Address</td>
                <td>{{$staff->staff->address}}</td>
              </tr>
            </tbody>
          </table>
        </div>  
      </div>


  </div>

  <div class="tab-pane" id="leccourses">

    <div class="panel panel-primary">
      <div class="panel panel-heading">Assigned Course(s)</div>
      <div class="panel-body">

        <div class="form-group">
          <label class="control-label" for="inputSuccess">Select Course To Add</label>
          <select class="form-control" id="courses" >
            <option></option>
            @foreach($courses as $row)
            <option value="{{$row->title}} - {{$row->code}}">{{$row->title}} - {{$row->code}} </option>
            @endforeach
          </select>
        </div>


        <table class="table table-bordered table-bordered">
          <thead>
            <tr>
              <th colspan="4">Assigned Course(s) For {{$staff->name}}</th>
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
                <a href="#" cid="{{$row->id}}" data-title="{{$row->course}}" class="delcourse btn btn-danger" ><i class='fa fa-trash'></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>  
    </div>

  </div>
  


{{-- <div class="tab-pane" id="document">

  <div class="panel panel-primary">
    <div class="panel panel-heading">Documents</div>
    <div class="panel-body">

     <table class="table table-bordered"  border="1" cellpadding="10">
      <tr>
        <th>filename</th>
        <th>Uploaded</th>
        <th>View</th>
      </tr>
      
    </table>

  </div>  
</div>

</div> --}}





</div>
</div>
</div>
</div>



<div id="displaypayslip"></div>



@endsection



@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    //start
    $(document).on("change","#courses", function(e){
      e.preventDefault();
      var value = $(this).val();
      var lecid = '{{$lectid}}';
      var _token = $('meta[name=csrf-token]').attr('content');
      var split = value.split('-');
      var cid = split[1];
      // alert(cid);
      // return;
      swal({
       title: "Are you sure?",
       text: "Assign "+split[0]+" ("+split[1]+") To This Lecturer",
       icon: "warning",
       buttons: ['Cancel', 'Yes Assign'],
       dangerMode: true,
     })
      .then((willDelete) => {
       if (willDelete) {

        $.ajax({

          beforeSend: function(){
            $.LoadingOverlay("show");
          },
          complete: function(){
            $.LoadingOverlay("hide");
          },

          url: '{{route('lecturer-assign-course')}}',
          type: 'POST',
          data: {_token : _token , cid: cid, lecid: lecid},
          success: function(data){ 

            if(data.match("success")){

             // swal("Course Assigned Successfully, Reload Page to Take Effect",{
             //   icon: 'success',
             // });
             toastr.success('Course Assigned Successfully, Reload Page to Take Effect');

             window.location.reload();
           }else{
            
              toastr.error('Failed! Course Has Already Been Assigned to this lecturer');
             // swal("Failed! Course Has Already Been Assigned to this lecturer",{
             //   icon: 'warning',
             // });


           }


         },
         error: function (data) {
          console.log('Error:', data);
        }
      });  

      }
    });



    });
    

    $(document).on("click",".delcourse", function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      var  ctitle = $(this).data('title');
      swal({
        title: "Are you sure?",
        text: "Remove "+ctitle+" From Assigned Courses",
        icon: "warning",
        buttons: ['Cancel', 'Yes Remove'],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({

            beforeSend: function(){
              $.LoadingOverlay("show");
            },
            complete: function(){
              $.LoadingOverlay("hide");
            },

            url: '{{route('lecturer-remove-assign-course')}}',
            type: 'POST',
            data: {_token : _token , cid: cid},
            success: function(data){ 

             //  swal(" Course Removed Successfully, Reload Page to take Effect",{
             //   icon: 'success',
             // });
              toastr.success('Course Removed Successfully, Reload Page to take Effect');

              window.location.reload();

            },
            error: function (data) {
              console.log('Error:', data);
            }
          });  

        }
      });

    });




    $(document).on("change","#selectyear",function(e){
      e.preventDefault();
      var value = $(this).val();
      var lectid = '{{$lectid}}';
      var _token = $('meta[name=csrf-token]').attr('content');

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{route('yearfetch')}}',
        type: 'POST',
        data: {_token : _token , lectid: lectid, value: value},
        success: function(data){ 
          $("#showAttendance").html(data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

      //alert(value);
    });



    $(document).on("click",".viewpay",function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{route('view_payroll_now')}}',
        type: 'POST',
        dataType: 'json',
        data: {_token : _token , cid: cid},
        success: function(data){ 
          
          $("#displaypayslip").html(data.message);
          //alert(data.message);
          $("#viewpay").modal('show');
          
        },
        error: function (data) {
          console.log('Error:', data);
        }
      }); 


    });


    $(document).on("click","#print_pay", function(e){
      e.preventDefault();
      var mode = 'iframe'; // popup
      var close = mode == "popup";
      var options = { mode : mode, popClose : close};
      $("#viewpay").printArea(options);

    });



  });

</script>


@endsection