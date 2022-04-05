@extends('layouts.master')

@section('content')

    @include('parts.banners')

    @include('parts.image-menus')


    {{-- @include('parts.popups') --}}
    <x-popups :popups="$popups" />

@endsection
