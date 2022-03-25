@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Course Materials
@endsection

@section('mtitle')
LMS Course Materials
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Course Materials</h5>
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
                                    <th>Title(s)</th>
                                    <th>Document</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $docs)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$docs->week}}</td>
                                    <td>{{$docs->title}}</td>
                                    <td><a href="{{asset('storage')}}/{{$docs->doc}}" target="_blank" class="btn btn-success"><span class="fa fa-download"></span></a></td>
                                    
                            </tr> 
                            @empty
                          <div class="alert alert-danger">
                            <h4>oowp!</h4>
                            <p>There are currently no Course Material(s) Posted.</p>
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