@extends('layouts.auth')

@section('title')
    Welcome
@endsection

@section('content')
    <div class="grid place-items-center min-h-screen">
        <div>
            <div class="flex items-center justify-center">
                <h1 class="md:text-6xl text-4xl text-center font-medium">FoodTech Learning</h1>
            </div>
            <div class="flex items-center justify-center mt-4">
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                            >
                                Log out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
