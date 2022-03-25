@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Attendance
@endsection

@section('mtitle')
LMS Attendance
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Attendance</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <div id="showAttendance">

                    <div class="row">

                      <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-info cardbg">
                          <div class="inner">
                            <h4>{{$totalpresent}}</h4>
                            <p>Total Present</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check-square"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-info cardbg">
                      <div class="inner">
                         <h4>{{$totallate}}</h4>
                         <p>Total Late</p>
                     </div>
                     <div class="icon">
                      <i class="fa fa-check-square"></i>
                  </div>
              </div>
          </div>

          <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-info cardbg">
                <div class="inner">
                  <h4>{{$totalabsent}}</h4>
                  <p>Total Absent</p>
              </div>
              <div class="icon">
                  <i class="fa fa-check-square"></i>
              </div>
          </div>
      </div>


      <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-info cardbg">
            <div class="inner">
              <h4>{{$totalhalfday}}</h4>
              <p>Total Half Day</p>
          </div>
          <div class="icon">
              <i class="fa fa-check-square"></i>
          </div>
      </div>
  </div>


  <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-info cardbg">
        <div class="inner">
          <h4>{{$totalholiday}}</h4>
          <p>Total Holiday</p>
      </div>
      <div class="icon">
          <i class="fa fa-check-square"></i>
      </div>
  </div>
</div>


</div>
<!-- /.row -->


<div class="col-md-2">
    <div class="form-group">
      <select class="form-control" id="selectyear" >
        <option>Select Year</option>
        <option>2020</option>
        <option>2021</option>
        <option>2022</option>
        <option>2023</option>
        <option>2024</option>
    </select>
</div>
</div>


<div class="box-body">
    <table class="table table-bordered"  border="1" cellpadding="10">
      <tr>
        <th colspan="13">Present: P Late: L Absent: A Half Day: F Holiday: H</th>
    </tr>
    <tr>
        <th>Date|Month</th>
        <th>Jan</th>
        <th>Feb</th>
        <th>Mat</th>
        <th>Apr</th>
        <th>May</th>
        <th>Jun</th>
        <th>Jul</th>
        <th>Aug</th>
        <th>Sep</th>
        <th>Oct</th>
        <th>Nov</th>
        <th>Dec</th>
    </tr>
    <tbody>

        @for ($i = 1; $i < 32; $i++)





        @if (strlen($i) == '1')
        <?php
        $dp = '0'.$i;
        ?>
        @else
        <?php
        $dp = $i;
        ?>

        @endif



        <tr>
          <td>
            {{$dp}}
        </td>

        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '01' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>

        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '02' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>

        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '03' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '04' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '05' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '06' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '07' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '08' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '09' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '10' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '11' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>


        <td>
            @foreach ($attendance as $row)
            @if ($row->day == $dp && $row->month == '12' )
            {{$row->attendance}}
            @endif
            @endforeach
        </td>



    </tr>
    @endfor




</tbody>
</table>
</div>


</div>


</div>
</div>
</div>
</div>



@endsection



@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    $(document).on("change","#selectyear",function(e){
      e.preventDefault();
      var value = $(this).val();
      var studentid = '{{$studentid}}';
      var code = '{{$code}}';
      var _token = $('meta[name=csrf-token]').attr('content');

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },

        url: '{{route('lms-attendance-year-fetch')}}',
        type: 'POST',
        data: {_token : _token , studentid: studentid, code: code, value: value},
        success: function(data){ 
          $("#showAttendance").html(data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });  

      //alert(value);
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