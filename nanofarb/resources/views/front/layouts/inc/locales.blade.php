@if(config('url-aliases.use_localization'))
<div class="header__subline">
    <div class="lang-link">
        @if(isset($localeboundAlternativeSegmentUrl) && is_string($localeboundAlternativeSegmentUrl))
            @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $value)
                <a href="{{ url($key . '/' . trim($localeboundAlternativeSegmentUrl, '/')) }}" class="@if($key === \UrlAliasLocalization::getCurrentLocale()) active @endif">
                    {{ strtoupper($key) }}
{{--                    <img src="/vendor/flags/{{$key}}.png" alt="{{$key}}">--}}
                </a>
            @endforeach
        @else
            @foreach(\UrlAliasLocalization::getLocalesModelsBound(isset($localebound) ? $localebound : null) as $key => $value)
                <a href="{{ $value['url'] }}" class="@if($key === \UrlAliasLocalization::getCurrentLocale()) active @endif">
                    {{ strtoupper($key) }}
{{--                    <img src="/vendor/flags/{{$key}}.png" alt="{{$key}}">--}}
                </a>
            @endforeach
        @endif
    </div>
</div>
@endif

@if(0)
    <div class="">
        <select name="locale" class="js-set-locale">
            @foreach(\UrlAliasLocalization::getLocalesModelsBound(isset($localebound) ? $localebound : null) as $key => $value)
                <option value="{{ $value['url'] }}"
                        @if($key === \UrlAliasLocalization::getCurrentLocale()) selected @endif
                >{{ $key }}</option>
            @endforeach
        </select>
    </div>
    @push('scripts')
        <script>
            $('select.js-set-locale').on('change', function () {
                window.location.href = $(this).val()
            })
        </script>
    @endpush
@endif