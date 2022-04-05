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
    @includeWhen(true, 'admin.shop.orders.inc.filter')

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
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Статус оплаты</th>
                        <th>Товаров</th>
                        <th>Оформлено</th>
                        <th>Обновлено</th>
                        <th width="100px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->number }}</td>
                        <td>{{ Currency::format($order->price) }}</td>
                        <td>
                            {{--@if($order->txStatus)<sbodypan class="label label-success">{{ $order->txStatus->name }}</sbodypan>@endif--}}
                            @if($order->txStatus){!!  $order->txStatus->statusAdminStr()  !!}@endif
                            @if($order->type == \App\Models\Shop\Order::TYPE_CART) <i class="fa fa-shopping-cart" title="Еще формируется клиентом"></i>@endif
                        </td>
                        <td>
                            @if($order->txPaymentStatus){!! $order->txPaymentStatus->statusAdminStr() !!}@endif
                        </td>
                        <td>{{ $order->products_count }} [{{ $order->products->map(function ($p) {return $p->pivot->quantity;})->sum() }}]</td>
                        <td>{{ $order->ordered_at ?? $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td style="width: 110px">
                            <div class="btn-group">
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="#" data-url="{{ route('admin.orders.destroy', $order) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
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