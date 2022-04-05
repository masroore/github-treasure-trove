@extends('layouts.base')

@section('body')
    <div class="min-h-screen flex justify-center items-center">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
