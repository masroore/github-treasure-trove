@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush


@section('content')


    <div class="bg-image bg-image-bottom" style="background-image: url({{ asset('images/parallax-bg.jpg') }});">
        <div class="bg-primary-dark-op py-30">
            <div class="content content-full text-center">
                <!-- Avatar -->
                <div class="mb-15">
                    <a class="img-link" href="#">
                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{ asset('media/' . $user->details->avatar) }}" alt="">
                    </a>
                </div>

                <h1 class="h3 text-white font-w700 mb-10">{{ $user->details->fname . ' ' . $user->details->lname }}</h1>
                <h2 class="h5 text-white-op">
                    <a class="text-primary-light" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                </h2>

                <a href="{{ route('users') }}" type="button" class="btn btn-rounded btn-hero btn-sm btn-outline-primary mb-5">
                    <i class="si si-action-undo mr-5"></i> Back to list
                </a>
            </div>
        </div>
    </div>

    @include('back.layouts.partials.session')

    <div class="content">
        <h2 class="content-heading">Adrese</h2>
        <div class="row row-deck gutters-tiny">
            <!-- Billing Address -->
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Adresa Plaćanja</h3>
                    </div>
                    <div class="block-content">
                        <div class="font-size-lg text-black mb-5">{{ $user->orders[0]->payment_fname . ' ' . $user->orders[0]->payment_lname }}</div>
                        <address class="mb-30">
                            {{ $user->orders[0]->payment_address }}<br>
                            {{ $user->orders[0]->payment_zip . ' ' . $user->orders[0]->payment_city }}<br><br>
                            <i class="fa fa-phone mr-5"></i> {{ $user->orders[0]->payment_phone }}<br>
                            <i class="fa fa-envelope-o mr-5"></i> <a href="mailto:{{ $user->orders[0]->payment_email }}">{{ $user->orders[0]->payment_email }}</a>
                        </address>
                    </div>
                </div>
            </div>
            <!-- END Billing Address -->

            <!-- Shipping Address -->
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Adresa Dostave</h3>
                    </div>
                    <div class="block-content">
                        <div class="font-size-lg text-black mb-5">{{ $user->orders[0]->shipping_fname . ' ' . $user->orders[0]->shipping_lname }}</div>
                        <address class="mb-30">
                            {{ $user->orders[0]->shipping_address }}<br>
                            {{ $user->orders[0]->shipping_zip . ' ' . $user->orders[0]->shipping_city }}<br><br>
                            <i class="fa fa-phone mr-5"></i> {{ $user->orders[0]->shipping_phone }}<br>
                            <i class="fa fa-envelope-o mr-5"></i> <a href="mailto:{{ $user->orders[0]->shipping_email }}">{{ $user->orders[0]->shipping_email }}</a>
                        </address>
                    </div>
                </div>
            </div>
            <!-- END Shipping Address -->
        </div>


        <h2 class="content-heading">Narudžbe
            <small>
                <span class="pl-2">({{ $user->orders->count() }})</span>
                <span class="float-right">{{--{{ $count }}--}}
                    <a href="{{ route('orders') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="Lista">
                        <i class="si si-list mr-5"></i> Lista Narudžbi
                    </a>
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-secondary ml-10" data-toggle="tooltip" title="New">
                        <i class="si si-plus mr-5"></i> Nova Narudžba
                    </a>
                </span>
            </small>
        </h2>

        <div class="block black">
            <div class="block-content">
                <table class="table table-hover table-vcenter mb-30">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 63px;">#</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 15%;">Plačanje</th>
                        <th class="text-center" style="width: 15%;">Poštarina</th>
                        <th class="text-right" style="width: 15%;">Total</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->orders as $key => $order)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('order.edit', ['id' => $order->id]) }}">
                                    {{ $order->id }}
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-light">{{ $order->status->name }}</span>
                            </td>
                            <td class="text-center">{{ $order->payment_method }}</td>
                            <td class="text-center">{{ $order->shipping_method }}</td>
                            <td class="text-right font-size-sm">
                                <strong>{{ number_format($order->total, 2, ',', '.') }}</strong> <span class="text-muted">kn</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
@endpush
