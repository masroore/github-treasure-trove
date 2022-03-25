@extends('layouts.main')


@section('title')
OSMS | All ONLINE Admissions
@endsection

@section('mtitle')
Student Information
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-info pull-right"><i class="fa  fa-angle-double-left"></i></a>

<div class="clearfix"></div>
<!-- Main content -->
<div class="row">

  <div class="col-md-3">          <!-- Profile Image -->
    <div class="box box-primary">

      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{asset('storage')}}/{{$personal->pro_pic}}" alt="User profile picture">

        <h3 class="profile-username text-center">{{$personal->name}}</h3>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Student ID</b> <a class="pull-right">
              {{$personal->studentinfos->indexnumber}}
            </a>
          </li>
          <li class="list-group-item">
            <b>Current Level</b> <a class="pull-right">{{$personal->studentinfos->currentlevel}}</a>
          </li>
          <li class="list-group-item">
            <b>Session</b> <a class="pull-right">{{$personal->studentinfos->session}}</a>
          </li>
          <li class="list-group-item">
            <b>Admitted</b> <a class="pull-right">{{$personal->studentinfos->created_at->diffForHumans()}}</a>
          </li>
        </ul>

{{-- <p class="text-muted text-center">Students</p> --}}      
     </div>

     <!-- About Me Box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Guardian Information</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <strong><i class="fa fa-book margin-r-5"></i>Guardian Fullname</strong>

        <p class="text-muted">
          {{$personal->studentinfos->gurdianname}}
        </p>
        <hr>
        <strong><i class="fa fa-map-marker margin-r-5"></i>Phone Number</strong>
        <p class="text-muted"> {{$personal->studentinfos->mobile}}</p>
      </div>
    </div>

      <!-- /.box-body -->
    </div>
    <!-- /.box -->         
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">Information</a></li>
          <li><a href="#academicinfo" data-toggle="tab">Academic Information</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">


            <div class="box-boby">
              <table class="table table-bordered table-striped">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <td colspan="2"><b> Personnal Information </b></td>
                  </tr>
                  <tr>
                    <td>Fullname</td>
                    <td>{{$personal->studentinfos->fullname}}</td>
                  </tr>
                  <tr>
                    <td>Date of birth</td>
                    <td>{{$personal->studentinfos->dateofbirth}}</td>
                  </tr>

                  <tr>
                    <td>Email</td>
                    <td>{{$personal->studentinfos->email}}</td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td>{{$personal->studentinfos->phone}}</td>
                  </tr>
                  <tr>
                    <td>Marital Status</td>
                    <td>{{$personal->studentinfos->maritalstutus}}</td>
                  </tr>
                </tbody>
              </table>
            </div>


            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <td colspan="2"><b> Guardian Infomation </b></td>
                  </tr>
                  <tr>
                    <td>Guardian Fullname</td>
                    <td>{{$personal->studentinfos->gurdianname}}</td>
                  </tr>
                  <tr>
                    <td>Relationship</td>
                    <td>{{$personal->studentinfos->relationship}}</td>
                  </tr>

                  <tr>
                    <td>Occupation</td>
                    <td>{{$personal->studentinfos->occupation}}</td>

                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td>{{$personal->studentinfos->mobile}}</td>

                  </tr>
                </tbody>
              </table>
            </div>  
            
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="academicinfo">
             <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <td colspan="2"><b> Academic Information </b></td>
                  </tr>
                  <tr>
                    <td>Entry Level</td>
                    <td>{{$personal->studentinfos->entrylevel}}</td>
                  </tr>
                  <tr>
                    <td>Current Level</td>
                    <td>{{$personal->studentinfos->currentlevel}}</td>
                  </tr>

                  <tr>
                    <td>Programme</td>
                    <td>{{$personal->studentinfos->programme}}</td>
                  </tr>
                  <tr>
                    <td>Session</td>
                    <td>{{$personal->studentinfos->session}}</td>
                  </tr>
                  <tr>
                    <td>Index Number</td>
                    <td>{{$personal->studentinfos->indexnumber}}</td>
                  </tr>
                </tbody>
              </table>

            </div>  
            </div>
            <!-- /.tab-pane -->

            
            <!-- /.tab-pane -->
          </div>

          
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->

      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  @endsection




  @section('script')

  <script type="text/javascript">
   $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


   $('document').ready(function(){
    $(document).on('change','.progamme',function(e){
     e.preventDefault();
     var prog = $(this).val();
     var cid = $(this).attr("cid");
     var _token = $('meta[name=csrf-token]').attr('content');
     _this = $(this);
     $.ajax({
       url: '{{route('admissions-update-programme')}}',
       type: 'POST',
       data: {_token : _token , prog: prog, cid: cid},
       dataType: 'json',
       success: function(data){
        $("#msg").text(data.msg).show();
      },
      error: function (data) {
       console.log('Error:', data);
       $("#msg").text('Sorry, Something error :(').show();
     }
   });
   });


    $(document).on('change','.appprove',function(e){
      e.preventDefault();
      var status = $(this).val();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      _this = $(this);
      $.ajax({
        url: '{{route('admissions-approve-admission')}}',
        type: 'POST',
        data: {_token : _token , status: status, cid: cid},
        dataType: 'json',
        success: function(data){
          if (data.msg) {
            $("#msg").text(data.msg).show();
          }else{
            $("#error").text(data.error).show();
          }

        },
        error: function (data) {
          console.log('Error:', data);
          $("#msg").text(data.message).show();
        }
      });
    });





    $('#admission').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('admissions-all-confirm') }}',
      dom: 'lBfrtip',
      buttons: [
      'copy',
      'csv',
      'excel',
      'pdf',
      'print'
      ],
      columns: [
      {data: 'id'},
      {data: 'profileimg', render: function(data){
       return '<img src="{{asset('storage')}}/'+data+'" class="img-circle"width="50" height="50">';
     },
     orderable: false
   },
   {data: 'firstnames'},
   {data: 'gender'},
   {data: 'entrylevel'},
   {data: 'year'},
   {data: 'programme'},
   {data: 'indexnumber'},
   {data: 'approve', render: function(data,type,row,meta){
     $html = "";
     $html += '<a href="#" class="btn btn-success confirm" cid="'+row['indexnumber']+'">';
     $html += 'confirm now</a>';
     return $html;
   }, 
   orderable: false
 },
 {data: 'action', name: 'action'},
 ]




});





    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    	console.log(message);
    };

  });
</script>


@endsection
