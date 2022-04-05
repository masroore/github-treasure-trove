@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('termofservice.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('termofservice.page_title') }}</h1>
                    <span>{{ trans('termofservice.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            <div class="container">
                <section id="summary" class="p-0">
                    <h3>{{ trans('termofservice.title1') }}</h3>
                    <p>{!! trans('termofservice.content1_1', ['complete' => trans('termofservice.complete')]) !!}</p>
                    <p>{{ trans('termofservice.content1_2') }}</p>
                    <ul>
                        <li><b>{{ trans('termofservice.content1_2_1') }}</b></li>
                        <p>{{ trans('termofservice.content1_2_1_desc') }}</p>
                        <li><b>{{ trans('termofservice.content1_2_2') }}</b></li>
                        <p>{!! trans('termofservice.content1_2_2_desc', ['eligibility' => trans('termofservice.eligibility'), 'acceptable' => trans('termofservice.acceptable')]) !!}</p>
                        <li><b>{{ trans('termofservice.content1_2_3') }}</b></li>
                        <p>{!! trans('termofservice.content1_2_3_desc', ['margin' => trans('termofservice.margin'), 'trading' => trans('termofservice.trading'), 'risks' => trans('termofservice.risks')]) !!}</p>
                        <li><b>{{ trans('termofservice.content1_2_4') }}</b></li>
                        <p>{!! trans('termofservice.content1_2_4_desc', ['indemnity' => trans('termofservice.indemnity'), 'limitation' => trans('termofservice.limitation'), 'disclaimer' => trans('termofservice.disclaimer'), 'support_url' => trans('termofservice.support_url')]) !!}</p>
                    </ul>
                </section>

                <hr class="space">
                <section id="complete" class="p-0">
                    <h4>{{ trans('termofservice.title2') }}</h4>
                    <p>{!! trans('termofservice.content2_1') !!}</p>
                    <p>{!! trans('termofservice.content2_2') !!}</p>
                    <ol>
                        <li><p>{!! trans('termofservice.content2_1_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_1_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_1_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_1_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_1_5') !!}</p></li>
                    </ol>
                    <h4>{!! trans('termofservice.title2_3') !!}</h4>
                    <p>{!! trans('termofservice.content2_3') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.content2_3_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_5') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_6') !!}</p></li>
                        <li><p>{!! trans('termofservice.content2_3_7') !!}</p></li>
                    </ul>
                </section>

                <hr class="space">
                <section id="eligibility" class="p-0">
                    <h4>{{ trans('termofservice.title3') }}</h4>
                    <p>{!! trans('termofservice.content3_1') !!}</p>
                    <p>{!! trans('termofservice.content3_2') !!}</p>
                    <p>{!! trans('termofservice.content3_3') !!}</p>
                </section>

                <hr class="space">
                <section id="account" class="p-0">
                    <h4>{{ trans('termofservice.title4') }}</h4>
                    <p>{!! trans('termofservice.content4_1') !!}</p>
                    <p>{!! trans('termofservice.content4_2') !!}</p>
                </section>

                <hr class="space">
                <section id="account" class="p-0">
                    <h4>{{ trans('termofservice.title5') }}</h4>
                    <p>{!! trans('termofservice.content5_1', ['privacy' => trans('termofservice.privacy')]) !!}</p>
                </section>

                <hr class="space">
                <section id="obligations" class="p-0">
                    <h4>{{ trans('termofservice.title6') }}</h4>
                    <p>{!! trans('termofservice.content6') !!}</p>
                    <ol>
                        <li><p>{!! trans('termofservice.content6_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content6_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content6_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content6_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content6_5') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="obligations" class="p-0">
                    <h4>{{ trans('termofservice.title7') }}</h4>
                    <ol>
                        <li><p>{!! trans('termofservice.content7_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content7_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content7_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content7_4') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="exchange" class="p-0">
                    <h4>{{ trans('termofservice.title8') }}</h4>
                    <p>{{ trans('termofservice.content8') }}</p>
                    <ol>
                        <li><p>{!! trans('termofservice.content8_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content8_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content8_3') !!}</p></li>
                        <li><section id="trade_option" class="p-0"><p>{!! trans('termofservice.content8_4') !!}</p></section></li>
                        <li><p>{!! trans('termofservice.content8_5') !!}</p></li>
                        <li><p>{!! trans('termofservice.content8_6') !!}</p></li>
                        <li><p>{!! trans('termofservice.content8_7') !!}</p></li>
                        <li>
                            <section id="margin_transaction" class="p-0">
                            <p>{!! trans('termofservice.content8_8') !!}</p>
                            <ul>
                                <li><p>{!! trans('termofservice.content8_8_c1') !!}</p></li>
                                <li><p>{!! trans('termofservice.content8_8_c2', ['disclosure' => trans('termofservice.disclosure')]) !!}</p></li>
                                <li>
                                    <p>{!! trans('termofservice.content8_8_c3') !!}</p>
                                    <ol>
                                        <li><p>{!! trans('termofservice.content8_8_1') !!}</p></li>
                                        <li>
                                            <p>{!! trans('termofservice.content8_8_2') !!}</p>
                                            <ol>
                                                <li><p>{!! trans('termofservice.content8_8_2_1') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_2_2') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_2_3') !!}</p></li>
                                            </ol>
                                        </li>
                                        <li>
                                            <p>{!! trans('termofservice.content8_8_3') !!}</p>
                                            <ol>
                                                <li><p>{!! trans('termofservice.content8_8_3_1') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_3_2') !!}</p></li>
                                            </ol>
                                        </li>
                                        <li><p>{!! trans('termofservice.content8_8_4') !!}</p></li>
                                        <li>
                                            <p>{!! trans('termofservice.content8_8_5') !!}</p>
                                            <ol>
                                                <li><p>{!! trans('termofservice.content8_8_5_1') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_5_2') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_5_3') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_5_4') !!}</p></li>
                                            </ol>
                                        </li>
                                        <li><p>{!! trans('termofservice.content8_8_6') !!}</p></li>
                                        <li>
                                            <p>{!! trans('termofservice.content8_8_7') !!}</p>
                                            <ol>
                                                <li><p>{!! trans('termofservice.content8_8_7_1') !!}</p></li>
                                                <li><p>{!! trans('termofservice.content8_8_7_2') !!}</p></li>
                                            </ol>
                                        </li>
                                        <li><p>{!! trans('termofservice.content8_8_8') !!}</p></li>
                                    </ol>
                                </li>
                            </ul>
                            </section>
                        </li>
                    </ol>
                </section>

                <hr class="space">
                <section id="risks" class="p-0">
                    <h4>{{ trans('termofservice.title9') }}</h4>
                    <ol>
                        <li>
                            <p>{!! trans('termofservice.content9_1') !!}</p>
                            <ol>
                                <li><p>{!! trans('termofservice.content9_1_1') !!}</p></li>
                                <li><p>{!! trans('termofservice.content9_1_2') !!}</p></li>
                                <li><p>{!! trans('termofservice.content9_1_3') !!}</p></li>
                                <li><p>{!! trans('termofservice.content9_1_4') !!}</p></li>
                                <li><p>{!! trans('termofservice.content9_1_5', ['disclosure' => trans('termofservice.disclosure')]) !!}</p></li>
                            </ol>
                        </li>
                        <li><p>{!! trans('termofservice.content9_2') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title10') }}</h4>
                    <p>{!! trans('termofservice.content10') !!}</p>
                    <ol>
                        <li><p>{!! trans('termofservice.content10_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content10_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content10_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content10_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content10_5') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title11') }}</h4>
                    <ol>
                        <li><p>{!! trans('termofservice.content11_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content11_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content11_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content11_4') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title12') }}</h4>
                    <ol>
                        <li><p>{!! trans('termofservice.content12_1', ['support_url' => trans('termofservice.support_url')]) !!}</p></li>
                        <li><p>{!! trans('termofservice.content12_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content12_3', ['support_url' => trans('termofservice.support_url')]) !!}</p></li>
                        <li><p>{!! trans('termofservice.content12_4', ['support_url' => trans('termofservice.support_url')]) !!}</p></li>
                        <li><p>{!! trans('termofservice.content12_5', ['support_url' => trans('termofservice.support_url')]) !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title13') }}</h4>
                    <p>{!! trans('termofservice.content13') !!}</p>
                </section>

                <hr class="space">
                <section id="acceptable_use" class="p-0">
                    <h4>{{ trans('termofservice.title14') }}</h4>
                    <p>{!! trans('termofservice.content14') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.content14_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_5') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_6') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_7') !!}</p></li>
                        <li><p>{!! trans('termofservice.content14_8') !!}</p></li>
                    </ul>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title15') }}</h4>
                    <p>{!! trans('termofservice.content15') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title16') }}</h4>
                    <p>{!! trans('termofservice.content16_1') !!}</p>
                    <p>{!! trans('termofservice.content16_2') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title17') }}</h4>
                    <p>{!! trans('termofservice.content17') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title18') }}</h4>
                    <p>{!! trans('termofservice.content18') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title19') }}</h4>
                    <p>{!! trans('termofservice.content19') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title20') }}</h4>
                    <p>{!! trans('termofservice.content20') !!}</p>
                </section>

                <hr class="space">
                <section id="disclaimer" class="p-0">
                    <h4>{{ trans('termofservice.title21') }}</h4>
                    <p>{!! trans('termofservice.content21_1') !!}</p>
                    <p>{!! trans('termofservice.content21_2') !!}</p>
                    <p>{!! trans('termofservice.content21_3') !!}</p>
                </section>

                <hr class="space">
                <section id="limitation" class="p-0">
                    <h4>{{ trans('termofservice.title22') }}</h4>
                    <p>{!! trans('termofservice.content22_1') !!}</p>
                    <p>{!! trans('termofservice.content22_2') !!}</p>
                    <p>{!! trans('termofservice.content22_3') !!}</p>
                </section>

                <hr class="space">
                <section id="indemnity" class="p-0">
                    <h4>{{ trans('termofservice.title23') }}</h4>
                    <p>{!! trans('termofservice.content23') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title24') }}</h4>
                    <p>{!! trans('termofservice.content24_1') !!}</p>
                    <p>{!! trans('termofservice.content24_2', ['mail_addr' => trans('termofservice.mail_addr')]) !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title25') }}</h4>
                    <ol>
                        <li><p>{!! trans('termofservice.content25_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_5') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_6') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_7') !!}</p></li>
                        <li><p>{!! trans('termofservice.content25_8') !!}</p></li>
                    </ol>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h4>{{ trans('termofservice.title26') }}</h4>
                    <p>{!! trans('termofservice.content26') !!}</p>
                </section>

                <hr class="space">
                <section id="margin_disclosure" class="p-0">
                    <h3>{{ trans('termofservice.chapter2') }}</h3>
                    <p>{!! trans('termofservice.chapter2_desc1', ['support_url' => trans('termofservice.support_url')]) !!}</p>
                    <p>{!! trans('termofservice.chapter2_desc2') !!}</p>
                    <p>{!! trans('termofservice.chapter2_desc3') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.chapter2_desc3_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_desc3_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_desc3_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_desc3_4') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_desc3_5') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_desc3_6') !!}</p></li>
                    </ul>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_a') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_a_sub') }}</h4>
                    <p>{!! trans('termofservice.chapter2_a_1', ['synapsepay_url' => trans('termofservice.synapsepay_url')]) !!}</p>
                    <p>{!! trans('termofservice.chapter2_a_2', ['synapsepay_url' => trans('termofservice.synapsepay_url')]) !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_b') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_b_sub') }}</h4>
                    <p>{!! trans('termofservice.chapter2_b_desc') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_1') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_1_a') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_b') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_c') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_d') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_e') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_f') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_g') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_h') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_i') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_j') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_k') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_l') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_m') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_1_n') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_2') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_2_a') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.chapter2_b_2_a_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_2_a_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_2_a_3') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_2_a_4') !!}</p></li>
                    </ul>
                    <p>{!! trans('termofservice.chapter2_b_2_b') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_2_c') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_3') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_3_a') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_3_b') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.chapter2_b_3_b_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_3_b_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_3_b_3') !!}</p></li>
                    </ul>
                    <p>{!! trans('termofservice.chapter2_b_3_c') !!}</p>
                    <ul>
                        <li><p>{!! trans('termofservice.chapter2_b_3_c_1') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_3_c_2') !!}</p></li>
                        <li><p>{!! trans('termofservice.chapter2_b_3_c_3') !!}</p></li>
                    </ul>
                    <p>{!! trans('termofservice.chapter2_b_3_d') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_4') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_4_desc') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_5') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_5_a') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_5_b') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_5_c') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_5_d') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_6') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_6_a') !!}</p>
                    <p>{!! trans('termofservice.chapter2_b_6_b') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_7') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_7_desc') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_8') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_8_desc') !!}</p>

                    <h4>{!! trans('termofservice.chapter2_b_9') !!}</h4>
                    <p>{!! trans('termofservice.chapter2_b_9_desc') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_c') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_c_sub') }}</h4>
                    <p>{!! trans('termofservice.chapter2_c_1') !!}</p>
                    <p>{!! trans('termofservice.chapter2_c_2') !!}</p>
                    <p>{!! trans('termofservice.chapter2_c_3') !!}</p>
                    <p>{!! trans('termofservice.chapter2_c_4') !!}</p>
                    <p>{!! trans('termofservice.chapter2_c_5') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_d') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_d_sub') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_desc1') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_desc2') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_desc3') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_1') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_1_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_1_b') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_1_c') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_1_d') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_2') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_2_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_2_b') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_2_c') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_2_d') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_3') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_3_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_3_b') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_3_c') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_3_d') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_3_e') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_3_f') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_4') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_4_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_4_b') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_5') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_5_desc') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_6') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_6_desc') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_6_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_6_b') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_6_c') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_6_d') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_7') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_7_desc') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_8') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_8_desc') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_b') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_c') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_d') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_e') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_f') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_g') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_8_h') }}</p>

                    <h4>{{ trans('termofservice.chapter2_d_9') }}</h4>
                    <p>{{ trans('termofservice.chapter2_d_9_a') }}</p>
                    <p>{{ trans('termofservice.chapter2_d_9_b') }}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_e') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_e_sub') }}</h4>
                    <p>{!! trans('termofservice.chapter2_e_1') !!}</p>
                    <p>{!! trans('termofservice.chapter2_e_2') !!}</p>
                    <p>{!! trans('termofservice.chapter2_e_3') !!}</p>
                    <p>{!! trans('termofservice.chapter2_e_4') !!}</p>
                    <p>{!! trans('termofservice.chapter2_e_5') !!}</p>
                </section>

                <hr class="space">
                <section id="" class="p-0">
                    <h3>{{ trans('termofservice.chapter2_f') }}</h3>
                    <h4>{{ trans('termofservice.chapter2_f_sub') }}</h4>
                    <p>{!! trans('termofservice.chapter2_f_1') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_2') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_3') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_3_desc') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_4') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_4_desc') !!}</p>
                    <p>{!! trans('termofservice.chapter2_f_5') !!}</p>
                </section>
            </div>
        </section>
    </div>
@endsection