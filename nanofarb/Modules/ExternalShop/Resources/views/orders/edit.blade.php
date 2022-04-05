@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Заказы',
        'url_back' => session('admin.externalshop.orders.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        {!! Form::model($order, [
            'method' => 'PATCH',
            'url' => route('admin.externalshop.orders.update', [$order->source, $order]),
            'files' => true
        ]) !!}
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Редактирование заказа</h3>
            @include('admin.inc.entity-navigation', [
                //'next' => $order->previous() ? route('admin.orders.external.edit', $order->previous()) : '',
                //'previous' => $order->next() ? route('admin.orders.external.edit', $order->next()) : '',
            ])
        </div>
        <div class="box-body">
                @include('externalshop::orders._form')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@stop