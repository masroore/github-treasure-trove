@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('news.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ $title }}</h1>
                    <span class="m-r-10"><i class="fa fa-tag m-r-5"></i>{{ trans('news.tag') }}</span>
                    <span id="created_at"></span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        @if ($errors->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Content -->
        <section id="page-content" class="dark">
            @csrf

            <div class="container" id="news_container">
                <p>{!! $content !!}</p>
            </div>
        </section>
        <div class="container">
            <a href="{{ url()->previous() }}" class="btn btn-outline">{{ trans('buttons.back') }}</a>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('#created_at').html(moment('{{ $updated_at }}').utc().format('YYYY-MM-DD HH:mm:ss'));
        });
    </script>
@endsection
