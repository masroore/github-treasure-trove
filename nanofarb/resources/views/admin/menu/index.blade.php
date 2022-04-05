@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Меню',
    ]
@endphp

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Создание нового меню</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('admin.menu.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Название меню</label>
                                <input name="name" type="text" class="form-control" placeholder="Пример: Меню в футере">
                            </div>
                            {!! $errors->first('system_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                            <div class="form-group">
                                <label>Системное имя меню</label>
                                <input name="system_name" type="text" class="form-control" placeholder="Пример: menu_in_footer">
                            </div>
                            {!! $errors->first('system_name', '<p class="help-block" style="color:red;">:message</p>') !!}
{{--

                            @include('admin.fields.field-checkbox', [
                                'label' => 'Публиковать',
                                'field_name' => 'publish',
                                'status' => 1,
                            ])
--}}

                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Список меню</h3>
                    </div>
                    @if($menus->count())
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Название</th>
                                        <th>Сист. имя</th>
                                        <th>Пунктов</th>
                                        {{--<th>Публиковать</th>--}}
                                        <th>Дейстия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($menus as $menu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $menu->name }}</td>
                                            <td>{{ $menu->system_name }}</td>
                                            <td>{{ $menu->items_count }}</td>
                                            {{--<td>{{ $menu->publish }}</td>--}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.menu-items.index', ['menu_id' => $menu->id]) }}" class="btn btn-xs btn-success"><i data-toggle="tooltip" data-placement="top" title="Просмотр значений атрибута" class="fa fa-list-alt"></i></a>
                                                    <a href="#" data-url="{{ route('admin.menu.update', $menu) }}" data-fields="{{ $menu }}"  data-target="#modal-edit-menu" class="btn btn-xs btn-warning js-fill-fields-modal"><i data-toggle="tooltip" data-placement="top" title="Редактировать атрибут" class="fa fa-edit"></i></a>
                                                    <a href="#" data-url="{{ route('admin.menu.destroy', $menu) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                                <h4><i class="icon fa fa-warning"></i>Нет меню для отображения. Создайте их в поле "Создание нового меню"</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop

@section('modals')
    @includeWhen($menus->count(), 'admin.inc.modals')
@endsection

