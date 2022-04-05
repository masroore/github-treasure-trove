@extends('front.layouts.app')

@php
    MetaTag::setEntity($page)->setDefault(['title' => $page->name]);
    $localebound = $page->getLocaleboundStr();
@endphp

@section('content')
    <div class="typography">
        <div class="typography__wrapper">
            {!! $page->body !!}
        </div>
    </div>
@endsection

@push('scripts')

@endpush