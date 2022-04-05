@extends('layouts.manage')
@section('title' ,'View All Category')

@section('content')

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
            <th>ID</th>
            <th>Category Name</th>
            <th>Category Slug</th>
            <th>Created at</th>
            <th>Updated at</th>
            </thead>
            <tbody>
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->created_at->format('dS F, Y') }}</td>
                <td>{{ $category->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
