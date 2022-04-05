@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Новости',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.news.create')
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список новостей ({{ $nodes->total() }})</h3>
        </div>
        <div class="box-body">
            @unless($nodes->count())
                @include('admin.fields.empty-rows', ['url_create' => route('admin.news.create')])
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:35px;">#</th>
                        <th>Название</th>
                        <th style="text-align: center">Опубликовано</th>
                        <th style="width:100px;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nodes as $node)
                    <tr>
                        <td>{{ $node->id }}</td>
                        <td>{{ $node->name }}</td>
                        <td style="text-align: center">
                            @if($node->publish)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif
                        </td>

                        <td style="width: 110px">
                            <div class="btn-group">
                                <a href="{{ route_alias('news.show', $node) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.news.edit', $node) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="#" data-url="{{ route('admin.news.destroy', $node) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                @include('admin.inc.pagination', ['news' => $nodes])
            </div>
        </div>
    </div>
</section>
@endsection