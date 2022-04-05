@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('contactus.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('contactus.page_title') }}</h1>
                    <span>{{ trans('contactus.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        @if ($errors->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section id="page-content" class="dark">
            <div class="container">
                <div class="col-lg-8">
                    <form action="{{ route('contactus.send') }}" role="form" method="post">
                        @csrf

                        <div class="form-group col-md-12">
                            <label for="email" class="text-light">{{ trans('contactus.email_title') }}</label>
                            <input type="email" aria-required="true" name="email" class="form-control input-dark-bg text-light required email @error('email') is-invalid @enderror" placeholder="{{ trans('contactus.email_placeholder') }}">
                            @error('email')
                                <div class="is-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="subject" class="text-light">{{ trans('contactus.subject_title') }}</label>
                            <input type="text" name="title" class="form-control input-dark-bg text-light required @error('title') is-invalid @enderror" placeholder="{{ trans('contactus.subject_placeholder') }}">
                            @error('title')
                                <div class="is-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="message" class="text-light">{{ trans('contactus.message_title') }}</label>
                            <textarea type="text" name="content" rows="5" class="form-control input-dark-bg text-light required @error('message') is-invalid @enderror" placeholder="{{ trans('contactus.message_placeholder') }}"></textarea>
                            @error('content')
                                <div class="is-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit" id="form-submit"><i class="fa fa-paper-plane"></i>&nbsp;{{ trans('buttons.send') }}</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_contactus').addClass('text-danger');
        });
    </script>
@endsection