@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Цвета',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.colors.create')
    ]
@endphp

@section('content')

    <section class="content">
        @if(request()->has('filter') && !$colors->count())
            @include('admin.fields.empty-rows', [
                'msg_title' => 'Поиск не дал результатов',
                'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
            ])
        @else
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Список цветов ({{ $colors->count() }})</h3>
{{--                    <div class="pull-right box-tools">--}}
{{--                        <a href="{{ request()->fullUrlWithQuery(['show_products_type_list' => 0]) }}"><i class="fa  fa-indent"></i></a>--}}
{{--                    </div>--}}

                </div>
                <div class="box-body">
                    @unless($colors->count())
                        @include('admin.fields.empty-rows', ['url_create' => route('admin.users.create')])
                    @else
                    <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Код</th>
                        <th>Наценка</th>
                        <th width="110px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $color)
                        @include('admin.shop.colors.inc.tr-color')
                    @endforeach
                    </tbody>
                </table>
            </div>
                    @endunless
                </div>

{{--                <div class="box-footer">--}}
{{--                    <div class="pull-right">--}}
{{--                        @include('admin.inc.pagination', ['pages' => $colors])--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
        @endif
    </section>
@endsection