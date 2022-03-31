@extends('front.layouts.core')

@push('css')
@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>

            <li> <a href="{{ route('moj') }}">Moj račun</a></li>
            <li> <a href="{{ route('moj.narudzbe') }}">Moje narudžbe</a></li>
            <li>Narudžba {{ $order->id }}</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Narudžba - {{ $order->id }}</h1>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td class="text-left" colspan="2">Detalji narudžbe</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;">
                                <b>Narudžba broj:</b> #{{ $order->id }}<br>
                                <b>Datum dodavanja:</b> {{ $order->created_at }}</td>
                            <td class="text-left" style="width: 50%;">
                                <b>Način plaćanja:</b> {{ $order->payment_method }}<br>
                                <b>Način isporuke:</b> {{ $order->shipping_method }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Adresa na računu</td>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Adresa za isporuku</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">{{ $order->payment_fname }} {{ $order->payment_lname }}<br>{{ $order->payment_address }}<br>{{ $order->payment_city }} {{ $order->payment_zip }}<br>{{ $order->payment_country }}</td>
                            <td class="text-left">{{ $order->shipping_fname }} {{ $order->shipping_lname }}<br>{{ $order->shipping_address }}<br>{{ $order->shipping_city }} {{ $order->shipping_zip }}<br>{{ $order->shipping_country }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table table-bordered margin-b0">
                            <thead>
                            <tr>
                                <td class="text-left">Naziv artikla</td>
                                <td class="text-left hidden-xs hidden-sm">Model</td>
                                <td class="text-right hidden-xs hidden-sm">Količina</td>
                                <td class="text-right hidden-xs hidden-sm">Cijena</td>
                                <td class="text-right">Ukupno</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products()->get() as $product)
                                <tr>
                                    <td class="text-left">{{ $product->name }}
                                        <br>
                                        &nbsp;<small> - {{ $product->product->measure }} {{ $product->product->measure_unit }}</small>
                                    </td>
                                    <td class="text-left hidden-xs hidden-sm">{{ $product->product->sku }}</td>
                                    <td class="text-right hidden-xs hidden-sm">{{ $product->quantity }}</td>
                                    <td class="text-right hidden-xs hidden-sm">{{ number_format($product->price, 2) }} kn</td>
                                    <td class="text-right">{{ number_format($product->total, 2) }} kn</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table totals table-bordered">
                            <tbody>
                            @foreach($order->totals()->get() as $total)
                                <tr>
                                    <td><b>{{ $total->title }}</b></td>
                                    <td class="text-right">{{ number_format($total->value, 2) }} kn</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
@endpush
