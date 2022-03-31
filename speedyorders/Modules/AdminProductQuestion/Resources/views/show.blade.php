@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">ProductQuestion {{ $productquestion->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/product-question') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/product-question/' . $productquestion->id . '/edit') }}" title="Edit ProductQuestion"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/productquestion' . '/' . $productquestion->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete ProductQuestion" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $productquestion->id }}</td>
                                    </tr>
                                    <tr><th> Product Id </th><td> {{ $productquestion->product_id }} </td></tr><tr><th> Customer Id </th><td> {{ $productquestion->customer_id }} </td></tr><tr><th> Name </th><td> {{ $productquestion->name }} </td></tr><tr><th> Description </th><td> {{ $productquestion->description }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
