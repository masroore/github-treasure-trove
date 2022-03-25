@extends('layouts.main')


@section('title')
OSMS | All Leave Requested
@endsection

@section('mtitle')
All Leave Requested
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
        <h3 class="box-title">All Leave Requests</h3>
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered">
          <thead>
            <tr>
              <th>StaffID</th>
              <th>Leave Type</th>
              <th>Leave Date</th>
              <th>Days</th>
              <th>Apply Date</th>
              <th width="15%">Reason</th>
              <th width="15%">Note</th>
              <th>Status</th>
              <th width="15%">Action</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($leave as $row)
            <tr>
              <td>{{$row->staffid}}</td>
              <td>{{$row->leavetype}}</td>
              <td>{{$row->leavedate}}</td>
              <td>{{$row->days}}</td>
              <td>{{$row->applydate}}</td>
              <td>{{$row->reason}}</td>
              <td><textarea cols="3" rows="3" class="form-control" id="reason_{{$row->id}}">{{$row->note}}</textarea></td>
              <td>
               <?php
               if($row->status == 'Rejected'){
                ?>
                <label class="badge badge-danger" style="background-color: #dd4b39;">{{$row->status}}</label>
                <?php
              }else if($row->status == 'Approved'){
                ?>
                <label class="badge badge-success" style="background-color: #00a65a;">{{$row->status}}</label>
                <?php
              }else{
                ?>
                <label class="badge badge-info">{{$row->status}}</label>
                <?php
              }
              ?>
            </td>
            <td>
              <?php
              if($row->status == 'Rejected'){
                ?>
                <a href="#" class="btn btn-success fa fa-mail-reply-all revert" title="Revert" cid={{$row->id}}""></a>
                <input type="hidden" id="apprve_{{$row->id}}" value="{{$row->status}}">
                <?php
              }else if($row->status == 'Approved'){
                ?>
                <a href="#" class="btn btn-success fa fa-mail-reply-all revert" title="Revert" cid={{$row->id}}""></a>
                <input type="hidden" id="apprve_{{$row->id}}" value="{{$row->status}}">
                <?php
              }else{
                ?>
                <select class="form-control" name="apprve" id="apprve_{{$row->id}}">
                  <option></option>
                  <option>Approved</option>
                  <option>Rejected</option>
                </select>
                <?php
              }
              ?>


            </td>
            <td><a href="#" class="fa fa-save btn btn-default saverequest" cid="{{$row->id}}"></a></td>
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

    $(document).on("click","#search",function(e){
      e.preventDefault();
      var role = $("#role").val();
      var month = $("#month").val();
      var year = $("#selectyear").val();
      var _token = $('meta[name=csrf-token]').attr('content');

      if(role == ""){
        swal("Role Cant Be Empty", {
          icon: "warning",
        });
        return;
      }

      if(month == ""){
        swal("Month Cant Be Empty", {
          icon: "warning",
        });
        return;
      }

      if(year == ""){
        swal("Year Cant Be Empty", {
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

        url: '{{ route('payroll_fetch') }}',
        type: 'POST',
        data: {_token : _token , role: role, month: month, year: year},
        success: function(data){ 

          $("#showpayroll").html(data);

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

    });



    $(document).on("click",".saverequest",function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var apprve = $("#apprve_"+cid).val();
      var note= $("#reason_"+cid).val();
      var _token = $('meta[name=csrf-token]').attr('content');

      if(apprve == ""){
        alert('Status Cant Be Empty');
        return;
      }


      if(apprve == "Approved"){
        var dresult = "Approve";
      }else{
        var dresult = "Reject";
      }

      swal({
       title: "Are you sure?",
       text: "Do You Want to "+dresult+" This Leave Request",
       icon: "warning",
       buttons: ['Cancel', 'Yes '+dresult],
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

          url: '{{ route('update_requestleave') }}',
          type: 'POST',
          dataType: 'json',
          data: {_token : _token , apprve: apprve, note: note, cid: cid},
          success: function(data){ 
           swal(data.message, {
            icon: "success",
          });
           window.location.href=url;
         },
         error: function (data) {
          console.log('Error:', data);
        }
      }); 

      }
    });



    });


    $(document).on("click",".revert",function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      var sameurl = '/HumanResource/Staff-payroll/leave';
      
      swal({
       title: "Are you sure?",
       text: "You Want To Revert This Leave Request",
       icon: "warning",
       buttons: ['Cancel', 'Yes Revert'],
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

          url: '{{ route('leave_req_revert') }}',
          type: 'POST',
          dataType: 'json',
          data: {_token : _token ,cid: cid},
          success: function(data){ 
           swal(data.message, {
            icon: "success",
          });
           window.location.href=sameurl;
         },
         error: function (data) {
          console.log('Error:', data);
        }
      }); 


      }
    });

      


    });


  });

</script>


@endsection