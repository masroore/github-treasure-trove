@extends('layouts.main')


@section('title')
OSMS | Generate Payroll
@endsection

@section('mtitle')
Generate Payroll
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

        <div class="alert alert-info">
          Attendance Desctiption <br>
          Present: P, Late: L, Absent: A, Half Day: F, Holiday: H
        </div>

        <a href="{{ route('add_payroll') }}" class="btn btn-info pull-right">&larr;</a>
        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-7">
           <table id="example1" class="table table-bordered">
            <tbody>
                {{-- <tr>
                  <td colspan="4"><h3><b>Staff Details</b></h3></td>
                </tr> --}}
                <tr>
                 <td rowspan="4"><img src="{{ asset('storage') }}/{{$user->pro_pic}}" class="img-circle" width="100" height="100"></td>

               </tr>

               <tr>
                <td><b>Fullname</b></td>
                <td>{{$staff->fullname}}</td>
                <td><b>StaffID</b></td>
                <td>{{$staff->eployid}}</td>
              </tr>

              <tr>
                <td><b>Phone</b></td>
                <td>{{$staff->number}}</td>
                <td><b>Email</b></td>
                <td>{{$user->email}}</td>
              </tr>

              <tr>
                <td><b>Faculty</b></td>
                <td>{{$staff->faculty}}</td>
                <td><b>Role</b></td>
                <td>{{$staff->role}}</td>
              </tr>


            </tbody>
          </table>

        </div>
        <div class="col-md-5">

          <table id="example1" class="table table-bordered">
            <tbody>

              <tr>
               <td colspan="6"><b style="font-size: 19px;">Attendance</b></td> 
             </tr>

             <tr>
              <td><b>Month</b></td>
              <td><b>P</b></td>
              <td><b>L</b></td>
              <td><b>A</b></td>
              <td><b>F</b></td>
              <td><b>H</b></td>
            </tr>

            <tr>
              <td><b>{{$month}}</b></td>
              <td><b>{{$totalpresent}}</b></td>
              <td><b>{{$totallate}}</b></td>
              <td><b>{{$totalabsent}}</b></td>
              <td><b>{{$totalhalfday}}</b></td>
              <td><b>{{$totalholiday}}</b></td>
            </tr>

          </tbody>
        </table>

      </div>
    </div>

    <hr>

    <div class="clearfix"></div>

    <form method="post" id="claculate">
      @csrf
      
      <div class="row">
        <div class="col-md-4">
          <ul class="list-inline">
            <li><b style="font-size: 20px;">Earning<b/></li>
              <li class="pull-right"><a href="" class="btn btn-info" id="earnplus"><i class="fa fa-plus"></i></a></li>
            </ul>

            <div class="box-height" >

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <input class="form-control form-border" name="etype[]"  type="text" placeholder="Type" />
                  </div>
                </div>

                <div class="col-md-6">
                  <input class="form-control form-border" name="earn[]" type="number" placeholder="Amount" />
                </div>


              </div>

              <div id="addearn"></div>

            </div>
          </div>
          <div class="col-md-4">
           <ul class="list-inline">
            <li><b style="font-size: 20px;">Deduction<b/> </li>
             <li class="pull-right"><a href="" class="btn btn-info" id="deductplus"><i class="fa fa-plus"></i></a></li>
           </ul>

           <div class="box-height" >

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <input class="form-control form-border" name="dtype[]"  type="text" placeholder="Type" />
                </div>
              </div>

              <div class="col-md-6">
                <input class="form-control form-border" name="deduct[]" type="number" placeholder="Amount" />
              </div>


            </div>

            <div id="adddeduction"></div>

          </div>
        </div>
        <div class="col-md-4">
          <ul class="list-inline mb-2">
            <li><b style="font-size: 20px;">Payroll Summury Gh&cent;<b/> </li>
              <li class="pull-right"><input type="submit" id="calcu" name="calculate" value="Calculate" class="btn btn-info"></li>
            </ul>

            <div class="box-height" >
              <div class="form-group">
                <label class="col-sm-4 control-label">Basic Salary</label>
                <div class="col-sm-8">
                  <input class="form-control form-border" name="basic" value="{{$staff->salary}}" id="basic"  type="text" />
                </div>
              </div><!--./form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label">Earning</label>
                <div class="col-sm-8">
                  <input class="form-control form-border" name="total_allowance" id="total_allowance"  type="text" />
                </div>
              </div><!--./form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label">Deduction</label>
                <div class="col-sm-8 deductiondred">
                  <input class="form-control form-border" name="total_deduction" id="total_deduction" type="text" style="color:#f50000" />
                </div>
              </div><!--./form-group-->

              <div class="form-group">
                <label class="col-sm-4 control-label">Gross Salary</label>
                <div class="col-sm-8">
                  <input class="form-control form-border" name="gross_salary" id="gross_salary" value="0" type="text" />
                </div>
              </div><!--./form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label">Tax</label>
                <div class="col-sm-8 deductiondred">
                  <input class="form-control form-border" name="tax" id="tax" value="0" type="text" />
                </div>
              </div><!--./form-group-->

              <hr/>
              <div class="form-group">
                <label class="col-sm-4 control-label">Net Salary</label>
                <div class="col-sm-8 net_green">
                  <input class="form-control greentest form-border"  name="net_salary" id="net_salary"  type="text" />
                  <span class="text-danger" id="err"></span>

                  <input class="form-control" name="staff_id" value="{{$staff->user_id}}"  type="hidden" />

                  <input class="form-control" name="month" value="{{$month}}"  type="hidden" />
                  <input class="form-control" name="year" value="{{$year}}"  type="hidden" />
                  <input type="hidden" name="role" value="{{$role}}">
                  <input type="hidden" name="aliase" value="{{$aliase}}">
                  <input class="form-control" name="status" value="generated"  type="hidden" />

                </div>
              </div><!--./form-group-->
            </div>

          </div>
        </div>

        <div class="clearfix"></div>
        <div style="margin-top: 10px;">


          <input type="hidden" name="stype" id="stype">
          <input type="submit" name="save" value="save" id="save" class="btn btn-info pull-right">

          <div id="errhere"></div>

        </div>
      </div>
    </form>
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



    $(document).on("click","#earnplus",function(e){
      e.preventDefault();
      
      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('genearn') }}',
        type: 'get',
        success: function(data){ 
          $("#addearn").append(data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

    });


    $(document).on("click",".earnminus",function(e){
      e.preventDefault();
      var val = $(this).attr("cid");
      $("#"+val).remove();
    });


    $(document).on("click","#deductplus",function(e){
      e.preventDefault();
      
      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('gendeduct') }}',
        type: 'get',
        success: function(data){ 
          $("#adddeduction").append(data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

    });


    $(document).on("click",".deducminus",function(e){
      e.preventDefault();
      var val = $(this).attr("cid");
      $("#"+val).remove();
    });


     $(document).on("submit","#claculate",function(e){
      e.preventDefault();
      var month = "{{$month}}";
      var year = '{{$year}}';
      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{ route('calculate_payroll') }}',
        type: 'post',
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        data: new FormData(this),        
        success: function(data){ 
          //$("#errhere").html(data);
          if(data.msg == 'calculate'){
            $("#total_allowance").val(data.totalearn);
            $("#total_deduction").val(data.totaldeduc);
            $("#gross_salary").val(data.gross);
            $("#tax").val(data.tax);
            $("#net_salary").val(data.net);
          }


          if(data.msg == 'save'){
            toastr.success(data.datas);
            //$("#errhere").html();
            window.location.href='/HumanResource/Staff-payroll?year='+year+'&month='+month;
          }


        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  
    });



    $(document).on("click","#save",function(){
      $("#stype").val('save');
    });


    $(document).on("click","#calcu",function(){
      $("#stype").val('calcu');
    });




  });

</script>


@endsection