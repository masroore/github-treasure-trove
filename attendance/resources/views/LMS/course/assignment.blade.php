@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Assignment
@endsection

@section('mtitle')
  Assignment
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

 @if(Session::has('message'))
   <div class="callout {{Session::get('type')}}">
    <h4>{{Session::get('title')}}</h4>
    <p> {{Session::get('message')}}</p>
  </div>
  @endif



  <div class="row">

   @forelse($data as $row)
  
      <div class="col-md-4">
         <a href="{{route('lms-assignment-view',['id'=>$row->id, 'code' => $code])}}" title="{{$row->assignment_title}}">
          <div class="card">
            <img class="card-img-top" src="{{URL::to('images/assignment (2).jpg')}}" alt="Card image cap" width="291" height="200">
            <div class="card-body">
              <h5 class="card-title">{{$row->assignment_title}}</h5>
              <p class="card-text">{{Str::limit($row->assignment_description,51,'...')}}</p>
              <p class="card-text"><small class="text-muted">Last updated {{\Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</small></p>
          </div>
      </div>
      </a>
  </div>

  @empty
  <div class="alert alert-danger">
    <h4>oowp!</h4>
    <p>There are currently no Assignment(s) Posted.</p>
  </div>

@endforelse



</div>





@endsection



@section('script')

<script type="text/javascript">

</script>


@endsection