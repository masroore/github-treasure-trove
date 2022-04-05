@extends('front.layouts.app', [
    // for on scroll pagination
    "bodyAttrs" => "data-next-page-url={$products->nextPageUrl()}
                    data-content-container='.show-more-content-container'
                    data-show-more-loader='.show-more-loader'
                    "
                    //class='show-more-scroll-container'
])

@php
    MetaTag::setDefault(['title' => $category->name . " - {$products->total()} товаров"]);
    FacetFilter::setUrlPath(\UrlAlias::current());
    $localebound = $category->getLocaleboundStr();
@endphp

@section('content')
    <div class="product">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('category', $category) !!}
        </div>
        <div class="product__wrapper">
            <div class="product-left">
                <div class="product-left__content">
                    <div class="product-filter__repeat">
                        <button class="btn-gen product-left__mobile-btn" href="{{ \Illuminate\Support\Facades\URL::previous() }}">
                            <svg class="icon-svg icon-svg-keyboard color-red"><use xlink:href="/its-client/img/sprite.svg#keyboard"></use></svg>
                            {{ trans('site.Вернуться назад') }}
                        </button>

                        @if($categories->count())
                            <div class="product-filter">
                                <div class="product-filter__name @if(\FacetFilter::has('category')) active @endif">{{ trans('site.Категория') }}
                                    <svg class="icon-svg icon-svg-navigate_down color-red"><use xlink:href="/its-client/img/sprite.svg#navigate_down"></use></svg>
                                </div>
                                <div class="product-filter__block-repeat" @if(\FacetFilter::has('category')) style="display: block" @endif>
                                    @foreach($categories as $category)
                                    <div class="product-filter__block checkbox-group">
                                        <label>
                                            <input class="checkbox facet-filter" type="checkbox" name="checkbox" @if(\FacetFilter::has('category', $category->slug)) checked @endif data-url="{{ \FacetFilter::build('category', $category->slug) }}">
                                            <span class="checkbox-custom"></span>
                                            <span class="label">{{ $category->name }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($facet['attributes']->count())
                            @foreach($facet['attributes'] as $attribute)
                                <div class="product-filter">
                                    <div class="product-filter__name @if(\FacetFilter::has($attribute->slug)) active @endif">{{ $attribute->title }}
                                        <svg class="icon-svg icon-svg-navigate_down color-red"><use xlink:href="/its-client/img/sprite.svg#navigate_down"></use></svg>
                                    </div>
                                    <div class="product-filter__block-repeat" @if(\FacetFilter::has($attribute->slug)) style="display: block" @endif>
                                        @foreach($facet['values']->where('attribute_id', $attribute->id) as $value)
                                            <div class="product-filter__block checkbox-group">
                                                <label>
                                                    <input class="checkbox facet-filter" type="checkbox" name="checkbox" @if(\FacetFilter::has($attribute->slug, $value->slug)) checked @endif  data-url="{{ \FacetFilter::build($attribute->slug, $value->slug) }}">
                                                    <span class="checkbox-custom"></span>
                                                    <span class="label">{{ $value->value }}{!! $value->suffix !!}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @endforeach
                        @endif
                    </div>
                    @if(FacetFilter::issetFilter())
                    <a class="btn-gen" href="{{ \FacetFilter::reset() }}">{{ trans('site.Сбросить') }}</a>
                    @endif
                </div>
            </div>
            <div class="product-right">
                <div class="product-right__head">
                    <div class="product-right__head-left">
                        <h1 class="name-big">{{ $category->name }}</h1>
                    </div>
                    <div class="product-right__head-mobile">
                        <button class="btn-gen_inner">
                            <img src="/its-client/img/tune.png" alt="">
                            {{ trans('site.Фильтр') }}
                        </button>
                    </div>
                    <div class="product-right__head-right">
                        <span class="select-filter__name">{{ trans('site.Сортировать') }}:</span>
                        @php
                            $sorts = [
                                '' => ['title' => trans('site.По умолчанию'), 'url' => \Overrides\SortableLink::urlWithoutSort()],
                                'price' => ['title' => trans('site.По цене'), 'url' => \Overrides\SortableLink::url('price')],
                                'name' => ['title' => trans('site.По названию'), 'url' => \Overrides\SortableLink::url('name')],
                                'rating' => ['title' => trans('site.По рейтингу'), 'url' => \Overrides\SortableLink::url('rating')],
                            ];
                        @endphp
                        <div class="dropdown" id="dropdown">
                            <a class="btn dropdown-toggle" data-target="#navbarDropdown" href="#" role="button" data-toggle="collapse" data-target="#navbarDropdown" aria-label="Toggle navigation" aria-controls="navbarDropdown"  aria-haspopup="true" aria-expanded="false">
                                {{ $sorts[request('sort')]['title'] ?? trans('site.По умолчанию') }}
                            </a>
                            <div class="dropdown-menu" id="navbarDropdown" arole="menu" aria-labelledby="navbarDropdown">
                                @foreach($sorts as $column => $item)
                                <a class="dropdown-item" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                <div class="product-right__content show-more-content-container">
                    @include('front.products.inc.grid-products', ['products' => $products])
                </div>


                <div class="product-right__navigate">
                    @if($products->nextPageUrl())
                    <div class="product-right__navigate-button">
                        <button class="btn-gen show-more-btn"
                                data-next-page-url="{{ $products->nextPageUrl() }}"
                                data-content-container=".show-more-content-container"
                        >{{ trans('site.Показать больше') }}</button>
                    </div>
                    @endif

                    <div class="product-right__navigate-pagination pagination-links">
                        {!! $products->links() !!}
                    </div>
                </div>
                @if($category->description)
                <div class="product-right__bottom">
                    <div class="products__info">
                        <p>{!! $category->description !!}</p>
                        <button class="products__info-btn">
                            <span>{{ trans('site.Показать полностью') }}</span>
                            <span>{{ trans('site.Скрыть') }}</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('select.js-sortable-action').on('change', function () {
            window.location.href = $(this).val()
        })

        $('.facet-filter').on('click', function () {
            window.location.href = $(this).data('url')
        })

        $(document).on('click', '.js-button-color', function (e) {
            $('#modal-change-color input[name="product_id"]').val($(this).data('product-id'))
            $('#modal-change-color input[name="product-group-id"]').val($(this).data('product-group'))
            $('#modal-change-color input[name="group-wrapper-id"]').val($(this).data('group-wrapper'))
        })

        $(document).on('click', '.js-add-to-cart', function (e) {
            e.preventDefault();

            var ele = $(this),
                colorId = ele.parents('.wrapper-to-options').find('.js-color-info').attr('data-color-id'),
                productId = ele.attr('data-product-id'),
                quantity = ele.parents('.wrapper-to-options').find('#quantity-prod').val(),
                htmlContainer = ele.attr('data-html-container')

            $.ajax({
                url: '{{ route('shopping-cart.add-to-cart') }}',
                method: "post",
                data: {
                    colorId: colorId,
                    productId: productId,
                    quantity: quantity
                },
                success: function (result) {
                    // обновление нужного контейнера
                    console.log(result)
                    console.log('Ajax Succes')
                    if (result && result.html && htmlContainer) {
                        $(htmlContainer).html(result.html)
                    }
                },
                error: function(result) {
                    console.log('Error Ajax!')
                },
                complete: function (result) {
                }
            });
        })

        $(document).on('click', '.js-product-choice', function (e) {
            e.preventDefault();
            var ele = $(this),
                htmlContainer = ele.attr('data-html-container'),
                colorBlock = ele.parents('.wrapper-to-options').find('.item__info-color').html(),
                groupId = ele.parents('.wrapper-to-options').find('.item__info-color').attr('data-group-class')

            $.ajax({
                url: '{{ route('product.update-product-group') }}',
                method: "post",
                data: {
                    id: ele.attr('data-product-id'),
                },
                success: function (result) {
                    // обновление нужного контейнера
                    if (result && result.html && htmlContainer) {
                        $(htmlContainer).html(result.html)
                    }
                },
                error: function(result) {
                    console.log('Error Ajax!')
                },
                complete: function (result) {
                    if (colorBlock)
                    {
                        $('body').find(`div.${groupId}`).html(colorBlock);
                        $('body').find(`div.${groupId}`).addClass('active');

                        var priceElement = $(`div${htmlContainer}`).find('.js-product-price');
                        var markup = parseFloat($(`div.${groupId}`).find('.color-name').attr('data-color-markup'));

                        let price = priceElement.attr('data-price');
                        let basicPrice = priceElement.attr('data-basic-price');

                        let priceFormat = parseInt(price.replace(/\D+/g,""));
                        let priceBasicFormat = parseInt(basicPrice.replace(/\D+/g,""));

                        let basicPriceFormatNew = priceBasicFormat;
                        let priceFormatNew = priceBasicFormat;

                        if (markup > 0)
                        {
                            priceFormatNew = (priceBasicFormat + (priceBasicFormat * markup))*$('#quantity-prod').val();
                            basicPriceFormatNew = priceBasicFormat + (priceBasicFormat * markup)
                        }

                        if (markup === 0)
                        {
                            priceFormatNew = priceBasicFormat *$('#quantity-prod').val();
                            basicPriceFormatNew = priceBasicFormat
                        }

                        priceFormatNew = priceFormatNew.toFixed()
                        basicPriceFormatNew = basicPriceFormatNew.toFixed()

                        let replacePrice = price.replace(priceFormat,priceFormatNew)
                        let replaceBasicPrice = basicPrice.replace(priceBasicFormat,basicPriceFormatNew)

                        priceElement.attr('data-price',replacePrice)
                        priceElement.attr('data-current-price',replaceBasicPrice)

                        priceElement.text(replacePrice)
                    }
                }

            });
        })

        $(document).on('click', '.js-color-input', function (e) {
            e.preventDefault();

            let ele = $(this),
                groupId = ele.parents('.modal-content').find('input[name="product-group-id"]').val(),
                colorId = ele.attr('id'),
                productId = ele.parents('.modal-content').find('input[name="product_id"]').val()
                groupWrapper = ele.parents('.modal-content').find('input[name="group-wrapper-id"]').val(),
                markup = parseFloat(ele.attr('data-price'));

            $.ajax({
                url: '{{ route('product.product-color') }}',
                method: "post",
                data: {
                    colorId: colorId,
                    productId: productId,
                },
                success: function (data) {
                    $('#modal-change-color').modal('hide')
                    $('body').find(`div.${groupId}`).addClass('active');
                    var html =
                        `<div style="background-color: #${data['color']['value']}" class="color-block"></div>
                        <div data-color-markup="${data['color']['markup']}" data-color-id="${data['color']['id']}" class="color-name js-color-info">${data['color']['name']}</div>
                        <button class="color-delete js-color-delete">×</button>`

                    $('body').find(`div.${groupId}`).html(html);
                },
                error: function(result) {
                    console.log('Error Ajax!')
                },
                complete: function (result) {
                    var priceElement = $('body').find(`div.${groupWrapper}`).find('.js-product-price');

                    let price = priceElement.attr('data-price');
                    let basicPrice = priceElement.attr('data-basic-price');

                    let priceFormat = parseInt(price.replace(/\D+/g,""));
                    let priceBasicFormat = parseInt(basicPrice.replace(/\D+/g,""));

                    let basicPriceFormatNew = priceBasicFormat;
                    let priceFormatNew = priceBasicFormat;

                    if (markup > 0)
                    {
                        priceFormatNew = (priceBasicFormat + (priceBasicFormat * markup))*$('#quantity-prod').val();
                        basicPriceFormatNew = priceBasicFormat + (priceBasicFormat * markup)
                    }

                    if (markup === 0)
                    {
                        priceFormatNew = priceBasicFormat *$('#quantity-prod').val();
                        basicPriceFormatNew = priceBasicFormat
                    }

                    priceFormatNew = priceFormatNew.toFixed()
                    basicPriceFormatNew = basicPriceFormatNew.toFixed()

                    let replacePrice = price.replace(priceFormat,priceFormatNew)
                    let replaceBasicPrice = basicPrice.replace(priceBasicFormat,basicPriceFormatNew)

                    priceElement.attr('data-price',replacePrice)
                    priceElement.attr('data-current-price',replaceBasicPrice)

                    priceElement.text(replacePrice)
                },
            });
        })

    </script>
@endpush