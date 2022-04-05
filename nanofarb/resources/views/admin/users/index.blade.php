@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Пользователи',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.users.create')
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список пользователей ({{ $users->total() }})</h3>
        </div>
        <div class="box-body">
            @unless($users->count())
                @include('admin.fields.empty-rows', ['url_create' => route('admin.users.create')])
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:35px;">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="width:130px;">Phone</th>
                        <th style="width:130px;">Роль</th>
                        <th style="width: 30px; text-align: center">Активный</th>
                        <th style="width:150px;">Регистрация</th>
                        <th style="width:100px;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->roles->implode('title', ', ') }}</td>
                        <td style="text-align: center">
                            @if($user->active)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td style="width: 110px">
                            <div class="btn-group">
                                {{--<a href="{{ route_alias('users.show', $user) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="#" data-url="{{ route('admin.users.destroy', $user) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endunless
        </div>

        <div class="box-footer">
            <div class="pull-right">
                @include('admin.inc.pagination', ['pages' => $users])
            </div>
        </div>
    </div>
</section>
@endsection