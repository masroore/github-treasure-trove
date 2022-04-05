<footer class="footer">
    <div class="footer__wrapper">
        <div class="footer-block">
            <div class="footer-block__first">
                <div class="footer-name">
                    <svg class="icon-svg icon-svg-phone color-red"><use xlink:href="/its-client/img/sprite.svg#phone"></use></svg>
                    {{ trans('site.Связаться с нами') }}
                </div>
                <div class="footer-number">
                    {!! variable('company_phone', '', \UrlAliasLocalization::getCurrentLocale()) !!}
                </div>
            </div>
            <div class="footer-email">
                {!! variable('company_email', '', \UrlAliasLocalization::getCurrentLocale()) !!}
            </div>
            <div class="footer-block__second">
                <div class="footer-name">
                    <svg class="icon-svg icon-svg-place color-red"><use xlink:href="/its-client/img/sprite.svg#place"></use></svg>
                    {{ trans('site.Наш адрес') }}
                </div>
                <div class="footer-text">
                    <p>{!! variable('company_address', 'г.Одесса', \UrlAliasLocalization::getCurrentLocale()) !!}</p>
                </div>
            </div>
        </div>
        <div class="footer-block">
            <div class="footer-name">
                <svg class="icon-svg icon-svg-access-time color-red"><use xlink:href="/its-client/img/sprite.svg#access-time"></use></svg>
                {{ trans('site.График работы') }}
            </div>
            {!! variable('company_schedule_footer', '
            <div class="footer-work">
                <div class="footer-name">
                    Будние дни
                </div>
                <div class="footer-text">
                    10:00 - 19:00
                </div>
            </div>
            <div class="footer-work">
                <div class="footer-name">
                    Суббота:
                </div>
                <div class="footer-text">
                    10:00 - 16:00
                </div>
            </div>
            <div class="footer-work">
                <div class="footer-name">
                    Воскресенье:
                </div>
                <div class="footer-text">
                    Выходной
                </div>
            </div>
            ', \UrlAliasLocalization::getCurrentLocale()) !!}
        </div>

        <div class="footer-block">
            
            <div class="footer-name">
                {{ trans('site.Мы в соц. сетях') }}
            </div>

            <div class="footer-sitebar">
                @foreach($menu_items_social_network as $item)
                <a href="{{ $item->getUrl() }}"><img src="{{ optional($item->getFirstMedia('image'))->getUrl() ?? '/its-client/img/vk.png' }}" alt="{{ $item->name }}"></a>
                @endforeach
            </div>
            
            <nav class="header__menu">
                <ul>
                    @foreach($menu_items_main_menu as $item)
                        <li><a href="{{ $item->getUrl() }}" {{ $item->getTargetStr() }}>{{ $item->name }}</a></li>
                    @endforeach
                </ul>
            </nav>

        </div>

        <div class="footer-block">
            @foreach($menu_for_clients as $item)
                <div class="footer-name">
                    <a href="{{ $item->getUrl() }}" {{ $item->getTargetStr() }} @if(\Illuminate\Support\Str::is(['Опт*', 'Who*'], $item->name)) data-seo-action="wholesale_click_footer" @elseif(\Illuminate\Support\Str::is('Корп*', $item->name)) data-seo-action="corporation_click_footer" @endif class="js-seo-click">
                        <img src="{{ optional($item->getFirstMedia('image'))->getUrl() ?? '/its-client/img/work.png' }}" alt="{{ $item->name }}">
                        {{ $item->name }}
                    </a>
                </div>
            @endforeach
            <a href="#" class="logo">
                <img src="/its-client/img/logo-footer.png" alt="">
            </a>
        </div>
    </div>
</footer>