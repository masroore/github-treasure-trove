@extends('admin.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $orderNewCount }}</h3>
                        <p>Новых заказов</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $orderAcceptCount }}</h3>

                        <p>Успешных заказов</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $clientCount }}</h3>

                        <p>Клиентов магазина</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fa"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $webFormCount }}</h3>

                        <p>Не обработанных веб-форм</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-chrome"></i>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fa"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <section class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-line-chart"></i>
                        <h3 class="box-title">Динамика заказов за 30 дней</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                    </div>
                </div>
            </section>
            <section class="col-lg-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-shopping-cart"></i><h3 class="box-title">Последние 15 заказов</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th>Товаров</th>
                                    <th>Оформлено</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->number }}</td>
                                    <td>{{ Currency::format($order->price) }}</td>
                                    <td>
                                    @if($order->txStatus){!!  $order->txStatus->statusAdminStr()  !!}@endif
                                    @if($order->type == \App\Models\Shop\Order::TYPE_CART) <i class="fa fa-shopping-cart" title="Еще формируется клиентом"></i>@endif
                                    </td>
                                    <td>{{ $order->products_count }} [{{ $order->products->map(function ($p) {return $p->pivot->quantity;})->sum() }}]</td>
                                    <td>{{ $order->ordered_at ?? $order->created_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var chartOrders = @json($chartData)
    </script>
@endpush