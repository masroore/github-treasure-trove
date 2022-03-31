@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">adminproductoption {{ $adminproductoption->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/adminproductoption') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/adminproductoption/' . $adminproductoption->id . '/edit') }}" title="Edit adminproductoption"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/adminproductoption' . '/' . $adminproductoption->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete adminproductoption" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $adminproductoption->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $adminproductoption->name }} </td></tr><tr><th> Type </th><td> {{ $adminproductoption->type }} </td></tr><tr><th> Sort Order </th><td> {{ $adminproductoption->sort_order }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
