@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Акции',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.sales.create'),
    ]
@endphp

@section('content')
    @includeWhen(true, 'admin.shop.sales.inc.filter')

<section class="content">
    @if(request()->has('filter') && !$sales->count())
        @include('admin.fields.empty-rows', [
            'msg_title' => 'Поиск не дал результатов',
            'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
        ])
    @else
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список акций ({{ $sales->total() }})</h3>
        </div>
        <div class="box-body">
            @unless($sales->count())
                @include('admin.fields.empty-rows')
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Скидка</th>
                        <th style="text-align: center">Статус</th>
                        <th style="text-align: center">Бессрочная</th>
                        <th>Начало</th>
                        <th>Завершение</th>
                        <th>Создано</th>
                        <th width="100px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td title="{{ \App\Models\Shop\Sale::$types[$sale->type] ?? $sale->type }}">{{ $sale->name }}</td>
                        <td>@if($sale->discount_type == \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT) {{ $sale->discount }}% @else {{ \Currency::format($sale->discount) }} @endif</td>
                        <td style="text-align: center">
                            @if($sale->publish)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif
                        </td>
                        <td style="text-align: center">
                            @if($sale->dateless)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif
                        </td>
                        <td>{{ optional($sale->start_at)->format('m/d/Y') }}</td>
                        <td>{{ optional($sale->end_at)->format('m/d/Y') }}</td>
                        <td>{{ $sale->created_at }}</td>
                        <td style="width: 110px">
                            <div class="btn-group">
                                <a href="{{ route_alias('sales.show', $sale) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.sales.edit', $sale) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="#" data-url="{{ route('admin.sales.destroy', $sale) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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
                @include('admin.inc.pagination', ['pages' => $sales])
            </div>
        </div>
    </div>
    @endif
</section>
@endsection