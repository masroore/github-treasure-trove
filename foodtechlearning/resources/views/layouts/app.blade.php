@extends('layouts.base')

@section('body')
    @livewire('flash-toaster',[], key('toaster'))
    <div class="h-screen flex" x-data="{sidebar:false}">
        <aside class="hidden md:block bg-primary-600 w-1/6">
            <a href="/" class="flex bg-white p-2 items-center h-20">
                <div class="h-full">
                    <img src="{{ asset('images/logo.gif') }}" class="h-full" alt="logo">
                </div>
                <h4 class="center flex-1 font-semibold h-full text-center uppercase text-2xl text-gray-600">FoodTech<br>Learning</h4>
            </a>
            @isset(auth()->user()->default_role)
                @switch(auth()->user()->default_role->name)
                    @case('teacher')
                    <x-teacher-sidebar/>
                    @break
                    @case('student')
                    <x-student-sidebar/>
                    @break
                @endswitch
            @endisset
        </aside>

        <aside x-show="sidebar" x-cloak class="fixed inset-0 bg-primary-600 z-50">
            <a href="/" class="flex bg-white p-2 items-center h-20">
                <div class="h-full">
                    <img src="{{ asset('images/logo.gif') }}" class="h-full" alt="logo">
                </div>
                <h4 class="center flex-1 font-semibold h-full text-center uppercase text-2xl text-gray-600">FoodTech<br>Learning</h4>
            </a>
            @isset(auth()->user()->default_role)
                @switch(auth()->user()->default_role->name)
                    @case('teacher')
                    <x-teacher-sidebar/>
                    @break
                    @case('student')
                    <x-student-sidebar/>
                    @break
                @endswitch
            @endisset
            <button @click="sidebar = false" class="w-full text-center text-white p-4">
                <x-gmdi-close/><span class="title-sm text-white">CLOSE</span>
            </button>
        </aside>

        <div class="flex-1 flex overflow-hidden flex-col">
            <header class="bg-primary-500 flex items-center justify-between px-4 h-20">
                <nav class="text-white font-semibold flex items-center space-x-2">
                    <button class="focus:outline-none" @click="sidebar = true">
                        <x-gmdi-menu-r/>
                    </button>
                    <h2>
                        @yield('page_title')
                    </h2>
                </nav>
                <div class="flex-shrink-0">
                    <x-logout class="font-semibold text-white hover:text-gray-700" />
                </div>
            </header>
            <main class="flex-1 p-4 text-gray-900 bg-secondary-500 overflow-y-auto h-0">
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
            </main>
        </div>
    </div>
@endsection
