@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('disclosures.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('disclosures.page_title') }}</h1>
                    <span>{{ trans('disclosures.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            <div class="container">
                <h3>{{ trans('disclosures.title1') }}</h3>
                <p>{!! trans('disclosures.title1_desc') !!}</p>
                <hr class="space">
                <h3>{{ trans('disclosures.title2') }}</h3>
                <p>{{ trans('disclosures.title2_desc') }}</p>
                <ol>
                    <li>{{ trans('disclosures.content2_1') }}</li>
                    <li>{{ trans('disclosures.content2_2') }}</li>
                    <li>{{ trans('disclosures.content2_3') }}</li>
                </ol>
            </div>
        </section>
    </div>
@endsection