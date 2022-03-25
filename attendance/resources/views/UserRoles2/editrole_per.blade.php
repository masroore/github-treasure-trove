@extends('layouts.main')


@section('title')
  Edit User Role / Permission
@endsection

@section('mtitle')

@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-12">
    <a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-primary pull-right" title="Go Back">Go Back</a>
  </div>
</div>


<div class="row">
  <!-- left column -->
  <div class="col-md-4">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit User Role / Permission

        </h3>
      </div>
      <div class="box-body">
       <form method="post" action="{{route('edit-role-update')}}">
          @csrf
          <input type="hidden" name="hiddenid" value="@if(isset($role->id)) {{$role->id}} @endif">
          <input type="hidden" name="type" value="role">
          <div class="form-group  @error('role') has-error @enderror">
                 <label class="control-label" for="inputError">Edit Role</label>
                 <input type="text" value="@if(isset($role->name)) {{$role->name}} @endif" class="form-control" name="role" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('role') {{ $message }} @enderror</span>
            </div>
            
            <input type="submit" name="submit" value="Update Role" class="btn btn-success">
        </form> 

        <hr>

        <form method="post" action="{{route('edit-perm-update')}}">
          @csrf
          <input type="hidden" name="hiddenid" value="@if(isset($Permission->id)) {{$Permission->id}} @endif">
          <input type="hidden" name="type" value="perm">
          <div class="form-group  @error('Permission') has-error @enderror">
                 <label class="control-label" for="inputError">Edit Permission</label>
                 <input type="text" class="form-control" name="Permission" id="inputError" value="@if(isset($Permission->name)) {{$Permission->name}} @endif" placeholder="Enter ... Permission">
                  <span class="help-block">@error('Permission') {{ $message }} @enderror</span>
            </div>
            
            <input type="submit" name="submit" value="Update Permission" class="btn btn-success">
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