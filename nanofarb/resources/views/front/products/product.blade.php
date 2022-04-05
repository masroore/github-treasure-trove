@extends('front.layouts.app')

@php
    MetaTag::setEntity($product)->setDefault(['title' => $product->name]);
    $localebound = $product->getLocaleboundStr();
@endphp

@section('content')
    <div class="card-product">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('product.show', $product) !!}
        </div>
        <div class="card-product__wrapper">
            <div class="card-product__head wrapper-to-options">
                @include('front.products.inc.product-content', ['product' => $product])
            </div>
            <div class="card-product__content">
                <div class="card-product__content-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab-pane-1" role="tab" aria-controls="tab-pane-1" aria-selected="true">{{ trans('site.Описание продукта') }} </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2" data-toggle="tab" href="#tab-pane-2" role="tab" aria-controls="tab-pane-2" aria-selected="false">{{ trans('site.Характеристики') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-3" data-toggle="tab" href="#tab-pane-3" role="tab" aria-controls="tab-pane-3" aria-selected="false">{{ trans('site.Инструкция') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-4" data-toggle="tab" href="#tab-pane-4" role="tab" aria-controls="tab-pane-4" aria-selected="false">{{ trans('site.Отзывы') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link__consumption" id="tab-5" data-toggle="tab" href="#tab-pane-5" role="tab" aria-controls="tab-pane-5" aria-selected="false">{{ trans('site.Расход') }}</a>
                        </li>
                        @if($product->availability)
                        <li class="nav-item">
                            <span class="item-stock">
                                <img src="/its-client/img/ok.png" alt="">
                                {{ trans('site.Есть в наличии') }}
                            </span>
                        </li>
                        @else
                        <li class="nav-item">
                            <span class="item-stock">
                                {{ trans('site.Нет в наличии') }}
                            </span>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-pane-1" role="tabpanel" aria-labelledby="tab-1">
                            <div class="tab-first">
                                <div class="card-product__tab-head typography">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2" role="tabpanel" aria-labelledby="tab-2">
                            <div class="tab-first">
                                <div class="card-product__tab-head typography">
                                    {!! $product->data['applying'] ?? '' !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3" role="tabpanel" aria-labelledby="tab-3">
                            <div class="tab-first">
                                <div class="card-product__tab-head typography">
                                    {!! $product->data['instruction'] ?? '' !!}
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="tab-pane-4" role="tabpanel" aria-labelledby="tab-4">
                            <div class="card-product__tab-head">
                                <div class="home__feedback">
                                    <div class="home__feedback-info">
                                        <div class="swiper-container swiper-container-feedback">
                                            <div class="swiper-wrapper">
                                                @foreach($reviews->chunk(2) as $chunk)
                                                <div class="swiper-slide">
                                                    @php
                                                        $b = $loop->iteration % 2;
                                                    @endphp
                                                    @foreach($chunk as $review)
                                                    <div class="home__feedback-block @if($b = !$b) gray @endif">
                                                        <div class="home__feedback-head">
                                                            <img src="/its-client/img/feedback.png" alt="">
                                                            <a href="#" class="home__feedback-head-name">{{ $review->getUserName() }}
                                                                <div class="rating">
                                                                    @for($i = 1; $i < 6; $i++)
                                                                        @if($review->rating >= $i)
                                                                            <img src="/its-client/img/Star.png" alt="star-{{$i}}">
                                                                        @else
                                                                            <img src="/its-client/img/Star-off.png" alt="star-{{$i}}">
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                            </a>
                                                            <svg class="icon-svg icon-svg-fullscreen color-red"><use xlink:href="/its-client/img/sprite.svg#fullscreen"></use></svg>
                                                        </div>
                                                        <div class="home__feedback-content">
                                                            {{ $review->body }}
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @auth
                                        <div class="home__feedback-bottom">
                                            <button class="feedback-name js-add-review" data-product-id="{{$product->id}}">
                                                <svg class="icon-svg icon-svg-edit color-red"><use xlink:href="/its-client/img/sprite.svg#edit"></use></svg>
                                                {{ trans('site.Оставить отзыв') }}
                                            </button>
                                        </div>
                                    @else
                                        <div class="home__feedback-bottom">
                                            <button class="feedback-name js-toggle-modal" {{--data-toggle="modal"--}} data-destination="{{ \Request::fullUrl() }}" data-target="#modal-login">
                                                <svg class="icon-svg icon-svg-edit color-red"><use xlink:href="/its-client/img/sprite.svg#edit"></use></svg>
                                                {{ trans('site.Войти и оставить отзыв') }}
                                            </button>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-5" role="tabpanel" aria-labelledby="tab5">
                            <div class="tab-first">
                                <form action="#" method="POST" class="" >
                                    <div class="calc-form typography">
                                        <input type="hidden" id="consumption" value="{{$product->consumption}}">
                                        <h3>Калькулятор расхода</h3>
                                        <div class="form-group">
                                            <label> Площадь покраски (кв.м):</label>
                                            <input type="text" class="input" name="square">
                                        </div>
                                        <div class="form-group">
                                            <label> Количество слоёв:</label>
                                            <select name="count-layer" id="count-layer">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label> Примерный расход краски:</label>
                                            <span class="calc-result"><strong>0</strong> kg.</span>
                                        </div>
                                        <div class="form-button">
                                            <button type="button" class="btn-gen">{{ trans('site.Посчитать') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @includeWhen(isset($recommends), 'front.products.inc.recommendation-slider', ['recommends' => $recommends])

                    @if(MetaTag::tag('seo_text'))
                    <div class="products__info">
                        {!! MetaTag::tag('seo_text') !!}
                        <button class="products__info-btn">
                            <span>{{ trans('site.Показать полностью') }}</span>
                            <span>{{ trans('site.Скрыть') }}</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.card-product__head .js-button-color', function (e) {
            $('#modal-change-color input[name="product_id"]').val($(this).data('product-id'))
            $('#modal-change-color input[name="product-group-id"]').val($(this).data('product-group'))
            $('#modal-change-color input[name="group-wrapper-id"]').val($(this).data('group-wrapper'))
            $('#modal-change-color input[name="quantity"]').val($(this).parents('.wrapper-to-options').find('#quantity-prod').val())
            $('#modal-change-color').addClass('modal-product');
        })

        $(document).on('click', '.card-product__head .js-product-choice', function (e) {
            e.preventDefault();
            var ele = $(this),
                htmlContainer = ele.attr('data-html-container'),
                productId = ele.attr('data-product-id'),
                colorBlock = ele.parents('.wrapper-to-options').find('.color-block-wrapper').html(),
                colorId = ele.parents('.wrapper-to-options').find('.color-name').data('color-id')

            $.ajax({
                url: '{{ route('product.update-product') }}',
                method: "post",
                data: {
                    id: productId,
                    colorId: colorId,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                        $('.color-block-wrapper').html(colorBlock);
                        $('.color-block-wrapper').addClass('active');

                        var priceElement = $(`div${htmlContainer}`).find('.js-product-price');
                        var markup = parseFloat($(`div${htmlContainer}`).find('.color-name').attr('data-color-markup'));

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

        $(document).on('click', '.card-product__head .js-change-count', function (e) {
            e.preventDefault()
            var currentVal = parseInt($(this).parents('.wrapper-to-options').find('#quantity-prod').val()),
                // currentVal = parseInt($('#quantity-prod').val()),
                add = parseInt($(this).data('add')),
                qua = currentVal + add
            if (qua > 0) {
                $(this).parents('.wrapper-to-options').find('#quantity-prod').val(qua)
                var priceElement = $(this).parents('.wrapper-to-options').find('.js-product-price');
                let price = priceElement.attr('data-current-price');
                let priceFormat = parseInt(price.replace(/\D+/g,""));
                let priceFormatNew = priceFormat* $(this).parents('.wrapper-to-options').find('#quantity-prod').val();

                let replacePrice = price.replace(priceFormat,priceFormatNew)
                priceElement.attr('data-price',replacePrice)
                priceElement.text(replacePrice)
            }
                var ele = $(this),
                    quantity =  parseInt($(this).parents('.wrapper-to-options').find('#quantity-prod').val()),
                    url =  ele.attr('data-url'),
                    htmlContainer = ele.attr('data-html-container'),
                    productId = ele.attr('data-product-id'),
                    colorBlock = ele.parents('.wrapper-to-options').find('.color-block-wrapper').html(),
                    colorId = ele.parents('.wrapper-to-options').find('.color-name').data('color-id')

                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        id: productId,
                        quantity: quantity,
                        colorId: colorId,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (result) {
                        // обновление нужного контейнера
                        if (result && result.html && htmlContainer) {
                            $(htmlContainer).html(result.html)
                            console.log('Success Ajax!')
                        }
                    },
                    error: function(result) {
                        console.log('Error Ajax!')
                    },
                    complete: function (result) {
                        $('.card-product__head-right').find('#quantity-prod').val(quantity)
                        if (colorBlock)
                        {
                            $('.card-product__head-right').find('.color-block-wrapper').html(colorBlock);
                        }
                    }
                });
        })
        //удаления цвета
        $(document).on('click', '.card-product__head .js-button-color-delete', function (e) {
            e.preventDefault();
            var ele = $(this),
                htmlContainer = $('.card-product__head'),
                quantity =  $('#quantity-prod').val(),
                productId = ele.parents('.color-block').find('.js-button-color').attr('data-product-id'),
                colorBlock = ele.parents('.wrapper-to-options').find('.color-block-wrapper').html(),
                colorId = ele.parents('.wrapper-to-options').find('.color-name').data('color-id')

            $.ajax({
                url: '{{ route('product.color-clear') }}',
                method: "post",
                data: {
                    id: productId,
                    quantity: quantity,
                    colorId: colorId,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                    $('#quantity-prod').val(quantity)
                }
            });
        })

        $(document).on('click', '.modal-product .js-color-input', function (e) {
            e.preventDefault();
            let ele = $(this),
                quantity = parseInt($(this).parents('.modal-content').find('input[name="quantity"]').val()),
                colorId = ele.attr('id'),
                productId = ele.parents('.modal-content').find('input[name="product_id"]').val()
                // groupWrapper = ele.parents('.modal-content').find('input[name="group-wrapper-id"]').val(),
                markup = parseFloat(ele.attr('data-price'));

            $.ajax({
                url: '{{ route('product.product-color') }}',
                method: "post",
                data: {
                    colorId: colorId,
                    quantity: quantity,
                    productId: productId,
                },
                success: function (data) {
                    $('#modal-change-color').modal('hide')
                    var html =
                        `<div style="background-color: #${data['color']['value']}" class="color-block"></div>
                        <div data-color-markup="${data['color']['markup']}" data-color-id="${data['color']['id']}" class="color-name js-color-info">${data['color']['name']}</div>
                        <button class="color-delete js-color-delete js-button-color-delete">×</button>`

                    $('.color-block__choice').html(html);
                    $('.price-convert').html(`(${data['priceWithColor']['priceColorCurrent']})`);
                    $('.price-old').html(`(${data['priceWithColor']['priceColorOld']})`);
                    $('#modal-change-color').removeClass('modal-product');
                },
                error: function(result) {
                    console.log('Error Ajax!')
                },
                complete: function (result) {
                    var priceElement = $('.card-product__head-right').find('.js-product-price');

                    let price = priceElement.attr('data-price');
                    let basicPrice = priceElement.attr('data-basic-price');

                    let priceFormat = parseInt(price.replace(/\D+/g,""));
                    let priceBasicFormat = parseInt(basicPrice.replace(/\D+/g,""));

                    let basicPriceFormatNew = priceBasicFormat;
                    let priceFormatNew = priceBasicFormat;

                    if (markup > 0)
                    {
                        priceFormatNew = (priceBasicFormat + (priceBasicFormat * markup))*quantity;
                        basicPriceFormatNew = priceBasicFormat + (priceBasicFormat * markup)
                    }

                    if (markup === 0)
                    {
                        priceFormatNew = priceBasicFormat *quantity;
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

        $(document).on('click', '.card-product__head .js-add-to-cart', function (e) {
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
                    // console.log(result)
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

        $(document).on('click', '.recomendation-slider .js-button-color', function (e) {
            $('#modal-change-color input[name="product_id"]').val($(this).data('product-id'))
            $('#modal-change-color input[name="product-group-id"]').val($(this).data('product-group'))
            $('#modal-change-color input[name="group-wrapper-id"]').val($(this).data('group-wrapper'))
            $('#modal-change-color').addClass('modal-recomend');
        })

        $(document).on('click', '.recomendation-slider .js-add-to-cart', function (e) {
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

        $(document).on('click', '.recomendation-slider .js-product-choice', function (e) {
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

        $(document).on('click', '.modal-recomend .js-color-input', function (e) {
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
                    $('#modal-change-color').removeClass('modal-recomend');
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

        $('.js-btn-bue-one-click').on('click', function(e) {
            e.preventDefault()
            if ($(this).data('product-id')) {
                $('#modal-bue-one-click input[name="product_id"]').val($(this).data('product-id'))
                $('#modal-bue-one-click input[name="quantity"]').val($('#quantity-prod').val())
                $('#modal-bue-one-click').modal()
            }
        })
        $('.js-add-review').on('click', function(e) {
            e.preventDefault()
            if ($(this).data('product-id')) {
                $('#modal-add-reviews input[name="product_id"]').val($(this).data('product-id'))
                $('#modal-add-reviews').modal()
            }
        })

    </script>
@endpush