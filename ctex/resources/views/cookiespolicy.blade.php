@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('cookiespolicy.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('cookiespolicy.page_title') }}</h1>
                    <span>{{ trans('cookiespolicy.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            <div class="container">
                <h3>{{ trans('cookiespolicy.title1') }}</h3>
                <p>{{ trans('cookiespolicy.content1_1') }}</p>
                <p>{{ trans('cookiespolicy.content1_2') }}</p>
                <p>{{ trans('cookiespolicy.content1_3') }}</p>
                <hr class="space">
                <h3>{{ trans('cookiespolicy.title2') }}</h3>
                <p>{{ trans('cookiespolicy.content2_1') }}</p>
                <p>{{ trans('cookiespolicy.content2_2') }}</p>
                <p>{{ trans('cookiespolicy.content2_3') }}</p>
                <p>{{ trans('cookiespolicy.content2_4') }}</p>
                <ul>
                    <li>{{ trans('cookiespolicy.content2_4_1') }}</li>
                    <li>{{ trans('cookiespolicy.content2_4_2') }}</li>
                    <li>{{ trans('cookiespolicy.content2_4_3') }}</li>
                </ul>
                <hr class="space">
                <h3>{{ trans('cookiespolicy.title3') }}</h3>
                <ul class="list-icon list-icon-check">
                    <li>{{ trans('cookiespolicy.content3_1') }}</li>
                    <li>{{ trans('cookiespolicy.content3_2') }}</li>
                </ul>
                <hr class="space">
                <h4>{{ trans('cookiespolicy.title4') }}</h4>
                <p>{{ trans('cookiespolicy.content4_1') }}<a href="https://www.aboutcookies.org/">{{ trans('cookiespolicy.content4_1_link') }}</a></p>
            </div>
        </section>
    </div>
@endsection