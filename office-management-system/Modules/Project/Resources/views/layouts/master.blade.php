@extends('backEnd.master', ['title' => $title ?? null])

@push('css')
  @stack('css_before')

@endpush

@push('styles')
  @stack('css_after')
@endpush

@section('mainContent')
	@section('header_content')

	@show
	@section('content')
	@show

@endsection

@push('scripts')



@stack('js_after')

<script>
	$(document).on('click', '#single_project', function(){
        var url = $(this).data('url')
        window.location.href = url
    })
</script>

@endpush
