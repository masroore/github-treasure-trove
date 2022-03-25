@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Zoom Meeting
@endsection

@section('mtitle')
LMS Zoom Meeting
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="alert alert-success">
 You Can Either Join From Your Phone Using The Meeting ID Or Click On Join, To Join The Meeting Using Your Browser... 
</div>

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Zoom Meeting</h5>
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
                                  <th>Meeting Title</th>
                                  <th>Meeting ID</th>
                                  <th>Lecture Name</th>
                                  <th>Meeting Starts</th>
                                  <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$row->title}}</td>
                                  <td>{{$row->zoomid}}</td>
                                  <td>{{$row->lec_name}}</td>
                                  <td>{{\Carbon\Carbon::parse($row->starttime)->diffForHumans() }}</td>
                                  <td>
                                      <a href="{{$row->join_url}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-user-plus"></i>Join Meeting</a>
                                  </td>
                            </tr>
                            @empty
                            <div class="alert alert-danger">
                              <h4>oowp!</h4>
                              <p>There are currently no Meeting Posted.</p>
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