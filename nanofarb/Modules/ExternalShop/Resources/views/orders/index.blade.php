@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Заказы',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => '',
    ]
@endphp

@section('content')
    @includeWhen(true, 'externalshop::orders.inc.filter')

    <section class="content">
        @if(request()->has('filter') && !$orders->count())
            @include('admin.fields.empty-rows', [
                'msg_title' => 'Поиск не дал результатов',
                'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
            ])
        @else
        <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список заказов ({{ $orders->total() }})</h3>
        </div>
        <div class="box-body">
            @unless($orders->count())
                @include('admin.fields.empty-rows')
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
{{--                        <th>Источник</th>--}}
                        <th>Сумма</th>
                        <th>Клиент</th>
                        <th>Телефон</th>
                        <th>Оформлено</th>
                        <th>Изменено</th>
                        <th>Статус</th>
                        <th class="text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->number }}</td>
{{--                        <td>{{ $order->source }}</td>--}}
                        <td>{{ Currency::format($order->total_sum) }}</td>
                        <td>{{ $order['client']['fullname'] }}</td>
                        <td>{{ $order['client']['phone'] }}</td>
                        <td>{{ $order->confirmed_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>{!! $order->getStatusStr('lte_title') !!}</td>
                        <td style="width: 110px; text-align: center">
                            <div class="btn-group">
                                <a href="{{ route('admin.externalshop.orders.edit', [$order->source, $order]) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="#" data-url="{{ route('admin.externalshop.orders.reload', $order) }}" class="btn btn-xs btn-info js-action-click" data-method="POST" data-confirm="Подтверждаете действие? Измененные вами данные заказа могут быть потеряны!" title="Принудительно повторно скачать"><i class="fa fa-refresh"></i></a>
                                <a href="#" data-url="{{ route('admin.externalshop.orders.destroy', [$order->source, $order]) }}" class="btn btn-xs btn-danger js-action-destroy" data-method="DELETE"><i class="fa fa-remove"></i></a>
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
                @include('admin.inc.pagination', ['pages' => $orders])
            </div>
        </div>
    </div>
        @endif
</section>

@endsection