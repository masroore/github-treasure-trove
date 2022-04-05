@extends('layouts.app')

@section('title', 'Contact Me')

@section('content')

@include('layouts.partials.pageheader')

<div class="container mx-auto pb-4">

  <div class="flex flex-col md:flex-row justify-between">

    <x-layout.dash_left/>
    
    @livewire('messages.display-messages')

  </div>
</div>

@endsection