@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="hpanel">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li><a  href="{{ route('users') }}" aria-expanded="true">Users</a></li>
                    <li class="active"><a  href="{{ route('groups') }}" aria-expanded="false"><strong>Groups</strong></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form method="POST" action="{{ route('groups.store') }}">
                                <table class="table  table-bordered adminMgmtTable gds-table">
                                    <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th class="text-center">Status</th>
                                        <th>Operation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>#</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Eg: Normal User">
                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox">
                                                <input id="status" class="i-checks" type="radio" name="status" value="1" checked>
                                                <label for="status" style="color:#000000;">Active</label>
                                                <input id="status-2" class="i-checks" type="radio" name="status" value="0">
                                                <label for="status-2" style="color:#000000;">Inactive</label>
                                            </div>
                                            <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                        </td>
                                        <td>
                                            @csrf
                                            <button class="btn btn-success btn-block">CREATE</button>
                                        </td>
                                    </tr>

                                    @if( count($groups) > 0 )

                                        @foreach($groups as $k => $g)
                                            <tr>
                                                <td align="center">{{ ++$k }} </td>
                                                <td>
                                                    @if($g->id == \RbacHelper::SUPER_ADMIN_ROLE)
                                                        <strong>{{ strtoupper($g->name) }}</strong>
                                                    @else
                                                        {{ $g->name }}
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    {!!  $g->status  ? '<strong style="color:green;">Active</strong>' : '<strong style="color:#bf302f;">Inactive</strong>' !!}
                                                </td>
                                                <td width="230">

                                                    @if($g->id == \RbacHelper::SUPER_ADMIN_ROLE)
                                                        <span class="text-pink text-semibold">You cannot edit this role.</span>
                                                    @else
                                                        <a href="{{ route('groups.edit-permission',$g->id) }}"
                                                           class="btn btn-success" title="Edit Role's Permission"><i
                                                                    class="fa fa-key"></i></a>

                                                        @if(!in_array($g->user_id, [\RbacHelper::SUPER_ADMIN_ROLE,\RbacHelper::DEFAULT_ROLE]))
                                                            <a href="{{ route('groups.edit',$g->id) }}"
                                                               class="btn btn-info" title="Edit User Roles"><i
                                                                        class="fa fa-edit"></i></a>
                                                            <a data-toggle="modal" data-target="#delete-modal"
                                                               class="btn btn-danger delete"
                                                               data-url="{{ route('groups.delete',$g->id) }}"><i
                                                                        class="fa fa-trash"></i></a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td align="center" colspan="10">
                                                User Groups not found. &nbsp;
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('commons.delete_modal')
@stop

@section('ext_js')
    <script>
        $(document).on('click', '.delete', function () {
            var actionUrl = $(this).attr('data-url');

            $('#delete-form').attr('action', actionUrl);

            $('#modal-submit').click(function (e) {
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
                $('#delete-form').submit();
            })
        });
    </script>
@endsection
