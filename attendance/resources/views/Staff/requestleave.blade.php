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
    <a href="#" class="fa fa-plus btn btn-default pull-right" title="Request Leave" data-toggle="modal" data-target="#request-modal"></a>
    <div class="clearfix"></div>
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Your Leave Requests</h3>
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
              <th width="25%">Reason</th>
              <th width="25%">Note</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($leave as $row)
            <tr>
              <td>{{$row->staffid}}</td>
              <td><input type="hidden" id="leavtype_{{$row->id}}" value="{{$row->leavetype}}"> {{$row->leavetype}}</td>
              <td><input type="hidden" id="ldate_{{$row->id}}" value="{{$row->leavedate}}"> {{$row->leavedate}}</td>
              <td><input type="hidden" id="ldays_{{$row->id}}" value="{{$row->days}}"> {{$row->days}}</td>
              <td>{{$row->applydate}}</td>
              <td><input type="hidden" id="lreasn_{{$row->id}}" value="{{$row->reason}}"> {{$row->reason}}</td>
              <td>{{$row->note}}</td>
              <td>
                @if ($row->status == 'Processing')
                <label class="badge badge-info">{{$row->status}}</label>
                @endif

                @if ($row->status == 'Approved')
                <label class="badge badge-success" style="background-color: #00a65a;">{{$row->status}}</label>
                @endif

                @if ($row->status == 'Rejected')
                <label class="badge badge-danger" style="background-color: #dd4b39;">{{$row->status}}</label>
                @endif

                @if ($row->status == 'Reverted')
                <label class="badge badge-danger" style="background-color: #dd4b39;">{{$row->status}}</label>
                @endif
                
              </td>
              <td>
                <?php
                if($row->status == 'Rejected'){
                  ?>
                  <a href="#" class="btn btn-danger fa fa-remove"></a>
                  <?php
                }else if($row->status == 'Approved'){
                  ?>
                  <a href="#" class="btn btn-success fa fa-check-square"></a>
                  <?php
                }else{
                  ?>
                  <a href="#" cid="{{$row->id}}" class="editreq fa fa-edit btn btn-default"></a>
                  <?php
                }
                ?>
                
              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>

        <div id="resultmsg"></div>
      </div>
    </div>
  </div>
</div>



<!---- modal here ---->

<div class="modal fade" id="request-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Request Leave</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="requestleavenow">
            @csrf
            <input type="hidden" name="editrequest" id="editrequest">
            <input type="hidden" name="hiddenid" id="hiddenid">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group @error('leavetype')has-error @enderror">
                  <label class="control-label" for="inputSuccess">Leave Type</label>
                  <select class="form-control" name="leavetype" id="leavetype" required>
                    <option></option>
                    <option>Medicals Leave</option>
                    <option>Sick Leave</option>
                    <option>Travel Leave</option>
                    <option>Study Leave</option>
                    <option>Others</option>
                  </select>
                  <span class="help-block">@error('leavetype'){{ $message }}@enderror</span>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group @error('daterange')has-error @enderror">
                  <label>Leave Date</label>
                  <input type="text" name="daterange" id="daterange" class="form-control" id="reservation" required>
                  <span class="help-block">@error('daterange'){{ $message }}@enderror</span>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group @error('days')has-error @enderror">
                  <label>Estimated Days</label>
                  <input type="number" name="days" id="days" class="form-control" required>
                  <span class="help-block">@error('days'){{ $message }}@enderror</span>
                </div>
              </div>

            </div>

            <div class="form-group @error('reasons')has-error @enderror">
              <label>Leave Reasons</label>
              <textarea cols="4" rows="4" class="form-control" id="reasons" name="reasons" required></textarea>
              <span class="help-block">@error('reasons'){{ $message }}@enderror</span>
            </div>


            

          </div>
          <div class="modal-footer">
            <input type="submit" name="save" value="save" class="btn btn-primary">
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  @endsection



  @section('script')

  <script type="text/javascript">
    $('document').ready(function(){

       //Date range picker
       $('#reservation').daterangepicker()

       $(document).on("submit","#requestleavenow",function(e){
        e.preventDefault();
        
        $.ajax({
          beforeSend: function(){
            $.LoadingOverlay("show");
          },
          complete: function(){
            $.LoadingOverlay("hide");
          },

          url: '{{ route('save_requestleave') }}',
          type: 'POST',
          dataType: 'json',
          data: $("form").serialize(),
          success: function(data){ 

            if(data.msg){
              swal(data.message, {
                icon: "success",
              });
              $("#editrequest").val('');
              $("#daterange").val('');
              window.location.href=url;
            }

          },
          error: function (data) {
            console.log('Error:', data);
          }
        });  

      });



       $(document).on("click",".editreq",function(e){
        e.preventDefault();
        var cid = $(this).attr("cid");
        var ltype = $("#leavtype_"+cid).val();
        var ldate = $("#ldate_"+cid).val();
        var ldays = $("#ldays_"+cid).val();
        var lreasn = $("#lreasn_"+cid).val();

        //alert(ltype);
        $("#editrequest").val('edit');
        $("#hiddenid").val(cid);
        $("#leavetype").val(ltype);
        $("#daterange").val(ldate);
        $("#days").val(ldays);
        $("#reasons").val(lreasn);
        $("#request-modal").modal('show');
      });



     });

   </script>


   @endsection