@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Edit Group
                    <span class="pull-right"><strong class="text-danger">*</strong> Required Fields</span>
                </h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('groups.update',$group->id) }}" method="POST" class="panel-body form-horizontal form-padding" enctype="multipart/form-data">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="demo-address-input">Group Name <span class="required_color">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $group->name }}">
                                <small class="help-block text-danger">{{$errors->first('name')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="demo-contact-input">Status</label>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    <input id="status" class="i-checks" type="radio" name="status" value="1" {{ $group->status  ? "checked" : "" }}>
                                    <label for="status" style="color:#000000;">Active</label>
                                    <input id="status-2" class="i-checks" type="radio" name="status" value="0" {{ $group->status == 0 ? "checked" : "" }}>
                                    <label for="status-2" style="color:#000000;">Inactive</label>
                                </div>
                                <small class="help-block text-danger">{{ $errors->first('status')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-5">
                                <input type="submit" class="btn btn-block btn-info" name="submit" value="UPDATE">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
