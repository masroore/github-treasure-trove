@extends('emails.layouts')

{{-- После сохранение веб-формы --}}

@section('content')
    <h2>{{ $subject ?? '' }}</h2>
    @if($form->type == 'contacts')
        <p><b>ФИО:</b> {{ $form->data['name'] ?? '' }}</p>
        <p><b>Телефон:</b> {{ $form->data['phone'] ?? '' }}</p>
        <p><b>Email:</b> {{ $form->data['email'] ?? '' }}</p>
    @elseif($form->type == 'cooperation')
        <p><b>ФИО:</b> {{ $form->data['name'] ?? '' }}</p>
        <p><b>Телефон:</b> {{ $form->data['phone'] ?? '' }}</p>
        <p><b>Email:</b> {{ $form->data['email'] ?? '' }}</p>
        <p><b>Город:</b> {{ $form->data['city'] ?? '' }}</p>
        <p><b>Вид торговых услуг:</b> {{ optional($form->terms->where('vocabulary', 'types_trade_services')->first())->name }}</p>
        <p><b>Комментарий:</b> {{ $form->data['message'] ?? '' }}</p>
    @elseif($form->type == 'buy_one_click')
        <p><b>ФИО:</b> {{ $form->data['name'] ?? '' }}</p>
        <p><b>Телефон:</b> {{ $form->data['phone'] ?? '' }}</p>
        <p><b>Товар:</b> @isset($form->data['product_id']){{ link_to_route('product.show', null, $form->data['product_id'], ['target' => '_blank']) }}@endisset</p>
    @else
        <p><b>ФИО:</b> {{ $form->data['name'] ?? '' }}</p>
        <p><b>Телефон:</b> {{ $form->data['phone'] ?? '' }}</p>
        <p><b>Email:</b> {{ $form->data['email'] ?? '' }}</p>
    @endif
    <br>

    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop