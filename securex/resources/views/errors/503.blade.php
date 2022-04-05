@extends('errors::layout')

@section('title', __('Maintenance Mode Active'))
@section('code', '503')
@section('message')
{!! json_decode(file_get_contents(storage_path('framework/down')), true)['message'] !!}
<br/>
<small style="font-size:18px;">
    - @lang('snippets.last_updated') <b>{{ \Carbon\Carbon::parse(json_decode(file_get_contents(storage_path('framework/down')), true)['time'])->diffForHumans() }}</b>
</small>
@endsection
