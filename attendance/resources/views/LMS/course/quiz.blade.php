@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Online Quiz
@endsection

@section('mtitle')
LMS Online Quiz
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Online Quiz</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                  <th>Title</th>
                                  <th>Course code</th>
                                  <th>Minutes</th>
                                  <th>Description</th>
                                  <th>Total Questions</th>
                                  <th>Retryable</th>
                                  <th>Start</th>
                              </tr>
                            </thead>
                            <tbody>
                               @forelse($data as $row)
                               <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$row->title}}</td>
                                  <td>{{$row->coursecode}}</td>
                                  <td>{{$row->minutes}} min</td>
                                  <td>{{$row->description}}</td>
                                  <td>{{$row->questiontoshow}}</td>
                                  <td>{{$row->retry}}</td>

                                  <?php
                                  $core = \App\ExamScore::where('exam_id',$row->id)
                                  ->where('user_id',auth()->user()->id)->first();
                                  ?>
                                  <!-- Check if exams has retry -->
                                  @if($row->retry == 'Yes')

                                  <td>
                                      <a href="{{route('lms-tests-quiz-start', ['id'=>$row->id, 'code' => $row->coursecode])}}" class="btn btn-info" onclick="return confirm('Start Examination Now')"> <i class="fa fa-refresh"> </i>Try Exams</a>
                                  </td>

                                  @else

                                  @if($core)

                                  <td>
                                      <a href="#" class="btn btn-danger"><i class="fa fa-refresh"></i>Completed</a>
                                  </td>

                                  @else
                                  <td>
                                      <a href="{{route('lms-tests-quiz-start', ['id'=>$row->id, 'code' => $row->coursecode])}}" class="btn btn-info" onclick="return confirm('Start Examination Now, Once started, You can Start it again')"> <i class="fa fa-windows"> </i>Start Exams</a>
                                  </td>

                                  @endif

                                  @endif
                              </tr>
                              @empty
                          <div class="alert alert-danger">
                            <h4>oowp!</h4>
                            <p>There are currently no Quiz (exams) Published Yet.</p>
                          </div>

                        @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>



@endsection



  @section('script')

  <script type="text/javascript">
    $('document').ready(function(){

      localStorage.removeItem("counter");

    });

  </script>
  @endsection