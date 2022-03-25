
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Select Criteria</h3>
      </div>
      <div class="box-body">

        <div class="text-center m-3">
            @foreach($paginationLinks as $link)
                @if($link['year'] == $year && $link['month'] == $month)
                    <span class="mr-2 font-weight-bold">
                        {{ $link['fullName'] }}
                    </span>
                @else
                    <a class="mr-2 font-weight-bold" href="#">
                        {{ $link['fullName'] }}
                    </a>
                @endif
            @endforeach
        </div>

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
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->fullname }}</td>
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    <td style="width: 5px">
                                        <input
                                            type="checkbox"
                                            name="student_{{ $student->indexnumber }}[]"
                                            value="{{ $day = now()->setYear($year)->setMonth($month)->setDay($i)->format('Y-m-d') }}"

                                            {{ isset($attendance[$student->indexnumber][$day]) ? 'checked' : '' }}
                                        >
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <input type="submit" class="btn btn-success pull-right" value="Save attendance" />
        </form>

      </div>
    </div>
  </div>
</div>


