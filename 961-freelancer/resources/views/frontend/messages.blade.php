@extends('frontend.layouts.app')
<link rel="stylesheet" media="screen" href="{{ url('css/app.css') }}">
<style>
	@media(max-width: 767px){
		footer{
			display: none;
		}
	}
</style>
@section('content')
    <div id="app">
    	 <router-view :userdata="{{ auth()->user() }}"></router-view>
        <!-- <Profile :userdata="{{ auth()->user() }}"></Profile> -->
    </div>
    <script src="{{ url('js/app.js') }}"></script>
@endsection
