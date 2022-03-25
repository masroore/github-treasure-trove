@extends('layouts.main')


@section('title')

 Attendance Report For {{ $programme }} Course Code: {{ $code }} {{ $level }} {{ $session }} {{ date('M Y', strtotime($date)) }}
@endsection

@section('mtitle')
 Record Attendance
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
        <h3 class="box-title">Record Attendance</h3>
      </div>
      <div class="box-body">


          <div class="text-center m-3">
            @foreach($paginationLinks as $link)
                @if($link['year'] == $year && $link['month'] == $month)
                    <span class="mr-2 font-weight-bold">
                        {{ $link['fullName'] }} 
                    </span>
                @else
                    <a class="mr-2 font-weight-bold" href="{{ route('attendance-report-generate',['level' => $level, 'code' => $code, 'programme' => $programme, 'session' => $session, 'date' => $link['date']->format('Y-m-d')]) }}">
                        {{ $link['fullName'] }} 
                    </a>
                @endif
            @endforeach
        </div>

        @php

        $sub = $daysInMonth - (8+5+5);

        @endphp

        <form action="{{ route('attendance-fetch-student-save') }}" method="post">
            @csrf

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped datatable">
                    <thead>
                      <tr>
                            <th style="width: 85px">Students/Days</th>
                            @for($i = 1; $i <= $daysInMonth; $i++)
                                <th style="width: 5px">{{ $i }}</th>
                            @endfor
                        </tr>

                         <tr>
                            <th colspan="2"> {{ $programme }}</th>
                            <th colspan="8"> Course Code: {{ $code }}</th>
                            <th colspan="5"> {{ $level }}</th>
                            <th colspan="5"> {{ $session }}</th>
                            <th colspan="{{ $sub }}"> {{ date('M Y', strtotime($date)) }}</th>
                        </tr>
                        
                    </thead>

                    <tbody>


                      
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->fullname }}</td>
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    <td style="width: 5px">

                                        <?php

                                            $day = now()->setYear($year)->setMonth($month)->setDay($i)->format('Y-m-d')

                                        ?>

                                        {!! isset($attendance[$student->indexnumber][$day]) ? '<i class="btn btn-info">P</i>' : '<input type="checkbox" name="" value="">' !!}

                                    </td>
                                @endfor
                            </tr>
                        @endforeach

                        
                    </tbody>
                </table>
            </div>
            {{-- <input type="submit" class="btn btn-success pull-right" value="Save attendance" /> --}}
        </form>
                   
                    
      </div>
    </div>
  </div>
</div>

@endsection



@section('script')

<script type="text/javascript">
  $('document').ready(function(){




  });

</script>


@endsection