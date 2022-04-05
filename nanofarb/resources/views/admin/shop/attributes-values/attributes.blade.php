@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Атрибуты',
    ]
@endphp

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Создание атрибутов</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('admin.attributes.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Новый атрибут</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="title" type="text" class="form-control" {{--required--}} placeholder="Название: Вес">
                                        {!! $errors->first('title', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                    <div class="col-md-6">
                                        <input name="suffix" type="text" class="form-control" placeholder="Суффикс: кг">
                                        {!! $errors->first('suffix', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('locale') ? 'has-error' : ''}}">
                                {!! Form::label('locale', 'Locale', ['class' => 'control-label',]) !!}
                                {!! Form::select('locale', [null => '--не выбрано--',] + \UrlAliasLocalization::getSupportedLocalesForSelect(), null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
                                {!! $errors->first('locale', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('purpose') ? 'has-error' : ''}}">
                                {!! Form::label('purpose', 'Предназначение значений', ['class' => 'control-label',]) !!}
                                {!! Form::select('purpose', \App\Models\Shop\Attribute::$purposes, \App\Models\Shop\Attribute::PURPOSE_FACET, ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
                                {!! $errors->first('purpose', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <label>
                                        <input type="hidden" name="data[show_if_empty_filter]" value="0">
                                        <input type="checkbox" name="data[show_if_empty_filter]" value="1">
                                        Отображать в фильтре, даже при отсутствии товаров
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Список атрибутов</h3>
                    </div>
                    @if($attributes->count())
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Название</th>
                                        <th>Суфикс</th>
                                        <th title="Отображать/скрывать в фильтрах, при отсутствии товаров">Отображение</th>
                                        <th>Значений</th>
                                        <th></th>
                                        <th style="width: 110px;">Дейстия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($attributes as $attribute)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td title="{{ \App\Models\Shop\Attribute::$purposes[$attribute->purpose] }}">
                                                @include('admin.fields.field-x-editable', [
                                                    'value' => $attribute->title,
                                                    'type' => 'text',
                                                    'field_name' => 'title',
                                                    'pk' => $attribute->id,
                                                    'url' => route('admin.shop.attributes.editable', $attribute),
                                                ])
                                            </td>
                                            <td>
                                                @include('admin.fields.field-x-editable', [
                                                    'value' => $attribute->suffix,
                                                    'type' => 'text',
                                                    'field_name' => 'suffix',
                                                    'pk' => $attribute->id,
                                                    'url' => route('admin.shop.attributes.editable', $attribute),
                                                ])
                                            </td>
                                            <td>
                                                @include('admin.fields.field-x-editable', [
                                                    'value' => $attribute->show_if_empty_filter,
                                                    'type' => 'select',
                                                    'field_name' => 'data[show_if_empty_filter]',
                                                    'source' => [["value" => "1", "text" => "Отображать"], ["value" => "0", "text" => "Скрывать"]],
                                                    'pk' => $attribute->id,
                                                    'url' => route('admin.shop.attributes.editable', $attribute),
                                                ])
                                            </td>
                                            <td>{{ $attribute->values_count }}</td>
                                            <td>{{ $attribute->locale }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.values.index', ['attribute' => $attribute->id]) }}" class="btn btn-xs btn-success"><i data-toggle="tooltip" data-placement="top" title="Просмотр значений атрибута" class="fa fa-list-alt"></i></a>
                                                    {{--<a href="#" data-url="{{ route('admin.attributes.update', $attribute) }}" data-fields="{{ $attribute }}"  data-target="#modal-edit-attributes" class="btn btn-xs btn-warning js-fill-fields-modal"><i data-toggle="tooltip" data-placement="top" title="Редактировать атрибут" class="fa fa-edit"></i></a>--}}
                                                    <a href="#" data-url="{{ route('admin.attributes.destroy', $attribute) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @else
                        <div class="box-body">
                            <div class="alert alert-warning alert-dismissible no-margin">
                                <h4><i class="icon fa fa-warning"></i>Нет атрибутов для отображения. Создайте их в поле "Создание атрибутов товаров"</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop

@section('modals')
    @includeWhen($attributes->count(), 'admin.inc.modals')
@endsection

