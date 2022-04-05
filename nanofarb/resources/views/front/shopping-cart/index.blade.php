@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Корзина')]);
    $localeboundAlternativeSegmentUrl = 'cart';
@endphp

@section('content')
{{--    @dd(session('cart'))--}}
    <div class="basket">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('home', trans('site.Корзина')) !!}
        </div>
        <div class="basket__wrapper">
            <div class="basket__head">
                <h1 class="name-big">{{ trans('site.Ваша корзина') }}</h1>
            </div>
            <div class="basket-content" id="cart-page-content">
                @include('front.shopping-cart.inc.cart-form', [
                    'cart' => $cart,
                    'purchase' => $purchase,
                    'delivery' => $delivery,
                ])
            </div>
            @includeWhen(isset($recommends), 'front.products.inc.recommendation-slider', ['recommends' => $recommends])
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        //------------------------- Увеличить/уменьшить к-ство товара в корзине -------------------//
        $(document).on('click', '.js-set-amount', function () {
            var $this = $(this),
                $addition = $this.data('addition'),
                $input = $this.siblings('.amount-product'),
                $quantity = $this.parent().find('.product-id-color')

            // console.log($quantity)
            $input.val(parseInt($input.val()) + parseInt($addition))
            $quantity.attr('data-quantity',parseInt($quantity.attr('data-quantity')) + parseInt($addition))
        })


        //-------------------------------- Удалить товар с корзины ----------------------------------//
        $(document).on('click', '.js-ajax-cart-product-remove', function (e) {
            e.preventDefault();
            var $this = $(this),
                $form = $this.closest('form'),//$('#cart-form'),
                formData = $form.serializeArray(),
                color = $this.parents('.basket-content__left-info').find('.product-id-color').attr('data-color-value'),
                quantity = 0,
                method = $form.attr('method') || 'POST',
                url = $this.attr('data-url')

            formData.push({ name: 'color', value: color })
            formData.push({ name: 'quantity', value: quantity })
            console.log(formData)
            $.ajax({
                url: url,
                method: method,
                dataType: 'json',
                data: formData,
                success: function (response) {
                    console.log(this.success)
                    location.reload();
                }
                });
        })

        //------------------------- Выбор метода доставки ---------------------//
        $(document).on('click', '.js-select-delivery-method', function (e) {
            e.preventDefault()
            $('#reload-cart-page').click()
        })
        //------------------------- Выбор подметода доставки ---------------------//
        $(document).on('click', '.js-select-delivery-tariff', function (e) {
            e.preventDefault()
            $('#reload-cart-page').click()
        })

        /**
         * TODO: унификовать!
         * Отправка/обновление формы данных корзины.
         */
        $(document).on('click', '.js-ajax-cart-form-submit', function (e) {
            e.preventDefault()

            var $this = $(this),
                $form = $this.closest('form'),//$('#cart-form'),
                formData = $form.serializeArray(),
                color = $this.parent().find('.product-id-color').attr('data-color-value'),
                quantity = $this.parent().find('.product-id-color').attr('data-quantity'),
                method = $this.data('method') || $form.attr('method') || 'POST',
                url = $this.data('url') || $form.attr('action'),
                htmlContainer = $this.data('html-container') || $form.data('html-container'),
                errorClass = $form.data('error-class') || 'error',
                errorClassInfoMsg = $form.data('error-class-msg') || 'text-error',
                seoAction = $this.data("seo-action"),
                seoLabel = $this.data('seo-label')
                formData.push({ name: 'color', value: color })
                formData.push({ name: 'quantity', value: quantity })

                // quantity = $this.siblings('.product-id-color')
            // console.log(formData)
            // console.log(color)
            if (this.name) {
                formData.push({ name: this.name, value: this.value });
            }
            // console.log(formData)
            $.ajax({
                url: url,
                method: method,
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    // Remove all p.error & .error on form
                    $form.find('p.' + errorClassInfoMsg).remove()
                    $form.find('.' + errorClass).removeClass(errorClass)
                },
                success: function(result) {
                    console.log('Success Ajax!')

                    if (seoAction) {
                        seoActionHandle(seoAction, seoLabel)
                    }

                    if (result && result.html && htmlContainer) {
                        $(htmlContainer).html(result.html)
                    }

                    if (result && result.message) {
                        console.log(result.message)
                        toastr.success(result.message)
                    }

                    if (result && result.action) {
                        switch (result.action) {
                            case 'redirect':
                                window.location = result.destination
                                break
                            case 'reset':
                                $form[0].reset()
                                break
                        }
                    }

                    // Custom Hard-code!!!
                    if (result && result.htmlHeaderCart != undefined) {
                        $('#cart-in-header').html(result.htmlHeaderCart)
                    }
                    //updateInfoHeaderProd()
                    var prodAmountInFavorite = $('#product-favorite .number').text(),
                        prodAmountInCart = $('#product-cart .number').text()
                    $('.amount-favorites').text(prodAmountInFavorite)
                    $('.amount-cart-products').text(prodAmountInCart)

                    $('#delivery').select2({
                        minimumResultsForSearch: -1,
                        placeholder: ' '
                    })

                    //initCartSelect2()

                    reInitJQueryMask()
                    // location.reload();
                },
                error: function(result) {
                    console.log('Error Ajax!')
                    var response = result.responseJSON;

                    /**
                     * You can set next options:
                     * data-validator-options='{"related_selectors":["[name=last_name]","[name=phone]"], "disable_msg":1}'
                     */
                    if (response && response.errors !== undefined) {
                        $.each(response.errors, function (key, value) {

                            // Replace backend key for frontend.
                            // Example: article.terms.category => article[terms][category]
                            var fieldName = key.replace(/\.|$/g, '][').replace(/]/, '').replace(/\[$/,''),

                                // Field that has an error (by name, except type="hidden").
                                //$fieldWithError = $form.first('[name="' + fieldName + '"]:not([type="hidden"])'),
                                $fieldWithError = $form.find('[name="' + fieldName + '"]:not([type="hidden"])'),

                                // TODO  check is JSON (https://codeblogmoney.com/validate-json-string-using-javascript/)
                                $fieldValidOptions = $fieldWithError.data('validator-options')

                            // Added error class for element with the desired "fieldName".
                            $fieldWithError.closest('.form-group').addClass(errorClass);

                            // Add class error to related tags.
                            if ($fieldValidOptions && $fieldValidOptions.relatedSelectors) {
                                $.each($fieldValidOptions.relatedSelectors, function (i, item) {
                                    $form.find(item).closest('.form-group').addClass(errorClass);
                                })
                            }

                            // Show error messages.
                            value.forEach(function (item, /*i, value*/) {
                                console.log(key, item)
                                // replace "first_name" => "first name"
                                var key_ = key.replace("_", " "),
                                    // replace/delete in msg field name!
                                    errorText = ('<p class='+errorClassInfoMsg+'>'+item+'</p>').replace(key_, "").replace(key, "")

                                if ($fieldValidOptions && $fieldValidOptions.disableMsg) {
                                } else {
                                    $fieldWithError.closest('.form-group').append(errorText)
                                }
                            });

                        });
                    }
                },
                complete: function () {
                    //...
                }
            })
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

        function reInitJQueryMask() {
            $('input[data-mask]').each(function() {
                var input = $(this),
                    options = {};

                if (input.attr('data-mask-reverse') === 'true') {
                    options['reverse'] = true;
                }

                if (input.attr('data-mask-maxlength') === 'false') {
                    options['maxlength'] = false;
                }

                input.mask(input.attr('data-mask'), options);
            });
        }
    </script>
@endpush