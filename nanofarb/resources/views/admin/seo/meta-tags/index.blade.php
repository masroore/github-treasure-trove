@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Мета-теги путей',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.meta-tags.create')
    ]
@endphp

@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список мета-тегов ({{ $metaTags->total() }})</h3>
            </div>
            <div class="box-body">
                @unless($metaTags->count())
                    @include('admin.fields.empty-rows', ['url_create' => route('admin.meta-tags.create')])
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @if(empty(request('type')) || request('type') == 'path')
                                <th>Path</th>
                                @endif
                                <th>Title</th>
                                <th>Description</th>
                                <th>Keywords</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($metaTags as $metaTag)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if(empty(request('type')) || request('type') == 'path')
                                    <td>{{ link_to(url($metaTag->path), str_limit($metaTag->path, 50), ['target' => '_blank']) }}</td>
                                    @endif
                                    <td>{{ $metaTag->title }}</td>
                                    <td>{{ str_limit($metaTag->description) }}</td>
                                    <td>{{ str_limit($metaTag->keywords) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            {{--<a href="" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                            <a href="{{ route('admin.meta-tags.edit', [$metaTag, 'type' => request('type')]) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-url="{{ route('admin.meta-tags.destroy', $metaTag) }}" class="btn btn-xs btn-danger js-delete-action"><i class="fa fa-remove"></i></a>
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
                    @include('admin.inc.pagination', ['pages' => $metaTags])
                </div>
            </div>
        </div>
    </section>
@endsection