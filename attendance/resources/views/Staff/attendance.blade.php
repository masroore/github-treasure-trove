<div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-default cardbg">
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
          <div class="small-box bg-default cardbg">
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
        <div class="small-box bg-default cardbg">
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
        <div class="small-box bg-default cardbg">
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
        <div class="small-box bg-default cardbg">
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
        <label class="control-label" for="inputSuccess">Year</label>
        <select class="form-control" id="selectyear" >
          <option></option>
          <option @if ($year == '2020')
            selected="true" 
          @endif>2020</option>
          <option @if ($year == '2021')
            selected="true" 
          @endif>2021</option>
          <option @if ($year == '2022')
            selected="true" 
          @endif>2022</option>
          <option @if ($year == '2023')
            selected="true" 
          @endif>2023</option>
          <option @if ($year == '2024')
            selected="true" 
          @endif>2024</option>
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