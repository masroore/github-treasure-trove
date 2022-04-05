@extends('layouts.app')

@section('title', 'Read Message')

@section('content')

@include('layouts.partials.pageheader')

<div  class="container mx-auto">
    <div class="card mt-6 lg:w-1/2 lg:mx-auto  rounded shadow">
        <div class="bg-blue-100">
            <h1 class="text-2xl font-normal pb-4 text-center">
                Message
            </h1>
        </div>
 
    </div>
</div>

@endsection