@extends('front.layouts.app')

@php
    MetaTag::setEntity($page)->setDefault(['title' => $page->name]);
    $localebound = $page->getLocaleboundStr();
@endphp

@section('content')
    <div class="personal personal_request">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('page', $page) !!}
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ $page->name }}</h1>
            <div class="request__text">
                {{ trans('site.Заполните заявку, и наш менеджер свяжется с вами в ближайшее время') }}
            </div>
            <form action="{{ route('form.store') }}" method="POST" class="js-ajax-form-submit" data-id="request-form-create">
                @csrf
                <input type="hidden" name="type" value="request">
                <div class="personal-content">
                    <div class="personal-content__left">
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.ФИО') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="text" name="name">
                            </div>
                            <div class="form-group">
                                <label>
                                    E-mail
                                </label>
                                <input class="input" type="email" name="email">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Город, область') }}
                                </label>
                                <input class="input" type="text" name="address">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Телефон') }}
                                    <span>*</span>
                                </label>
                                <input class="input phone" name="phone" type="text" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Вид торговых услуг') }}
                                </label>
                                <select class="select-filter" id="select2-filter" name="terms[types_trade_services][]" required>
                                    <option value="">----</option>
                                    @foreach(\App\Models\Taxonomy\Term::byLocale()->byVocabulary('types_trade_services')->get() as $tern)
                                        <option value="{{$tern->id}}">{{$tern->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="personal-content__left-bottom">
                            {{--
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <label>
                                        <input type="hidden" name="subscribe" value="0">
                                        <input class="checkbox" type="checkbox" name="subscribe" value="1">
                                        <span class="checkbox-custom"></span>
                                        <span class="label">Подписаться на новости и акции</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <label>
                                        <input type="hidden" name="accept" value="0">
                                        <input class="checkbox" type="checkbox" name="accept" value="1">
                                        <span class="checkbox-custom"></span>
                                        <span class="label">Я согласен(-на) с <a href="/policy/">политикой конфиденциальности*</a></span>
                                    </label>
                                </div>
                            </div>
                            --}}
                        </div>
                    </div>
                    <div class="personal-content__right">
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Комментарий') }}
                                </label>
                                <textarea class="input" name="message"></textarea>
                            </div>
                        </div>
                        <div class="personal-content__right-bottom">
                            <div class="form-button">
                                <button type="submit" class="btn-gen">{{ trans('site.Отправить') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
