@extends('errors::minimal')

@section('title', __('err'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'err'))
