@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Lesson Plan
@endsection

@section('mtitle')
LMS Lesson Plan
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Lesson Plan</h5>
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
                                    <th>#</th>
                                    <th>Week</th>
                                    <th>Topic(s)</th>
                                    <th>Aims</th>
                                    <th>Objectives</th>
                                    <th>Learning Materials</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$row->week}}</td>
                                  <td>{{$row->topic}}</td>
                                  <td>{{$row->aims}}</td>
                                  <td>{{$row->obj}}</td>
                                  <td>{{$row->materials}}</td>
                            </tr>
                            @empty
                          <div class="alert alert-danger">
                            <h4>oowp!</h4>
                            <p>There are currently no Lesson Plan Posted.</p>
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

</script>


@endsection