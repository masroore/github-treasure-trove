@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Словари',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.vocabularies.create')
    ]
@endphp

@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список словарей ({{ $vocabularies->total() }})</h3>
            </div>
            <div class="box-body">
                @unless($vocabularies->count())
                    @include('admin.fields.empty-rows', ['url_create' => route('admin.vocabularies.create')])
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:35px;">#</th>
                                <th>Название</th>
                                <th>Системное имя</th>
                                {{--<th>Термов</th>--}}
                                <th style="width:100px;">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vocabularies as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->name }}</td>
                                    <td>{{ $page->system_name }}</td>
                                    {{--<td>{{ $page->terms }}</td>--}}
                                    <td style="width: 110px">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.vocabularies.edit', $page) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-url="{{ route('admin.vocabularies.destroy', $page) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                    @include('admin.inc.pagination', ['vocabularies' => $vocabularies])
                </div>
            </div>
        </div>
    </section>
@stop