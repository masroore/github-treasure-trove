{{-- Вход на сайт --}}
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <form action="{{ route('login') }}" method="POST" class="js-ajax-form-submit">
                    @csrf
                    <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">
                    <input type="hidden" name="destination" value="">
                    <div class="modal-logo">
                        <img src="/its-client/img/logo.png" alt="">
                    </div>
                    <h2>{{ trans('site.Вход') }}</h2>
                    <div class="modal-form">
                        <div class="form-group">
                            <label>{{ trans('site.E-mail') }}</label>
                            <input type="email" class="input" name="login">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('site.Пароль') }}</label>
                            <input type="password" class="input" name="password">
                        </div>
                        <div class="form-group">
                            <div class="checkbox-group">
                                <label>
                                    <input class="checkbox" type="checkbox" name="remember" value="1">
                                    <span class="checkbox-custom"></span>
                                    <span class="label">{{ trans('site.Запомнить меня') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn-gen">{{ trans('site.Войти') }}</button>
                            <a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/password/reset/">{{ trans('site.Забыли пароль?') }}</a>
                            <p>{{ trans('site.Нет аккаунта?') }} <a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/register">{{ trans('site.Зарегистрируйтесь сейчас!') }}</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Купить в один клик --}}
<div class="modal fade" id="modal-bue-one-click" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <form action="{{ route('shopping-cart.order-now') }}"
                      method="POST"
                      class="js-ajax-form-submit"
                      data-id="buy-one-click"
                      data-seo-action="quick_order_success"
                >
                    <input type="hidden" name="product_id" value="">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">
                    @csrf
                    <div class="modal-logo">
                        <img src="/its-client/img/logo.png" alt="">
                    </div>
                    <div class="modal-form">
                        <div class="form-group">
                            <label><span>*</span> {{ trans('site.Имя') }}</label>
                            <input type="text" class="input" name="name">
                        </div>
                        <div class="form-group">
                            <label><span>*</span> {{ trans('site.Телефон') }}</label>
                            <input type="text" class="input phone" name="phone" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true">
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn-gen">{{ trans('site.Заказать сейчас') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Выбрать цвет --}}
<div class="modal modal-change-color fade" id="modal-change-color" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>

            </div>
            <div class="modal-color-change">
                <form action="{{ route('shopping-cart.order-now') }}"
                      method="POST"
                      class="js-ajax-form-submit"
                      data-id="buy-one-click"
                >
                    <input type="hidden" name="product_id"  value="">
                    <input type="hidden" name="product-group-id"  value="">
                    <input type="hidden" name="group-wrapper-id"  value="">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">
                    @csrf
                    <div class="modal-form">
                        <ul>

{{--                            @if($tining)--}}
                            @foreach($tining as $item)
                            <li class="li_wrap">
                                <span class="color-name">{{$item->name}}</span>
                                <input data-title="{{$item->name}}" data-price="{{$item->markup}}" type="radio" id="{{$item->id}}" data-html-container=".item__info-color" name="color" style="display:none;" class="color_input js-color-input" value="{{$item->markup}}" data-color-code="{{$item->value}}">
                                <label data-toggle="tooltip" title="{{$item->name}}" for="{{$item->id}}" style="background:{{'#' . $item->value}};@if($item->markup == '0.00') border: 2px solid #ff0000; @endif" class="color"></label>
                                @if($item->markup == '0.00')
                                    <span class="color-free">Бесплатно</span>
                                @endif
                            </li>
                            @endforeach
{{--                            @endif--}}
                        </ul>
                    </div>
{{--                    <div class="form-button">--}}
{{--                        <button type="submit" class="btn-gen">{{ trans('site.Выбрать') }}</button>--}}
{{--                    </div>--}}
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Оставить отзыв --}}
<div class="modal modal_feedback fade" id="modal-add-reviews" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <form action="{{ route('product-review.store') }}" method="POST" class="js-ajax-form-submit" data-id="form-add-review">
                    @csrf
                    <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">
                    <input type="hidden" name="product_id" value="">
                    <div class="modal-logo">
                        <img src="/its-client/img/logo.png" alt="">
                    </div>
                    <h2>{{ trans('site.Оставьте ваш отзыв') }}</h2>
                    <h3>{{ trans('site.Для нас это очень важно!') }}</h3>
                    <div class="modal-form">
                        {{--
                        <div class="form-group">
                            <label for="">Имя
                                <span>*</span>
                            </label>
                            <input type="text" class="input">
                        </div>
                        --}}
                        <div class="form-group">
                            <label>{{ trans('site.Отзыв') }}
                                <span>*</span>
                            </label>
                            <textarea type="text" class="input" name="body"></textarea>
                        </div>
                        <div class="form-rating form-group">
                            <div class="rating-top__star-block">
                                <div class="rating" data-path='/its-client/img/'>
                                    <img src="/its-client/img/big-star.png" alt="" value="1">
                                    <img src="/its-client/img/big-star.png" alt="" value="2">
                                    <img src="/its-client/img/big-star.png" alt="" value="3">
                                    <img src="/its-client/img/big-star.png" alt="" value="4">
                                    <img src="/its-client/img/big-star.png" alt="" value="5">
                                    <input type="text" name="rating" hidden data-value=''>
                                </div>
                            </div>
                            <span>— {{ trans('site.пожалуйста, оцените нашу продукцию') }}</span>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn-gen">{{ trans('site.Отправить') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Ваша заявка принята --}}
<div class="modal modal_feedback modal_feedback-end fade" id="modal-feedback-end" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>
                <h2><img src="/its-client/img/ok.png" alt="">{{ trans('site.Ваша заявка принята') }}</h2>
                <h3>{{ trans('site.Наш менеджер свяжется с вами в ближайшее время') }}</h3>
                <a href="{{ \UrlAliasLocalization::getRoot() }}" class="btn-gen">{{ trans('site.Вернуться на главную страницу') }}</a>
            </div>
        </div>
    </div>
</div>

{{-- Спасибо за отзыв! --}}
<div class="modal modal_feedback modal_feedback-end fade" id="modal-thank" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>
                <h2><img src="/its-client/img/ok.png" alt="">{{ trans('site.Спасибо за отзыв!') }}</h2>
                <h3>{{ trans('site.Вы внесли вклад в развитие компании') }}</h3>
                <a href="{{ \UrlAliasLocalization::getRoot() }}" class="btn-gen">{{ trans('site.Вернуться на главную страницу') }}</a>
            </div>
        </div>
    </div>
</div>

{{-- Информация успешно сохранена --}}
<div class="modal modal_feedback modal_feedback-end fade" id="modal-default-thank" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>
                <h2><img src="/its-client/img/ok.png" alt="">{{ trans('site.Отлично!') }}</h2>
                <h3>{{ trans('site.Информация успешно сохранена') }}</h3>
                <a href="{{ \UrlAliasLocalization::getRoot() }}" class="btn-gen">{{ trans('site.Вернуться на главную страницу') }}</a>
            </div>
        </div>
    </div>
</div>

{{-- Мы выслали вам новый пароль --}}
<div class="modal modal_feedback modal_feedback-end fade" id="modal-reset-password-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>
                <h2>{{ trans('site.Мы выслали вам новый пароль') }}</h2>
                <h3>{{ trans('site.Пожалуйста, проверьте почту указанную при восстановлении. Мы выслали вам новый пароль.') }}
                    <br>
                    <br>
                    {{ trans('site.Если вы не получили письмо с восстановлением пароля, проверьте папку «спам».') }}
                </h3>
                <a href="{{ \UrlAliasLocalization::getRoot() }}" class="btn-gen">{{ trans('site.Вернуться на главную страницу') }}</a>
            </div>
        </div>
    </div>
</div>


<div class="modal modal_feedback modal_feedback-end fade" id="modal-reset-password-info-repeat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="modal-logo">
                    <img src="/its-client/img/logo.png" alt="">
                </div>
                <h2>{{ trans('site.Мы выслали вам новый пароль') }}</h2>
                <h3>{{ trans('site.Пожалуйста, проверьте почту указанную при восстановлении. Мы выслали вам новый пароль.') }}
                    <br>
                    <br>
                    {{ trans('site.Если вы не получили письмо с восстановлением пароля, проверьте папку «спам».') }}
                </h3>
                <a href="{{ \UrlAliasLocalization::getRoot() }}" class="btn-gen">{{ trans('site.Вернуться на главную страницу') }}</a>
                <h3>{{ trans('site.Мы выслали вам новый пароль еще раз.') }}</h3>
            </div>
        </div>
    </div>
</div>

@stack('modals')