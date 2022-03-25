@extends('layouts.main')


@section('title')
@lang('school.pagetitle') | Generate Payroll
@endsection

@section('mtitle')
@lang('school.pagetitle') | Generate Payroll
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

@php
  if (@$_GET['year']) {
    $year = $_GET['year'];
  }else{
    $year = date('Y');
  }

  if (@$_GET['month']) {
    $month = $_GET['month'];
  }else{
    $month = date('F');
  }
  
@endphp
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <div class="box-body">

        <div class="row">
          <div class="col-md-4">
            <div class="form-group @error('role') has-error @enderror ">
              <label>Role</label>
              @php
                $array = ['Student','Developer','is_admin'];
              @endphp
              <select class="form-control" name="role" id="role" required>
                <option>{{ old('role') }}</option>
                <option>All</option>
                @foreach($roles as $row)
                @if (!in_array($row->name, $array))
                <option value="{{$row->name}}">{{$row->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group @error('role') has-error @enderror ">
              <label>Month</label>
              <select class="form-control" name="month" id="month" required>
                <option><?php echo $month; ?></option>
                <option>-------------------------------</option>
                <option>January</option>
                <option>February</option>
                <option>Match</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
           <div class="form-group">
            <label class="control-label" for="inputSuccess">Year</label>
            <select class="form-control" id="selectyear" >
              <?php
                  $startdate = (int) __('school.startyear');
                  $current = (int) date('Y');

                  $count = $current - $startdate;
                  ?>
                  <option>{{$current}}</option>
                  <option>------------------------------------</option>
                  <option>{{$startdate}}</option>
                  @for ($i = 0; $i < $count; $i++)
                  <option><?php echo $startdate + 1?></option>
                  @endfor
            </select>
          </div> 

          <a href="#" class="btn btn-success pull-right" id="search">Search</a>
        </div>


        <div class="clearfix"></div>

        <div id="showpayroll">
          <div class="box-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>StaffID</th>
                  <th>Fullname</th>
                  <th>Role</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $array = ['Student','Developer','is_admin'];
                @endphp
                @foreach ($staff as $row)
                @if (!in_array($row->role, $array))
                <tr>
                  <td>{{$month}}</td>
                  <td>{{$row->eployid}}</td>
                  <td>{{$row->fullname}}</td>
                  <td>{{$row->role}}</td>
                  <td>{{$row->number}}</td>
                  <td>
                    <?php
                    $payrol =  App\Payroll::where('user_id',$row->user_id)
                    ->where('year',$year)
                    ->where('month',$month)->first();


                    if($payrol){

                      if($payrol->status == ''){
                        ?>
                        <label class="badge badge-info">process..</label>
                        <?php
                      }

                      if($payrol->status == 'Generated'){
                        ?>
                        <label class="badge badge-success">Generated</label>
                        <?php
                      }

                      if($payrol->status == 'Paid'){
                        ?>
                        <label class="badge badge-primary">Paid</label>
                        <?php
                      }
                    }else{
                      ?>
                      <label class="badge badge-success">process..</label>
                      <?php
                    }
                    ?>
                  </td>
                  <td>


                    <?php
                    
                    if($payrol){

                      if($payrol->status == ''){
                        ?>
                        <a href="{{ route('generate_payroll',['id' => $row->user_id, 'month' => $month, 'year' => $year, 'role' => $row->role]) }}" class="btn btn-info">Generate</a>
                        <?php
                      }

                      if($payrol->status == 'Generated'){
                        ?>
                        <a href="#" cid="{{$payrol->id}}" class="revert fa fa-mail-reply-all" title="revert"></a> &nbsp;&nbsp; <a href="#" cid="{{$payrol->id}}" class="paynow btn btn-success">Proceed To Pay</a>
                        <?php
                      }

                      if($payrol->status == 'Paid'){
                        ?>
                        <a href="#" cid="{{$payrol->id}}" class="revert fa fa-mail-reply-all" title="revert">

                        </a> &nbsp;&nbsp; <label class="viewpay badge badge-primary" cid="{{$payrol->id}}">View Paid Slip</label>
                        <?php
                      }
                    }else{
                      ?>
                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <a href="{{ route('generate_payroll',['id' => $row->user_id, 'month' => $month, 'year' => $year, 'role' => $row->role]) }}" class="btn btn-info">Generate</a>
                      <?php
                    }
                    ?>

                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>

          
        </div>
        <div id="showresult"></div>
      </div>
    </div>
  </div>
</div>

</div>


<div id="displaypayslip"></div>


<!---- modal here ---->
<div class="modal fade" id="request-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Proceed To Pay</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="savepayroll">
            @csrf
            <input type="hidden" name="hiddenid" id="hiddenid">

            <div class="row">
             <div class="col-md-6">
              <div class="form-group @error('fullname')has-error @enderror">
                <label>Fullname</label>
                <input type="text" name="fullname" id="fullname" class="form-control" id="reservation" required>
                <span class="help-block">@error('fullname'){{ $message }}@enderror</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group @error('staffid')has-error @enderror">
                <label>Staff ID</label>
                <input type="text" name="staffid" id="staffid" class="form-control" id="reservation" required>
                <span class="help-block">@error('staffid'){{ $message }}@enderror</span>
              </div>
            </div>

            

          </div>


          <div class="row">

            <div class="col-md-6">
              <div class="form-group @error('netsalary')has-error @enderror">
                <label>Net Salary</label>
                <input type="number" name="netsalary" id="netsalary" class="form-control" required>
                <span class="help-block">@error('netsalary'){{ $message }}@enderror</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group @error('modeofpay')has-error @enderror">
                <label>Mode Of Payment</label>
                <select class="form-control" name="modeofpay" id="modeofpay" required>
                  <option></option>
                  <option>Cash</option>
                  <option>Bank Payment</option>
                  <option>Cheque</option>
                  <option>Mobile Money</option>
                </select>
                <span class="help-block">@error('modeofpay'){{ $message }}@enderror</span>
              </div>
            </div>

          </div>



          <div class="form-group @error('reasons')has-error @enderror">
            <label>Note</label>
            <textarea cols="4" rows="4" class="form-control" id="reasons" name="reasons"></textarea>
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



    $(document).on("click",".paynow",function(e){
      e.preventDefault();
      var id = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('fetch_payroll_fetail') }}',
        type: 'POST',
        dataType: 'json',
        data: {_token : _token , id: id},
        success: function(data){ 
          if(data.msg){
            $("#hiddenid").val(data.userid);
            $("#fullname").val(data.fname);
            $("#staffid").val(data.employid);
            $("#netsalary").val(data.salary);
            $("#reasons").val(data.note);
            $("#request-modal").modal('show');
          }
          

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

    });



    $(document).on("submit","#savepayroll",function(e){
      e.preventDefault();
      var sameorigin = "/HumanResource/Staff-payroll";

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('save_payroll_now') }}',
        type: 'POST',
        dataType: 'json',
        data: $("form").serialize(),
        success: function(data){ 
          if(data.msg){
            swal(data.message, {
              icon: "success",
            });

            window.location.href=url;
          }
          
        },
        error: function (data) {
          console.log('Error:', data);
        }
      }); 

    });

    $(document).on("click",".viewpay",function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");

      var redrecturl = '/HumanResource/Staff-payroll/view-staff/'+cid+'/payroll-info';

      window.open(redrecturl,"_blank");
      return;

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




  });

</script>


@endsection