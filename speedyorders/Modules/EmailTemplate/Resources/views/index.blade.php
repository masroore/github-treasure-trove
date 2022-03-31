@extends('layouts.main')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Email Templates
        </h3>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12 table-responsive m-t-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Template Name</th>
                            <th>Template Subject</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $template)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>
                                <a href="{{ route('admin.email.edit', $template)}}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <em>No data available in table ...</em>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
