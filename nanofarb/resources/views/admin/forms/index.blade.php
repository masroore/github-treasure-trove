@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Формы',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => '',
    ]
@endphp

@section('content')
<section class="content">
    @unless($forms->count())
        @include('admin.fields.empty-rows', ['msg_body' => ''])
    @else
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список форм ({{ $forms->total() }})</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:35px;">#</th>
                        {{--<th>Пользователь</th>--}}
                        <th style="width: 100px;">Создано</th>
                        <th style="width: 100px;">Оновлено</th>
                        <th style="width: 150px">Статус</th>
                        <th style="width:100px;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $form)
                    <tr>
                        <td>{{ $form->id }}</td>
                        {{--<td>{{ optional($form->user)->name }}</td>--}}
                        <td>{{ $form->created_at }}</td>
                        <td>{{ $form->updated_at }}</td>
                        <td>
                            @include('admin.fields.field-select2-change-status-ajax', [
                                'selected' => $form->status,
                                'attributes' => \App\Models\Form::$formStatuses,
                                'data_url' => route('admin.forms.status', $form),
                            ])
                        </td>
                        <td style="width: 110px">
                            <div class="btn-group">
                                {{--<a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>--}}
                                <a href="#" data-url="{{ route('admin.forms.destroy', $form) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                @include('admin.inc.pagination', ['pages' => $forms])
            </div>
        </div>
    </div>
    @endunless
</section>
@endsection