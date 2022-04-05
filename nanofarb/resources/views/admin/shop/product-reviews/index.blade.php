@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Отзывы о продуктах',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => '',
    ]
@endphp

@section('content')
<section class="content">
    @unless($reviews->count())
        @include('admin.fields.empty-rows', ['msg_body' => ''])
    @else
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список отзывов о продуктах ({{ $reviews->total() }})</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:35px;">#</th>
                        <th style="width: 130px;">Пользователь</th>
                        <th>Товар</th>
                        <th>Текст отзыва</th>
                        <th style="width: 100px;">Оценка</th>
                        <th style="width: 100px;">Создано</th>
                        <th style="width: 150px">Статус</th>
                        <th style="width:100px;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ optional($review->user)->name }}</td>
                        <td>@if($review->product){{ link_to_route('product.show', null, $review->product) }}@endif</td>
                        <td>
                            @include('admin.fields.field-x-editable', [
                                'value' => $review->body ?? '[Отзыв]',
                                'type' => 'textarea',
                                'field_name' => 'body',
                                'pk' => $review->id,
                                'url' => route('admin.product-reviews.editable', $review),
                            ])
                        </td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ $review->created_at }}</td>
                        <td>
                            @include('admin.fields.field-select2-change-status-ajax', [
                                'selected' => $review->status,
                                'attributes' => [0 => 'Не опубликован', 1 => 'Опубликован'],
                                'data_url' => route('admin.product-reviews.status', $review),
                            ])
                        </td>
                        <td style="width: 110px">
                            <div class="btn-group">
                                {{--<a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>--}}
                                <a href="#" data-url="{{ route('admin.product-reviews.destroy', $review) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                @include('admin.inc.pagination', ['pages' => $reviews])
            </div>
        </div>
    </div>
    @endunless
</section>
@endsection