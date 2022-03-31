@php
    $layout =Modules\AdminRbac\Utils\RbacHelper::LAYOUT;
@endphp
@extends($layout)

@section('content')
    <div class="hpanel">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('users') }}" aria-expanded="true"><strong>Users</strong></a></li>
                <li class=""><a href="{{ route('groups') }}" aria-expanded="false">Groups</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            @include('adminrbac::users.filter')
                            <div class="col-md-4 text-right">
                                <a href="{{ route('users.create') }}" class="btn btn-success">ADD NEW <i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped gds-table">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>User Roles</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @php
                                            $groups = $user->groups->pluck('name')->toArray();
                                        @endphp
                                        <td><strong>{{ join(' | ', $groups) }}</strong></td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>
                                            @if($user->isSuperAdmin->count() == 0)
                                                @if($user->status)
                                                    <span class="label label-success">Active</span> <a
                                                        href="{{ route('users.status',$user->id) }}"
                                                        class="text-danger"><strong>Change</strong></a>
                                                @else
                                                    <span class="label label-warning">In-Active</span> <a
                                                        href="{{ route('users.status',$user->id) }}"
                                                        class="text-danger"><strong>Change</strong></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(auth()->guard('admin')->user())
                                                @if($user->isSuperAdmin->count() == 0)
                                                    <a href="{{ route('users.edit',[$user->id]) }}"
                                                       class="btn btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button data-toggle="modal" data-target="#password-modal"
                                                            class="btn btn-success password" title="change password"
                                                            data-url="{{ route('users.reset-password',$user->id) }}">
                                                        <i class="fa fa-lock"></i>
                                                    </button>
                                                    <button data-toggle="modal" data-target="#delete-modal"
                                                            data-url="{{ route('users.delete',$user->id) }}"
                                                            class="btn btn-danger delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data available in the table ...</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8">{{ $users->appends(request()->all())->links() }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('commons.delete_modal')
    <div class="modal" id="password-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="pass-form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" id="new-pass" name="new_password" class="form-control"
                                   placeholder="*******" required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="pw-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        $(document).on('click', '.password', function () {
            var actionUrl = $(this).attr('data-url');

            $('#pass-form').attr('action', actionUrl);


            $('#pw-submit').click(function (e) {
                var newPass = $('#new-pass').val();

                if (newPass && newPass.length > 6) {
                    $(this).attr('disabled', true);
                    $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
                    $('#pass-form').submit();
                } else {
                    $('#new-pass').parent().addClass('has-error');
                    $('#new-pass').next('.help-block').remove();
                    $('#new-pass').after('<span class="help-block">Password must be at least 6 character length.</span>');
                    e.preventDefault();
                }
            })
        });
    </script>
@endsection
