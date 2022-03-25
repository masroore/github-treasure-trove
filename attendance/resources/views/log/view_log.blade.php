@extends('layouts.main')


@section('title')
OSMS | View Logs
@endsection

@section('mtitle')
OSMS View Logs
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div id="displayhere"></div>


<div class="row">




 <!-- second term -->

 <div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">All Logs</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>S.N</th>
            <th>Action By</th>
            <th>Action Type</th>
            <th>Model Affected</th>
            <th>Affected Model ID</th>
            <th width="30%">Details Affected</th>
            <th>Url</th>
            <th>IP Address</th>
            <th>User Agent</th>
          </tr>
        </thead>
        <tbody>
          @foreach($audits as $audit)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                @foreach($users as $user)
                  @if($user->id == $audit->user_id)
                      {{$user->name}}
                  @endif
                @endforeach
              </td>
              
              <td>
                  @if($audit->event == 'created')
                      Model Created
                  @elseif($audit->event == 'deleted')
                      Model Deleted
                  @elseif($audit->event == 'updated')
                      Model Updated
                  @endif
                </td>
              <td>
                  {{$audit->auditable_type}}
              </td>
              <td>{{$audit->auditable_id}}</td>
              <td>
                  @if($audit->event == 'created')

                      @if($audit->auditable_type = 'App\User')
                         <b class="badge badge-success"> Recorded Values: </b> <br> 
                          
                       @php
                        $data = json_decode($audit->new_values, true);                       
                       @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} => {{$value}} <br>
                       @endforeach
                    
                        

                      @elseif($audit->auditable_type = 'App\Hall')
                        <b class="badge badge-success"> Recorded Values: </b> <br> 
                          
                       @php
                        $data = json_decode($audit->new_values, true);                       
                       @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} => {{$value}} <br>
                       @endforeach

                        

                      @elseif($audit->auditable_type = 'App\fees')


                      @endif
                      
                  @elseif($audit->event == 'deleted')
                  
                      @if($audit->auditable_type = 'App\User')
                        <b class="badge badge-success"> Deleted Values: </b> <br>@php
                          $data = json_decode($audit->old_values, true);                       
                        @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach
                          

                      @elseif($audit->auditable_type = 'App\Hall')
                        <b class="badge badge-success"> Deleted Values: </b> <br> 
                        @php
                          $data = json_decode($audit->old_values, true);                       
                        @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach

                      @elseif($audit->auditable_type = 'App\fees')


                      @endif
                      
                  @elseif($audit->event == 'updated')
                      
                      @if($audit->auditable_type = 'App\User')

                        <b class="badge badge-info">Old Values: </b> <br> 
                        @php
                          $data = json_decode($audit->old_values, true);                       
                        @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach
                          <hr>
                        

                        <b class="badge badge-success"> Updated Values: </b> <br> 
                        @php
                        $data = json_decode($audit->new_values, true);                       
                       @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach

                      @elseif($audit->auditable_type = 'App\Hall')
                        <b class="badge badge-info">Old Values: </b> <br> 
                        @php
                          $data = json_decode($audit->old_values, true);                       
                        @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach 
                           <hr>

                        <b class="badge badge-success"> Updated Values: </b> <br> 
                        @php
                        $data = json_decode($audit->new_values, true);                       
                       @endphp 


                       @foreach ($data as $key => $value)
                          {{$key}} = {{$value}} <br>
                       @endforeach

                      @elseif($audit->auditable_type = 'App\fees')


                      @endif
                      
                  @endif 

                  <!-- {{$audit->new_values}} -->

                  

              </td>
              <td class="text-danger">{{$audit->url}}</td>
              <td>{{$audit->ip_address}}</td>
              <td>{{$audit->user_agent}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>	


  </div>
  <!-- /.box -->
</div>




</div>



@endsection




@section('script')

<script type="text/javascript">
  $('document').ready(function(){


  	//start
    $(document).on("change","#programme", function(e){
      e.preventDefault();
      var cid = $(this).val();
      var level = $("#level").val();
      var session = $("#session").val();

      if (level == "" || session == "") {
      	if (level == "") {
      		$("#levelerror").text('Level Cant Be Empty');
      	}else{
      		$("#levelerror").text('');
      	}


      	if (session == "") {
      		$("#sessionerror").text('Session Cant Be Empty');
      	}else{
      		$("#sessionerror").text('');
      	}

      	return;
      }else{
        $("#levelerror").text('');
        $("#sessionerror").text('');
      }


      //alert(cid + level + session);
      //return;
      var _token = $('meta[name=csrf-token]').attr('content');     
      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },
        url: '{{route('courses-timetable')}}',
        type: 'POST',
        data: {_token : _token , cid: cid, level: level, session: session},
        success: function(data){ 

                    	//alert(data);

                      $("#couses-display").html(data);
                    },
                    error: function (data) {
                      console.log('Error:', data);
                      $("#msg").text(data.message).show();
                    }
                  });    

    });
    //end


    $(document).on("submit","#create-meeting",function(e){
     e.preventDefault(); 
   		    //$("#starttime").romoveClass("has-error"); 
   		    //$("#couses-display").romoveClass("has-error");            
          $.ajax({
            beforeSend: function(){
              $.LoadingOverlay("show");
            },
            complete: function(){
              $.LoadingOverlay("hide");
            },
            url: '{{route('save-meeting')}}',
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            data: new FormData(this),
            success: function(data){                      	

             if (data.success) {
                      		// $("#displayhere").html(data.success);
                         swal("Success! Meeting Schedule Successfully!", {
                           icon: "success",
                         });

                         clearfileds();
                         $('#meetings').DataTable().ajax.reload();
                       }


                       if (data.error) {

                       }

                     },
                       // error: function (xhr,status,data) {
                        error: function (data) {	

                         if (xhr.status == 400) {
                          if (xhr.responseJSON.errors.level) {
                           $("#levelerror").text('Please select Level To Proceed');
                         }else{
                           $("#levelerror").text('');
                         }

                       }

                       console.log(data);
                        //console.log('Error:', data.responseText);
                      }
                    });   

        });


    function clearfileds(){
     $("#title").val("");
     $("#start-time").val("");
     $("#duration").val("");
     $("#level").val("");
     $("#session").val("");
     $("#programme").val("");
     $("#cousers").val("");
   }







   $('#meetingss').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('all-meeting') }}',
    dom: 'lBfrtip',
    buttons: [
    'copy',
    'csv',
    'excel',
    'pdf',
    'print'
    ],
    columns: [
    {data:  'DT_RowIndex'},
    {data: 'lec_name'},
    {data: 'programme'},
    {data: 'level'},
    {data: 'session'},
    {data: 'cousers'},
    {data: 'starttime'},
    {data: 'action', name: 'action'}
    ]




  });


   $(document).on("click",".del-meeting",function(e){
    e.preventDefault();
    var id = $(this).attr("cid");

    swal({
     title: "Are you sure?",
     text: "Once deleted, you will not be able to recover this meeting.",
     icon: "warning",
     buttons: true,
     dangerMode: true,
   })
    .then((willDelete) => {
     if (willDelete) {

      var _token = $('meta[name=csrf-token]').attr('content');     
      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },
        url: '{{route('del-meeting')}}',
        type: 'POST',
        data: {_token : _token , id: id},
        success: function(data){ 

          swal("Meeting Deleted Successfully!",{
           icon: 'success',
         });


          $('#meetings').DataTable().ajax.reload();

        },
        error: function (data) {
          console.log('Error:', data);
          $("#msg").text(data.message).show();
        }
      });  

    }
  });


  });
















 });

</script>


@endsection
