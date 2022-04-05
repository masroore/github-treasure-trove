@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Товары',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.products.create')
    ]
@endphp

@section('content')

    @includeWhen(true, 'admin.shop.products.inc.filter')

    <section class="content">
        @if(request()->has('filter') && !$products->count())
            @include('admin.fields.empty-rows', [
                'msg_title' => 'Поиск не дал результатов',
                'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
            ])
        @else
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Список товаров ({{ $products->total() }})</h3>
                    <div class="pull-right box-tools">
                        <a href="{{ request()->fullUrlWithQuery(['show_products_type_list' => 0]) }}"><i class="fa  fa-indent"></i></a>
                    </div>

                </div>
                <div class="box-body">
                    @unless($products->count())
                        @include('admin.fields.empty-rows', ['url_create' => route('admin.users.create')])
                    @else
                    <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Артикул</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Расход, кг</th>
                        <th style="text-align: center">Статус</th>
                        <th>Создано</th>
                        <th style="text-align: center">По умолчанию</th>
                        <th width="110px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        @include('admin.shop.products.inc.tr-product')
                    @endforeach
                    </tbody>
                </table>
            </div>
                    @endunless
                </div>

                <div class="box-footer">
                    <div class="pull-right">
                        @include('admin.inc.pagination', ['pages' => $products])
                    </div>
                </div>

            </div>
        @endif
    </section>
@endsection