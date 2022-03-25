@extends('layouts.main')


@section('title')
@lang('school.pagetitle') | Force Logout
@endsection

@section('mtitle')
@lang('school.pagetitle') | Force Logout
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="width: 100%;">Force Logout
       </h3>
     </div>
     <div class="box-body">
       <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th></th>
            <th>User's Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $row)
          <tr>

            <td>
             @if($row->pro_pic != null)
             <img src=" {{ asset('storage' )}}/{{$row->pro_pic}}" class="img-circle" alt="User Image" width="50" height="50">

             @else
             <img src="{{ URL::to('images/user.png')}}" alt="User Image" class="img-circle" width="50" height="50">

             @endif
           </td>
           <td>{{$row->name}}</td>

          @can('Trigger Force Logout')
          
          @if($row->force_logout == 0)
          <td>

            <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('force_{{$row->id}}').submit(); }" class="btn btn-danger">Disable This Logout</a>
            <form id="force_{{$row->id}}" 
              action="{{ route('logout-user-force-update', ['id'=> $row->id ]) }}" method="POST" style="display: none;">

              @csrf
            </form>  
          </td>
          @else
          <td>

            <a href="#" onclick="if(confirm('Enable User ?')){ event.preventDefault(); document.getElementById('force_{{$row->id}}').submit(); }" class="btn btn-success"><i class='fa fa-sign-out'></i>Enable User</a>
            <form id="force_{{$row->id}}" 
              action="{{ route('logout-user-force-enable', ['id'=> $row->id ]) }}" method="POST" style="display: none;">

              @csrf
            </form>  
          </td>
          @endif

          @endcan

        </tr>
        @endforeach
      </tbody>
    </table>
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