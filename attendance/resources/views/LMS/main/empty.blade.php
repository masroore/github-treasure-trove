@extends('LMS.course_layout')


@section('title')
OSMS | LMS | No Information
@endsection

@section('mtitle')
LMS No Information
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="alert alert-warning">No Records Found, Please make sure you enrol for the Course <br>
                <a href="{{ route('lms-site-overview') }}" class="btn btn-sm btn-info">Enroll Now</a>
                </div>
            </div>
    </div>
</div>



@endsection



@section('script')

<script type="text/javascript">

</script>


@endsection