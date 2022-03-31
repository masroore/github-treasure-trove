@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Change Password
                    <span class="pull-right"><strong class="text-danger">*</strong> Required Fields</span>
                </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('users.reset-password') }}" method="POST" class="form-horizontal form-padding" enctype="multipart/form-data">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <p class="text-center">
                                <strong>You will be asked to login again after updating the password.</strong>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Current Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="current_password" placeholder="******">
                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">New Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="new_password" placeholder="******">
                                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="confirm_password" placeholder="******">
                                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                            </div>
                        </div>
                        @csrf
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
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
