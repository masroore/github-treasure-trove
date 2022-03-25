@extends('layouts.main')


@section('title')
  OSMS | Add Permissions
@endsection

@section('mtitle')
  OSMS | Add Permissions
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="width: 100%;">Menu | Permissions | Assign for {{$role->name}}

          <a href="{{$_SERVER['HTTP_REFERER']}}" class="fa fa-angle-double-left btn btn-primary pull-right" title="Go Back"></a>

        </h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{ route('assingn-role-to-permission-save') }}">
          @csrf
          <input type="hidden" name="roleid" value="{{$role->id}}">
          @foreach($data as $row)

          <?php
          $id = $row->id;

          $submenu = App\SubMenu::where('menu_id',$id)->get();

          $submenuper = App\Menupermission::where('menu_id',$id)->first();


          $subpermission = Spatie\Permission\Models\Permission::where('id', $submenuper->permission_id ?? 0)->first();

              //dd($subpermission);


          ?>
          <div class="row">
            <div class="col-md-5">
              <li style="padding: 5px; background-color: #abc;">
                {{$row->title}}</li>
              </div>
              <div class="col-md-6">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="permissions[]" value="
                    {{$subpermission->name ?? ''}}"

                    @if($role->permissions->pluck('id')->contains($subpermission->id ?? '' )) checked
                    @endif

                    >
                    {{$subpermission->name ?? ''}}
                  </label>
                </div>
              </div>
              <div class="col-md-1">

              </div>
            </div>

            @foreach ($submenu as $sub)

            <div class="row">
              <div class="col-md-5">
                <li style="padding: 5px; background-color: #000;color: white;">{{$sub->sub_menu}}</li>
              </div>
              <div class="col-md-6">
                <?php
                $permission = App\Menupermission::where('sub_menu_id',$sub->id)->get();
                ?>

                @foreach ($permission as $per)
                <?php
                $perid = $per->permission_id;
                $pernames = Spatie\Permission\Models\Permission::where('id',$perid)->get();
                ?>
                @foreach ($pernames as $rows)
                @if ($rows->name == $subpermission->name)


                @else

                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="permissions[]" value="
                    {{$rows->name}}" 

                     @if($role->permissions->pluck('id')->contains($rows->id)) checked
                     @endif
                    >
                    {{$rows->name}}
                  </label>
                </div>

                @endif

                @endforeach
                @endforeach
              </div>
              <div class="col-md-1">
                {{-- <a href="{{ route('edit-permission',['id'=> $sub->id]) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-danger fa fa-trash" title="Delete {{$sub->sub_menu}}"></a> --}}
              </div>
            </div>

            @endforeach

            <hr>

            @endforeach

            <input type="submit" value="Assign Permission" name="submit" class="btn btn-success pull-right">
          </form>
        </div>
      </div>
    </div>
  </div>

{{-- <div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{route('assingn-role-to-permission-save')}}">
          @csrf
          <label>Check Permssions To Assign for <h3>{{$role->name}}</h3></label>
          <input type="hidden" name="roleid" value="{{$role->id}}">
            <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>User Permissions for {{$role->name}}</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($Permission as $row)
                        <tr>
                          <td>
                            <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{$row->id}}" class="custom-control-input" id="customCheck1" name="permissions[]"
                          @if($role->permissions->pluck('id')->contains($row->id)) checked
                          @endif
                        >
                      </div>
                    </div>
                          </td>
                          <td>{{$row->name}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                 </table>
              </div>    
            <input type="submit" name="submit" value="Assign Permission(s) to Role" class="btn btn-success">
        </form> 
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Role</th>
                      <th>Permission</th>
                      <th>Edit Perm</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($role_per as $row)
                        <tr>
                          <td>{{$row->name}}</td>
                          <td>
                    {{ implode(', ', $row->permissions->pluck('name')->toArray())}}
                          </td>
                          <td>
              <form action="{{ route('edit-role-assign-to-permission', ['id'=> $row->id ]) }}" method="POST">
                    @csrf
                    <input type="submit" name="submit" class="btn btn-info" value="Edit">
                    
                       </form>  

                </td>
                        </tr>
                      @endforeach
                    </tbody>
                 </table>
      </div>
    </div>
  </div>                 
</div> --}}
@endsection




@section('script')

<script type="text/javascript">
  $('document').ready(function(){

  });

</script>


@endsection
