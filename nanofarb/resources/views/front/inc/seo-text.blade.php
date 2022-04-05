@if(MetaTag::tag('seo_text'))
    <div class="product-right__bottom">
        <div class="products__info">
            <p>{!! MetaTag::tag('seo_text') !!}</p>
            <button class="products__info-btn">
                <span>{{ trans('site.Показать полностью') }}</span>
                <span>{{ trans('site.Скрыть') }}</span>
            </button>
        </div>
    </div>
@endif