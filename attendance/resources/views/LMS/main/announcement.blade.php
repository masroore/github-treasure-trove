@extends('LMS.layout')


@section('title')
OSMS | LMS | Announcements
@endsection

@section('mtitle')
LMS Announcements
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Announcements</h5>
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
                                    <th>Cource Code</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $rows)
                                

                                <?php
                                    $lecd = $rows->lecid;
                                    $announ = App\model\LMS\Announcement::where('user_id',$lecd)->get();
                                ?>
                                @foreach ($announ as $row)
                                    <tr>
                                      <td>{{$loop->iteration}}</td>
                                      <td>{{$row->course_code}}</td>
                                      <td>{{$row->title}}</td>
                                      <td>{{$row->message}}</td>
                                   </tr>
                                @endforeach

                              @empty

                              <div class="alert alert-danger">
                                <h4>oowp!</h4>
                                <p>There are currently no announcements at this location.</p>
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