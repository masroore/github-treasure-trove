@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Role Permissions

                </h3>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <form method="POST" action="{{ route('groups.edit-permission',$group->id) }}">
                        @csrf
                        <table class="table  table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">
                                    <div class="checkbox" style="margin-top: 0px;margin-bottom: 0px;">
                                        <input id="select-all" class="i-checks" type="checkbox">
                                        <label for="select-all" style="color: #000023;"></label>
                                    </div>
                                </th>
                                <th>Permission Name</th>
                                <th>Permission Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count( $modules ) > 0 )
                                @foreach( $modules as $module )
                                    <tr>
                                        <td></td>
                                        <td colspan="5">
                                            <strong>{{ strtoupper( $module->name ) }}</strong>
                                        </td>
                                    </tr>
                                    @if ( isset( $module->permissionReferences ) && $module->permissionReferences->count() > 0 )
                                        @foreach( $module->permissionReferences as $reference )
                                            <tr>
                                                <td class="text-center">
                                                    <div class="checkbox" style="margin-top: 0px;margin-bottom: 0px;">
                                                        <input id="permission-{{ $reference->id }}" class="i-checks permission" type="checkbox" name="permission_reference_id[]" value="{{ $reference->id }}" {{ in_array($reference->id,$group_permission) ? "checked" : ""}}>
                                                        <label for="permission-{{ $reference->id }}" style="color: #000023;"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $reference->short_desc }}</td>
                                                <td>{{ $reference->description }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">
                                        <strong>No records found !!!</strong>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        <div class="form-group">
                            <div class="col-md-3">
                                <input type="submit" class="btn btn-block btn-success" name="submit" value="UPDATE PERMISSIONS">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop
@section('ext_js')
    <script type="text/javascript">
        $(function(){
            $('#select-all').on('ifChanged', function(event) {
                if($(this).is(':checked')){

                    $(this).closest('form').find('input.permission').iCheck('check');
                }else {
                    $(this).closest('form').find('input.permission').iCheck('uncheck');
                }
            });

        })
    </script>
@endsection
