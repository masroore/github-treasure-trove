@php
    $layout =Modules\AdminRbac\Utils\RbacHelper::LAYOUT;
@endphp
@extends($layout)

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Edit User
                    <span class="pull-right"><strong class="text-danger">*</strong> Required Fields</span>
                </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('users.update',$user->id) }}" method="POST" class="form-horizontal form-padding" enctype="multipart/form-data">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="admin-first-name">Full Name <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" id="admin-first-name" name="first_name" class="form-control" value="{{ old('first_name',$user->first_name) }}" placeholder="First Name" >
                                <small class="help-block text-danger">{{$errors->first('first_name')}}</small>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="admin-last-name" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name" >
                                <small class="help-block text-danger">{{$errors->first('last_name')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="demo-address-input">Contact</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="contact" value="{{ old('contact',$user->contact) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="demo-address-input">Username <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="username" value="{{ old('username',$user->username) }}">
                                <small class="help-block text-danger">{{$errors->first('username')}}</small>
                            </div>
                            <label class="col-md-1 control-label" for="demo-address-input">Email<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="email" value="{{ old('email',$user->email) }}">
                                <small class="help-block text-danger">{{$errors->first('email')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Roles <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    @if( count($groups) >0 )
                                        @foreach($groups as $g)
                                            <input id="group-{{$g->id}}" class="i-checks" type="checkbox" name="groups[]" value="{{ $g->id }}" {{ in_array($g->id,$current_groups) ? "checked" : '' }}>
                                            <label for="group-{{$g->id}}" style="color: #000023;">{{ $g->name }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                @if($errors->has('groups'))
                                    <small class="help-block text-danger">Please select at least one role</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="demo-contact-input">Status</label>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    <input id="status" class="i-checks" type="radio" name="status" value="1"
                                           {{ $user->status ? 'checked' :'' }}>
                                    <label for="status" class="text-left">Active</label>
                                    <span style="margin-left: 10px;"></span>
                                    <input id="status-2" class="i-checks" type="radio" name="status" value="0"
                                            {{ $user->status == 0 ? 'checked' :'' }}>
                                    <label for="status-2">Inactive</label>
                                </div>
                            </div>
                        </div>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-2"></label>
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-block btn-info" name="submit" value="UPDATE">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
