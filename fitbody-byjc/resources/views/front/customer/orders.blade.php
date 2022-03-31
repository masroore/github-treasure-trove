@extends('front.layouts.core')

@push('css')
@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li> <a href="{{ route('moj') }}">Moj račun</a></li>
            <li>Moje narudžbe</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Moje narudžbe</h1>
                <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td>Broj narudžbe</td>
                            <td>Kupac</td>
                            <td class="hidden-xs hidden-sm">Status</td>
                            <td class="text-right hidden-xs hidden-sm">Ukupno</td>
                            <td class="text-right hidden-xs hidden-sm">Datum dodavanja</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customer->client_orders()->get() as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->payment_fname }} {{ $order->payment_lname }}</td>
                                    <td class="hidden-xs hidden-sm">{{ $order->status->name }}</td>
                                    <td class="text-right hidden-xs hidden-sm">{{ number_format($order->total, 2) }} kn</td>
                                    <td class="text-right hidden-xs hidden-sm">{{ $order->created_at }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('moj.narudzba', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">Pregled</a>
                                    </td>
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
