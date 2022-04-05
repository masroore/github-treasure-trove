@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Карта сайта',
        'small_page_title' => '',
        'url_back' => '',
        //'url_create' => route('admin.pages.create')
    ]
@endphp

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-6">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Настройки генерации XML-карты сайта</h3>
                    </div>
                    <form action="{{ route('admin.site-map.update') }}" method="POST">

                        <div class="box-body">
                            @csrf
                            <input type="hidden" name="destination" value="{{ \Request::fullUrl() }}">

                            <p><a href="/sitemap.xml" target="_blank"><i class="fa fa-search"></i> Просмотр карты - sitemap.xml</a></p>
                            <p><a href="#" class="js-action-click" data-url="{{ route('admin.site-map.regenerate') }}" data-method="POST" data-confirm="Запустить перегенерацию карты сайта?"><i class="fa fa-recycle"></i> Генерировать новую карту</a></p>
                            <p><a href="#" class="js-action-click" data-url="{{ route('admin.site-map.destroy') }}" data-method="DELETE" data-confirm="Действительно удалить карту сайта?"><i class="fa fa-trash"></i> Удалить файл карты</a></p>
                            <hr>

                            @include('admin.fields.field-select2-static', [
                                'label' => 'CRON-расписание генерации',
                                'field_name' => 'vars[sitemap_schedule_cron]',
                                'attributes' => [
                                    '' => 'Отключить генерацию',
                                    '*/5 * * * *' => 'Каждые 5 мин.',
                                    '0 * * * *' => 'Каждый час',
                                    '0 0 * * *' => 'Каждый день в полночь (00:00)',
                                    '0 0 * * 0' => 'Каждое воскресенье в полночь (00:00)',
                                    '0 0 1 * *' => 'Каждую месяц, 1 числа в полночь (00:00)',
                                ],
                                'empty_value' => 'Отключено',
                                'selected' => variable('sitemap_schedule_cron'),
                            ])
                            {{--<p class="help-block small">* Должно быть записано валидное <a href="https://www.freeformatter.com/cron-expression-generator-quartz.html">CRON-выражение</a></p>--}}


                            @include('admin.fields.field-select2-static', [
                                'label' => 'priority',
                                'field_name' => 'vars[sitemap_priority]',
                                'attributes' => array_combine(config('meta-tags.values.priority', []), config('meta-tags.values.priority', [])),
                                'selected' => variable('sitemap_priority', 0.5),
                            ])
                            @include('admin.fields.field-select2-static', [
                                'label' => 'changefreq',
                                'field_name' => 'vars[sitemap_changefreq]',
                                'attributes' => array_combine(config('meta-tags.values.changefreq', []), config('meta-tags.values.changefreq', [])),
                                'selected' => variable('sitemap_changefreq', 'daily'),
                            ])
                        </div>

                        <div class="box-footer">
                            @include('admin.fields.field-form-buttons')
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>

    </section>
@endsection