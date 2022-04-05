@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('privacynotice.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('privacynotice.page_title') }}</h1>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            <div class="container">
                <h3>{!! trans('privacynotice.chapter1') !!}</h3>
                <p>{!! trans('privacynotice.chapter1_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter1_desc2') !!}</p>
                <p>{!! trans('privacynotice.chapter1_desc3') !!}</p>
                <p>{!! trans('privacynotice.chapter1_desc4') !!}</p>
                <p>{!! trans('privacynotice.chapter1_desc5') !!}</p>
                <p>{!! trans('privacynotice.chapter1_desc6') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter2') !!}</h3>
                <p>{!! trans('privacynotice.chapter2_1') !!}</p>
                <p>{!! trans('privacynotice.chapter2_1_1') !!}</p>
                <p>{!! trans('privacynotice.chapter2_1_2') !!}</p>
                <p>{!! trans('privacynotice.chapter2_1_3') !!}</p>
                <p>{!! trans('privacynotice.chapter2_1_4') !!}</p>
                <p>{!! trans('privacynotice.chapter2_1_5') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter3') !!}</h3>
                <p>{!! trans('privacynotice.chapter3_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter3_desc2') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter3_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_2') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_3') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_4') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_5') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_6') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter3_7') !!}</p></li>
                </ul>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter4') !!}</h3>
                <p>{!! trans('privacynotice.chapter4_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter4_desc2') !!}</p>
                <p>{!! trans('privacynotice.chapter4_desc3') !!}</p>
                <p>{!! trans('privacynotice.chapter4_desc4') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter5') !!}</h3>
                <p>{!! trans('privacynotice.chapter5_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter5_desc2') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_2') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_3') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_4') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_5') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_6') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc2_7') !!}</p></li>
                </ul>
                <p>{!! trans('privacynotice.chapter5_desc3') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter5_desc3_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc3_2') !!}</p></li>
                </ul>
                <p>{!! trans('privacynotice.chapter5_desc4') !!}</p>
                <p>{!! trans('privacynotice.chapter5_desc5') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter5_desc5_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc5_2') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc5_3') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter5_desc5_4') !!}</p></li>
                </ul>
                <p>{!! trans('privacynotice.chapter5_desc6') !!}</p>
                <p>{!! trans('privacynotice.chapter5_desc7') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter6') !!}</h3>
                <p>{!! trans('privacynotice.chapter6_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_1') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_1_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter6_1_desc2') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_2') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_2_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter6_2_desc2') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_3') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_3_desc') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter6_3_desc_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter6_3_desc_2') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter6_3_desc_3') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter6_3_desc_4') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter6_3_desc_5') !!}</p></li>
                </ul>
                <h4>{!! trans('privacynotice.chapter6_4') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_4_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_5') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_5_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_6') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_6_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_7') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_7_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_8') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_8_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_9') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_9_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter6_9_desc2') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_10') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_10_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_11') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_11_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter6_12') !!}</h4>
                <p>{!! trans('privacynotice.chapter6_12_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter7') !!}</h3>
                <p>{!! trans('privacynotice.chapter7_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter7_desc2') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter7_desc2_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter7_desc2_2') !!}</p></li>
                </ul>
                <p>{!! trans('privacynotice.chapter7_desc3') !!}</p>
                <p>{!! trans('privacynotice.chapter7_desc4') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter8') !!}</h3>
                <p>{!! trans('privacynotice.chapter8_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter9') !!}</h3>
                <p>{!! trans('privacynotice.chapter9_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter9_desc2') !!}</p>
                <p>{!! trans('privacynotice.chapter9_desc3') !!}</p>
                <h4>{!! trans('privacynotice.chapter9_1') !!}</h4>
                <p>{!! trans('privacynotice.chapter9_1_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter9_1_1') !!}<br>
                {!! trans('privacynotice.chapter9_1_2') !!}<br>
                {!! trans('privacynotice.chapter9_1_3') !!}<br>
                {!! trans('privacynotice.chapter9_1_4') !!}<br></p>
                <p>{!! trans('privacynotice.chapter9_1_desc2') !!}</p>
                <p>{!! trans('privacynotice.chapter9_1_desc3') !!}</p>
                <p>{!! trans('privacynotice.chapter9_1_desc4') !!}</p>
                <h4>{!! trans('privacynotice.chapter9_2') !!}</h4>
                <p>{!! trans('privacynotice.chapter9_2_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter10') !!}</h3>
                <p>{!! trans('privacynotice.chapter10_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter11') !!}</h3>
                <p>{!! trans('privacynotice.chapter11_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter12') !!}</h3>
                <p>{!! trans('privacynotice.chapter12_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter12_desc2') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter13') !!}</h3>
                <p>{!! trans('privacynotice.chapter13_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter13_desc2') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter13_desc2_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter13_desc2_2') !!}</p></li>
                </ul>
                <p>{!! trans('privacynotice.chapter13_desc3') !!}</p>
                <p>{!! trans('privacynotice.chapter13_desc4') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter14') !!}</h3>
                <p>{!! trans('privacynotice.chapter14_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter15') !!}</h3>
                <p>{!! trans('privacynotice.chapter15_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_1') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_1_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_2') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_2_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter15_2_desc2') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_3') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_3_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_4') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_4_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_5') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_5_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter15_6') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_6_desc') !!}</p>
                <ul>
                    <li><p>{!! trans('privacynotice.chapter15_6_1') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter15_6_2') !!}</p></li>
                    <li><p>{!! trans('privacynotice.chapter15_6_3') !!}</p></li>
                </ul>
                <h4>{!! trans('privacynotice.chapter15_7') !!}</h4>
                <p>{!! trans('privacynotice.chapter15_7_desc') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter16') !!}</h3>
                <p>{!! trans('privacynotice.chapter16_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter16_desc2') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter17') !!}</h3>
                <p>{!! trans('privacynotice.chapter17_desc1') !!}</p>

                <hr class="space">
                <h3>{!! trans('privacynotice.chapter18') !!}</h3>
                <p>{!! trans('privacynotice.chapter18_desc1') !!}</p>
                <p>{!! trans('privacynotice.chapter18_desc2') !!}</p>
                <h4>{!! trans('privacynotice.chapter18_1') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_1_1') !!}<br>
                    {!! trans('privacynotice.chapter18_1_2') !!}<br>
                    {!! trans('privacynotice.chapter18_1_3') !!}
                </p>
                <h4>{!! trans('privacynotice.chapter18_2') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_2_1') !!}<br>
                    {!! trans('privacynotice.chapter18_2_2') !!}<br>
                    {!! trans('privacynotice.chapter18_2_3') !!}
                </p>
                <h4>{!! trans('privacynotice.chapter18_3') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_3_1') !!}<br>
                    {!! trans('privacynotice.chapter18_3_2') !!}<br>
                    {!! trans('privacynotice.chapter18_3_3') !!}
                </p>
                <h4>{!! trans('privacynotice.chapter18_4') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_4_1') !!}<br>
                    {!! trans('privacynotice.chapter18_4_2') !!}<br>
                    {!! trans('privacynotice.chapter18_4_3') !!}<br>
                    {!! trans('privacynotice.chapter18_4_4') !!}
                </p>
                <h4>{!! trans('privacynotice.chapter18_5') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_5_1') !!}<br>
                    {!! trans('privacynotice.chapter18_5_2') !!}<br>
                    {!! trans('privacynotice.chapter18_5_3') !!}
                </p>
                <h4>{!! trans('privacynotice.chapter18_6') !!}</h4>
                <p>{!! trans('privacynotice.chapter18_6_desc') !!}</p>
                <h4>{!! trans('privacynotice.chapter18_7') !!}</h4>
                <p>
                    {!! trans('privacynotice.chapter18_7_1') !!}<br>
                    {!! trans('privacynotice.chapter18_7_2') !!}<br>
                    {!! trans('privacynotice.chapter18_7_3') !!}
                </p>
            </div>
        </section>
    </div>
@endsection