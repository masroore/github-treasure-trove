<header class="header @auth active @endauth">
    <div class="header__wrapper">
        <button class="mobile-menu__btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="mobile-menu__logo">
            <a href="{{ \UrlAliasLocalization::getRoot() }}" class="logo">
                <img src="/its-client/img/logo.png" alt="logo">
            </a>
        </div>
        <div class="mobile-menu">
            <div class="header__mobile-info">
                <div class="header__right">
                    <div class="header__right-search">
                        <div class="head-search__hide">
                            <form action="{{ route_alias('product.search') }}" method="GET">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск на сайте">
                                <button type="submit" class="search">
                                    <img src="/its-client/img/search.png" alt="search">
                                </button>
                            </form>
                        </div>
                        <button class="header__right-search-btn">
                            <img src="/its-client/img/search.png" alt="">
                        </button>
                    </div>
                    @auth
                        <a href="{{ route_alias('account.edit') }}" class="header__right-basket">
                            <svg class="icon-svg icon-svg-account color-red"><use xlink:href="/its-client/img/sprite.svg#account"></use></svg>
                            {{ trans('site.Личный кабинет') }}
                        </a>
                    @endauth
                        <a href="{{ route('shopping-cart.index') }}" class="header__right-basket">
                            <p><svg class="icon-svg icon-svg-basket color-red"><use xlink:href="/its-client/img/sprite.svg#basket"></use></svg>
                                <span class="js-cart-in-header" @unless(\Cart::count())style="display: none"@endunless>{{ \Cart::count() }}</span>
                            </p>
                            {{ trans('site.Корзина') }}
                        </a>
                    @auth
                    <a href="#" class="header__right-log-in js-action-click" data-url="{{ route('logout', ['locale' => \UrlAliasLocalization::getCurrentLocale()]) }}">
                        <p>
                            <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>
                            {{ trans('site.Выйти') }}
                        </p>
                    </a>
                    @else
                        <a href="#" class="header__right-basket" data-toggle="modal" data-target="#modal-login">
                            <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>
                            {{ trans('site.Войти в аккаунт') }}
                        </a>

                        <a href="/register" class="header__right-log-in">
                            <p>
                                <svg class="icon-svg icon-svg-account color-red"><use xlink:href="/its-client/img/sprite.svg#account"></use></svg>
                                {{ trans('site.Зарегистрироваться') }}
                            </p>
                        </a>
                    @endauth
                </div>
                <div class="header__left">
                    <a href="/" class="logo">
                        <img src="/its-client/img/logo.png" alt="">
                    </a>
                    <nav class="header__menu">
                        <ul>
                            @foreach($menu_items_main_menu as $item)
                            <li><a href="{{ $item->getUrl() }}" {{ $item->getTargetStr() }}>{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header__left">
            <a href="{{  \UrlAliasLocalization::getRoot() }}" class="logo">
                <img src="/its-client/img/logo.png" alt="">
            </a>
            <nav class="header__menu">
                <ul>
                    @foreach($menu_items_main_menu as $item)
                        <li><a href="{{ $item->getUrl() }}" {{ $item->getTargetStr() }}>{{ $item->name }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="header__right">
            <div class="header__right-search">
                <div class="head-search__hide">
                    <form action="{{ route_alias('product.search') }}" method="GET">
                        <input type="text" name="q" required value="{{ request('q') }}">
                        <button type="submit" class="search">
                            <img src="/its-client/img/search-gray.png" alt="{{ trans('site.Поиск') }}">
                        </button>
                    </form>
                </div>
                <button class="header__right-search-btn">
                    <img src="/its-client/img/search.png" alt="">
                </button>
            </div>
            <div class="header__right-phone">
                <svg class="icon-svg icon-svg-phone color-red"><use xlink:href="/its-client/img/sprite.svg#phone"></use></svg>
                <span>{!! variable('company_phone', '', \UrlAliasLocalization::getCurrentLocale()) !!}</span>
                <svg class="icon-svg icon-svg-navigate_header color-red"><use xlink:href="/its-client/img/sprite.svg#navigate_header"></use></svg>
                <div class="header-phone__hide">
                    <ul>
                        @foreach(json_decode(variable('phones_header', '[]', \UrlAliasLocalization::getCurrentLocale()), true) as $phone)
                        <li>{{ $phone }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

                <a href="{{ route_alias('shopping-cart.index') }}" class="header__right-basket">

                    <p><svg class="icon-svg icon-svg-basket color-red"><use xlink:href="/its-client/img/sprite.svg#basket"></use></svg>
                        <span class="js-cart-in-header" @unless(\Cart::count())style="display: none"@endunless>{{ \Cart::count() }}</span>
                    </p>
{{--                    <span>{{ trans('site.Корзина') }}</span>--}}
                </a>
            @auth
                <a href="{{ route_alias('account.edit') }}" class="header__right-log-in">
                    <svg class="icon-svg icon-svg-account color-red"><use xlink:href="/its-client/img/sprite.svg#account"></use></svg>
{{--                    <span>{{ trans('site.Личный кабинет') }}</span>--}}
                </a>

                <a href="#" class="header__right-log-in js-action-click" data-url="{{ route('logout', ['locale' => \UrlAliasLocalization::getCurrentLocale()]) }}">
                    <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>
{{--                    <span>{{ trans('site.Выйти') }}</span>--}}
                </a>
            @else
                <button class="header__right-log-in" data-toggle="modal" data-target="#modal-login">
                    <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>

{{--                    <svg class="icon-svg icon-svg-basket color-red"><use xlink:href="/its-client/img/sprite.svg#basket"></use></svg>--}}
{{--                    {{ trans('site.Войти в аккаунт') }}--}}
                </button>
                {{--
                <a href="/register" class="header__right-log-in">
                    <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>
                    Зарегистрироваться
                </a>
                --}}
            @endauth
            @include('front.layouts.inc.locales')
        </div>

        <div class="header-mobile__block">
            <a href="{{ route_alias('shopping-cart.index') }}" class="header-mobile__basket header__right-basket">
                <p><svg class="icon-svg icon-svg-basket color-red"><use xlink:href="/its-client/img/sprite.svg#basket"></use></svg>
                    <span class="js-cart-in-header" @unless(\Cart::count())style="display: none"@endunless>{{ \Cart::count() }}</span>
                </p>
            </a>
            @auth
            <a href="{{ route_alias('account.edit') }}" class="header-mobile__login">
                <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#account"></use></svg>
            </a>
            @else
            <a href="#" class="header-mobile__login" data-toggle="modal" data-target="#modal-login">
                <svg class="icon-svg icon-svg-lock_open color-red"><use xlink:href="/its-client/img/sprite.svg#lock_open"></use></svg>
            </a>
            @endauth
            @include('front.layouts.inc.locales')

        </div>
    </div>

{{--
    @if(config('url-aliases.use_localization'))
    <div class="header__wapper__subline">
        <div class="header__subline">
            <div class="lang-link">
                @if(isset($localeboundAlternativeSegmentUrl) && is_string($localeboundAlternativeSegmentUrl))
                    @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $value)
                    <a href="{{ url($key . '/' . trim($localeboundAlternativeSegmentUrl, '/')) }}" class="@if($key === \UrlAliasLocalization::getCurrentLocale()) active @endif">
                        <img src="/vendor/flags/{{$key}}.png" alt="{{$key}}">
                    </a>
                    @endforeach
                @else
                    @foreach(\UrlAliasLocalization::getLocalesModelsBound(isset($localebound) ? $localebound : null) as $key => $value)
                    <a href="{{ $value['url'] }}" class="@if($key === \UrlAliasLocalization::getCurrentLocale()) active @endif">
                        <img src="/vendor/flags/{{$key}}.png" alt="{{$key}}">
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
--}}

</header>