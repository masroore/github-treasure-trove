@extends('layouts.main')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                DB STATEMENT
            </h3>
        </div>

        <form action="" method="POST" class="panel-body form-horizontal form-padding">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @csrf

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">Password</label>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
                        <small class="help-block text-danger">{{$errors->first('password')}}</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">Type</label>
                    <div class="col-md-6">
                        <select name="statement_type" class="form-control">
                            <option value="select">select</option>
                            <option value="update">update</option>
                            <option value="insert">insert</option>
                            <option value="delete">delete</option>
                            <option value="statement">statement</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">Statement</label>
                    <div class="col-md-10">
                        <textarea name="statement" class="form-control" rows="8"></textarea>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-block btn-primary" name="execute_query" value="SUBMIT">
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
