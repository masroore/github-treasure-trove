@extends('layouts.master-customer')

@section('content')

<div class="m-2 sm:hidden flex items-center justify-start">
  <a  class="p-2 text-sm {{ $ccat->id == 1 ? ' text-red-600' : '' }} " href ='/customers?ccat_id=1'>1:1문의</a>
  <a class="p-2 text-sm {{ $ccat->id == 2 ? ' text-red-600' : '' }} " href ='/customers?ccat_id=2'>광고문의</a>
</div>

<div class="p-2 m-2 ">
  {{ $ccat->title }}
  @livewire('customers', [
    'ccatid'=> $ccat->id,
  ])

</div>
@endsection