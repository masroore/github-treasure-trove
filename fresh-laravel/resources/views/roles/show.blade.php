 @extends('layouts.admin')
 @section('title', 'Roles')
 @section('content')
     <div class="main-content">
         <section class="section">
             <div class="section-header">
                 <h1>Roles Show</h1>
                 <div class="section-header-breadcrumb">
                     <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                     <div class="breadcrumb-item active"><a href="{{ route('roles.index') }}">Roles</a></div>
                     <div class="breadcrumb-item">Roles Show</div>
                 </div>
             </div>
             <div class="col-md-6 m-auto">
                 <div class="card">
                     <div class="card-header"><strong>{{ __('Add/Edit Permissions to ') }} {{ $role->name }}
                             {{ __(' Role') }}
                         </strong> </div>
                     <div class="card-body">
                         {!! Form::model($role, ['method' => 'POST', 'route' => ['roles_permit', $role->id]]) !!}

                         @csrf
                         <div class="card-body">
                             <table class="table table-flush permission-table">
                                 <thead class="thead-light">
                                     <tr>
                                         <th width="200px">{{ __('Module') }}</th>
                                         <th>{{ __('Permissions') }}</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($moduals as $row)
                                         <tr>
                                             <td> {{ __(ucfirst($row)) }}</td>
                                             <td>
                                                 <div class="row">
                                                     <?php $default_permissions = ['manage', 'create', 'edit', 'delete', 'show']; ?>
                                                     @foreach ($default_permissions as $permission)
                                                         @if (in_array($permission . '-' . $row, $allpermissions))
                                                             @php($key = array_search($permission . '-' . $row, $allpermissions))
                                                             <div class="col-3 custom-control custom-checkbox">
                                                                 {{ Form::checkbox('permissions[]', $key, in_array($permission . '-' . $row, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                                 {{ Form::label('permission_' . $key, ucfirst($permission), ['class' => 'custom-control-label']) }}
                                                             </div>
                                                         @endif
                                                     @endforeach
                                                 </div>
                                             </td>
                                         </tr>
                                     @endforeach
                                     <?php $modules = []; ?>
                                     @foreach ($modules as $module)
                                         <?php $s_name = $module; ?>
                                         <tr>
                                             <td>
                                                 {{ __(ucfirst($module)) }}
                                             </td>
                                             <td>
                                                 <div class="row">
                                                     @if (in_array('manage-' . $s_name, $allpermissions))
                                                         @php($key = array_search('manage-' . $s_name, $allpermissions))
                                                         <div class="col-3 custom-control custom-checkbox">
                                                             {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                             {{ Form::label('permission_' . $key, __('Manage'), ['class' => 'custom-control-label']) }}
                                                         </div>
                                                     @endif
                                                     @if (in_array('create-' . $module, $allpermissions))
                                                         @php($key = array_search('create-' . $module, $allpermissions))
                                                         <div class="col-3 custom-control custom-checkbox">
                                                             {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                             {{ Form::label('permission_' . $key, __('Create'), ['class' => 'custom-control-label']) }}
                                                         </div>
                                                     @endif
                                                     @if (in_array('edit-' . $module, $allpermissions))
                                                         @php($key = array_search('edit-' . $module, $allpermissions))
                                                         <div class="col-3 custom-control custom-checkbox">
                                                             {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                             {{ Form::label('permission_' . $key, __('Edit'), ['class' => 'custom-control-label']) }}
                                                         </div>
                                                     @endif
                                                     @if (in_array('delete-' . $module, $allpermissions))
                                                         @php($key = array_search('delete-' . $module, $allpermissions))
                                                         <div class="col-3 custom-control custom-checkbox">
                                                             {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                             {{ Form::label('permission_' . $key, __('Delete'), ['class' => 'custom-control-label']) }}
                                                         </div>
                                                     @endif
                                                     @if (in_array('view-' . $module, $allpermissions))
                                                         @php($key = array_search('view-' . $module, $allpermissions))
                                                         <div class="col-3 custom-control custom-checkbox">
                                                             {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'custom-control-input', 'id' => 'permission_' . $key]) }}
                                                             {{ Form::label('permission_' . $key, __('show'), ['class' => 'custom-control-label']) }}
                                                         </div>
                                                     @endif
                                                 </div>
                                             </td>
                                         </tr>
                                 </tbody>
                                 @endforeach
                             </table>
                             <div class="col-sm-12 mx-auto">
                                 {{ Form::submit(__('Update Permission'), ['class' => 'btn btn-primary ']) }}
                                 <a class="btn btn-secondary" href="{{ route('roles.index') }}">
                                     {{ __('Back') }}</a>

                             </div>
                         </div>
                         </form>
                     </div>
                 </div>
             </div>
         @endsection
