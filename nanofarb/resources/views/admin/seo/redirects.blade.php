@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Перенаправления путей',
        'small_page_title' => '',
        'url_back' => '',
        //'url_create' => route('admin.pages.create')
    ]
@endphp

@section('content')
    <form action="{{ route('admin.url-aliases.store') }}" method="POST">
        @csrf
        <section class="content" style="min-height: inherit">
            <div class="box box-">
                <div class="box-header with-border">
                    <h3 class="box-title">Создать запись</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group {{ $errors->has('alias') ? 'has-error' : ''}}">
                                {!! Form::label('alias', 'Alias', ['class' => 'control-label',]) !!}
                                {!! Form::text('alias', null, ['class' => 'form-control','placeholder' => 'Example: http://site.app/about-old', 'autocomplete' => 'off']) !!}
                                {!! $errors->first('alias', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group {{ $errors->has('source') ? 'has-error' : ''}}">
                                {!! Form::label('source', 'Source', ['class' => 'control-label',]) !!}
                                {!! Form::text('source', null, ['class' => 'form-control','placeholder' => 'Example: http://site.app/about', 'autocomplete' => 'off']) !!}
                                {!! $errors->first('source', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                {!! Form::label('type', 'Redirect Type', ['class' => 'control-label',]) !!}
                                {!! Form::select('type', [301 => '301 Moved Permanently', 302 => '302 Moved Temporarily'], null, ['class' => 'form-control',]) !!}
                                {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-buttons pull-right ">
                        <div role="group" class="btn-group">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список перенаправлений путей ({{ $aliases->count() }})</h3>
            </div>
            <div class="box-body">
                @unless($aliases->count())
                    @include('admin.fields.empty-rows', [])
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:35px;">#</th>
                                <th>Alias</th>
                                <th>Source</th>
                                <th>Type</th>
                                <th style="width:100px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($aliases as $item)
                                <tr>
                                    <td>{{ pagination_row_number($aliases, $loop->index) }}</td>
                                    <td>{{ link_to($item->alias, $item->alias, ['target' => '_blank']) }}</td>
                                    <td>{{ link_to($item->source, $item->source, ['target' => '_blank']) }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td style="width: 110px">
                                        <div class="btn-group">
                                            <a href="#" data-url="{{ route('admin.url-aliases.destroy', $item) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                    @include('admin.inc.pagination', ['pages' => $aliases])
                </div>
            </div>
        </div>
    </section>
@endsection