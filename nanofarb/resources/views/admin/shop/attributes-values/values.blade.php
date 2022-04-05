@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Значения атрибутов',
        'small_page_title' => '',
        'url_back' => route('admin.attributes.index'),
        'url_create' => '',
    ]
@endphp

@section('content')
    <section class="content">
        <div class="row">
            @if($attribute->purpose === \App\Models\Shop\Attribute::PURPOSE_TINTING_FACADE || $attribute->purpose === \App\Models\Shop\Attribute::PURPOSE_TINTING_INTERIOR)
            @else
                <div class="col-lg-4">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Создание значания атрибута <strong>"{{ $attribute->title }}"</strong></h3>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('admin.values.store') }}" method="POST">
                                @csrf
                                {!! Form::hidden('attribute_id', $attribute->id) !!}
                                <div class="form-group">
                                    <label>Новый атрибут</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input name="value" type="text" class="form-control" placeholder="Значение: Зеленый">
                                            {!! $errors->first('value', '<p class="help-block" style="color:red;">:message</p>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <input name="suffix" type="text" class="form-control" placeholder="Пример: кг" value="{{ $attribute->suffix }}">
                                            {!! $errors->first('suffix', '<p class="help-block" style="color:red;">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Список значений атрибута <strong>"{{ $attribute->title }}"</strong></h3>
                    </div>
                    @if($values->count())
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    @if($attribute->purpose === \App\Models\Shop\Attribute::PURPOSE_TINTING_FACADE || $attribute->purpose === \App\Models\Shop\Attribute::PURPOSE_TINTING_INTERIOR)
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Название</th>
                                            <th>Цвет</th>
                                            <th>Наценка</th>
                                            <th style="width: 110px;">Действие</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($values as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @include('admin.fields.field-x-editable', [
                                                        'value' => $value->name,
                                                        'type' => 'text',
                                                        'field_name' => 'name',
                                                        'pk' => $value->id,
                                                        'url' => route('admin.shop.values.editable', $value),
                                                    ])
                                                </td>
                                                <td><div style="width: 80px; height: 30px; background: {{'#'.$value->value}}" ></div></td>
                                                <td>
                                                    @include('admin.fields.field-x-editable', [
                                                        'value' => $value->markup,
                                                        'type' => 'text',
                                                        'field_name' => 'markup',
                                                        'pk' => $value->id,
                                                        'url' => route('admin.shop.values.editable', $value),
                                                    ])
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" data-url="{{ route('admin.values.update', $value) }}" data-fields={{ $value }} data-target="#modal-edit-values" class="btn btn-xs btn-warning js-fill-fields-modal"><i data-toggle="tooltip" data-placement="top" title="Редактировать значение" class="fa fa-edit"></i></a>
                                                        <a href="#" data-url="{{ route('admin.values.destroy', $value) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Значение</th>
                                            <th>Суфикс</th>
                                            <th style="width: 110px;">Действие</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($values as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @include('admin.fields.field-x-editable', [
                                                        'value' => $value->value,
                                                        'type' => 'text',
                                                        'field_name' => 'value',
                                                        'pk' => $value->id,
                                                        'url' => route('admin.shop.values.editable', $value),
                                                    ])
                                                </td>
                                                <td>
                                                    @include('admin.fields.field-x-editable', [
                                                        'value' => $value->suffix,
                                                        'type' => 'text',
                                                        'field_name' => 'suffix',
                                                        'pk' => $value->id,
                                                        'url' => route('admin.shop.values.editable', $value),
                                                    ])
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" data-url="{{ route('admin.values.update', $value) }}" data-fields={{ $value }} data-target="#modal-edit-values" class="btn btn-xs btn-warning js-fill-fields-modal"><i data-toggle="tooltip" data-placement="top" title="Редактировать значение" class="fa fa-edit"></i></a>
                                                        <a href="#" data-url="{{ route('admin.values.destroy', $value) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="box-body">
                            <div class="alert alert-warning alert-dismissible no-margin">
                                <h4><i class="icon fa fa-warning"></i>Нет значений для отображения. Создайте новое значение в поле "Создание значания"</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop

@section('modals')
    @includeWhen($values->count(), 'admin.inc.modals')
@stop