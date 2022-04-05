@php($locale = request('var_locale', \UrlAliasLocalization::getDefaultLocale()))
<div class="row margin-bottom">
    <div class="col-md-12">
        <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                @foreach(\UrlAliasLocalization::getSupportedLanguagesKeys() as $key)
                    <li class="@if($locale === $key) active @endif">
                        <a href="{{ \Illuminate\Support\Facades\Request::fullUrlWithQuery(['var_locale' => $key]) }}" title="">{{ $key }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>