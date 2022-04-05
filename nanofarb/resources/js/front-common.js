// Формы и их модалки при разных статусов ответа сервера.
var modalsAfterActions = {


    "form-cooperation": {
        "success":"#form-modal-cooperation-success"
    },
    "form-default": {
        "success":"#modal-default-thank"
    },


    "cart-form": {
        "success":"#modal-feedback-end"
    },
    "request-form-create": {
        "success":"#modal-feedback-end"
    },
    "account-update": {
        "success":"#modal-default-thank"
    },
    "buy-one-click": {
        "success":"#modal-feedback-end"
    },
    "form-add-review": {
        "success":"#modal-thank"
    },
    "register-client": {
        "success":"#register-modal-success"
    },
    "reset-password-form": {
        "success":"#modal-reset-password-info"
    }
}

toastr.options = {
    "closeButton": true,
    //"progressBar": true,
    //"showDuration": "300",
    "hideDuration": "500",
    "timeOut": "3500",
    "extendedTimeOut": "500",
    "positionClass": "toast-bottom-right",
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// <div class="loader" style="display: none;"></div>
$(document)
    .ajaxStart(function () {
        $('.loader').show()
    })
    .ajaxStop(function () {
        setTimeout(function () {
            $('.loader').hide()
        }, 100)
    });

/**
 * Example: <a class="js-seo-click" href="#" data-seo-action="click_cart_button" data-seo-label="236">
 */
$('.js-seo-click').on('click', function (e) {
    var $this = $(this),
        seoAction = $this.data("seo-action"),
        seoLabel = $this.data('seo-label')

    seoActionHandle(seoAction, seoLabel)
})

/**
 * Открыть модалку data-target.
 * Заполнить поля модалки если есть data-fields={}
 */
$('.js-toggle-modal').on('click', function () {
    var $this = $(this),
        $modalId = $this.data('target'),
        $modal = $($modalId),
        dataFields = $this.data('fields'),
        $destination = $this.data('destination');
    if ($modalId) {
        $modal.modal()

        if (dataFields) {
            for (var field in dataFields) {
                $modal.find('[name="' + field + '"]').val(dataFields[field]);
            }
        }

        if ($this.data('seo-label')) {
            $modal.find('form').data('seo-label', $this.data('seo-label'))
        }

        // TODO: Deprecated
        if ($destination) {
            $modal.find("input[name='destination']").val($destination)
        }
    }
})

/**
 * Upd: 18.04.2019
 * AJAX submit form and show validation errors.
 */
$(document).on('submit', 'form.js-ajax-form-submit', function (e) {
    e.preventDefault()
    var $form = $(this),
        thisId = $form.data('id'),
        formData = $form.serialize(),
        method = $form.attr('method') || 'POST',
        url = $form.attr('action'),
        htmlContainer = $form.data('html-container'),                       // Container for update result-content after response
        errorClass = $form.data('error-class') || 'error',                  // Class for input container (<div class="form-group"></div>)
        errorClassInfoMsg = $form.data('error-class-msg') || 'text-error',  // Class for validation message tag <p>
        seoAction = $form.data("seo-action"),                               // GoogleTagManager
        seoLabel = $form.data('seo-label')                                  // GoogleTagManager

    var $cartForm = $(document).find('form#cart-form')
    if ($cartForm.length) {
        $cartForm.find('button[type="submit"]').attr('disabled', true)
        // $cartForm.find('button[type="submit"]').next('.btn-ajax-loader').show()
        $cartForm.find('button[type="submit"]').css('display', 'none')
    }
    $.ajax({
        url: url,
        method: method,
        dataType: 'json',
        data: formData,
        async:false,
        cache: false,
        beforeSend: function() {
            // Remove all p.error & .error in this form
            $form.find('p.' + errorClassInfoMsg).remove()
            $form.find('.' + errorClass).removeClass(errorClass)
        },
        success: function(result) {
            console.log('Success Ajax!')

            if (seoAction) {
                seoActionHandle(seoAction, seoLabel)
            }

            // обновление нужного контейнера
            if (result && result.html && htmlContainer) {
                $(htmlContainer).html(result.html)
            }

            // команда действие от сервера
            if (result && result.action) {
                switch (result.action) {
                    case 'redirect': // запись данных в флеш куки и редирект
                        putFlashMessages(result.message, result.status, thisId)
                        window.location = result.destination
                        return
                    case 'reset': // очистка формы
                        $form[0].reset()
                        break
                }
            }

            // показать сообщение
            if (result && result.message) {
                var statusMsg = result.status || 'success'
                toastr[statusMsg](result.message) // https://github.com/CodeSeven/toastr
            }

            // показать модалку для формы в зависимости от статуса с сервера
            if (result && result.status && thisId) {
                var $modalId = $(modalsAfterActions[thisId][result.status]);
                if ($modalId.length) {
                    $('.modal').modal('hide')   // скрыть все другии модалки
                    $modalId.modal()            // https://getbootstrap.com/docs/4.0/components/modal/
                }
            }

            reInitJQueryMask()
        },
        error: function(result) {
            console.log('Error Ajax!')
            var response = result.responseJSON;

            /**
             * You can set next options:
             * data-validator-options='{"relatedSelectors":["[name=last_name]","[name=phone]"], "disableMsg":1}'
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
            if ($cartForm.length) {
                setTimeout(function () {
                    $cartForm.find('button[type="submit"]').attr('disabled', false)
                    // $cartForm.find('button[type="submit"]').next('.btn-ajax-loader').hide()
                    $cartForm.find('button[type="submit"]').css('display', 'block')
                }, 2000)
            }
        }
    })
})

/**
 * Upd: 18.04.2019
 * AJAX submit data (logout, cart, favorites, etc...).
 */
$(document).on('click', '.js-action-click', function (e) {
    e.preventDefault()
    var $this = $(this),
        thisId = $this.data('id'),
        url = $this.data('url'),
        method = $this.data('method') || 'POST',
        htmlContainer = $this.data('html-container'),
        formData = $this.data('data') || {},
        confirmMsg = $this.data('confirm'),
        seoAction = $this.data("seo-action"),
        seoLabel = $this.data('seo-label')

    if (confirmMsg !== undefined && !confirm(confirmMsg)) {
        return
    }

    $.ajax({
        url: url,
        method: method,
        dataType: 'json',
        data: formData,
        async:false,
        cache: false,
        success: function (result) {

            if (seoAction) {
                seoActionHandle(seoAction, seoLabel)
            }

            // обновление нужного контейнера
            if (result && result.html && htmlContainer) {
                $(htmlContainer).html(result.html)
            }

            // команда действие от сервера
            if (result && result.action) {
                switch (result.action) {
                    case 'redirect': // запись данных в флеш куки и редирект
                        putFlashMessages(result.message, result.status, thisId)
                        window.location = result.destination
                        return
                }
            }

            // показать сообщение
            if (result && result.message) {
                var statusMsg = result.status || 'success'
                toastr[statusMsg](result.message) // https://github.com/CodeSeven/toastr
            }

            // показать модалку для формы в зависимости от статуса с сервера
            if (result && result.status && thisId) {
                var $modalId = $(modalsAfterActions[thisId][result.status]);
                if ($modalId.length) {
                    $('.modal').modal('hide')   // скрыть все другии модалки
                    $modalId.modal()            // https://getbootstrap.com/docs/4.0/components/modal/
                }
            }

            // Customize:
            $this.toggleClass('active');

            updateInfoHeaderProd()

            $('.select-basket').select2({
                dropdownCssClass: 'select-basket-dropdown',
            })
            if ($this.hasClass('buy-action')) {
                $(document).trigger('addcart', 1)
                //$('#cart-in-header').show()
                $('.js-cart-in-header').html(result.html)
                $('.js-cart-in-header').show()
            }
            if ($this.hasClass('favorite-action')) {
                $('button.header__interface-item.like').addClass('active')
            }
        },
        error: function(result) {
            console.log('Error Ajax!')
            var response = result.responseJSON;

            if (response && response.errors !== undefined) {
                $.each(response.errors, function (key, value) {
                    // Show error messages.
                    value.forEach(function (item, /*i, value*/) {
                        console.log(key, item)
                        toastr.error(item)
                    })
                })
            }
        }
    })
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

showFlashMessages()

function showFlashMessages() {
    if (issetCookie('flashMsg')) {
        toastr.success(pullCookie('flashMsg'))
    }
    if (issetCookie('flashModalId')) {
        $modalId = pullCookie('flashModalId');
        $($modalId).length ? $($modalId).modal() : null // Bootstrap modal
    }
    pullCookie('flashStatus')
}

function putFlashMessages(message, status, modalsAfterActionsKey) {
    var cookieOptions = {"path":"/;","expires":5} //5 sec.
    message ? setCookie('flashMsg', message, cookieOptions) : null
    status ? setCookie('flashStatus', status, cookieOptions) : null
    modalsAfterActionsKey && status ? setCookie('flashModalId', modalsAfterActions[modalsAfterActionsKey][status], cookieOptions) : null
}

/**
 * Заполнить поля "Редактирование адреса"
 * при выборы адреса в селекте
 * на странице аккаунта.
 */
$('.select-personal').on('change', function () {
    $.each($(this).find(':selected').data('contact'), (function (i, val) {
        $('.contact-fields input[name="contact['+i+']"]').val(val)
    }))
})

$('a[href="#subscribe-news-modal"]').on('click', function (e) {
    e.preventDefault()
    $('#subscribe-news-modal').modal()
})

/**
 * Выбор даты в селектах.
 */
$('.date-selects select').on('change', function () {
    var $this = $(this),
        $dateBlock = $this.closest('.date-selects'),
        year = $dateBlock.find('[name="date_year"]').val(),
        month = $dateBlock.find('[name="date_day"]').val(),
        day = $dateBlock.find('[name="date_month"]').val()
    if (year && month && day) {
        $dateBlock.find('input.date-res').val(year + '-' + month + '-' + day)
    }
})

/**
 * Обновить количекстов лайков, товаров в хедере.
 */
function updateInfoHeaderProd() {
    var prodAmountInFavorite = $('#product-favorite .number').text(),
        prodAmountInCart = $('#product-cart .number').text()

    $('.amount-favorites').text(prodAmountInFavorite)
    $('.amount-cart-products').text(prodAmountInCart)
}
updateInfoHeaderProd()

/**
 * Заполнение полей модалок (например для редактирования сущности).
 */
$('.js-fill-fields-modal').on('click', function() {
    var $this = $(this),
        url = $this.data('url'),
        dataFields = $this.data('fields'),
        modal = $($this.data('target'))

    if (url) {
        modal.find('form').attr('action', url)
    }
    for (var field in dataFields) {
        modal.find('[name="' + field + '"]').val(dataFields[field]);
    }

    // Custom
    if ($this.data('seo-label')) {
        modal.find('form').data('seo-label', $this.data('seo-label'))
    }

    modal.modal() // Bootstrap!
})

/**
 * Upd: 13.02.2019
 * AJAX pagination "Show more" (on scroll)
 */
var timerScrollPar
$(document).on('scroll', function() {
    clearTimeout(timerScrollPar)

    var $this = $(this),
        $scrollContainer = $this.find('.show-more-scroll-container'),       // body
        $contentContainer = $($scrollContainer.data('content-container')),  // content
        $loaderBlock = $($scrollContainer.data('show-more-loader')),         // loader
        url = $scrollContainer.data('next-page-url')                       // first page next (page=2)

    if (url && $contentContainer) {
        timerScrollPar = setTimeout(function () {

            if ($this.scrollTop() + 550 >= $contentContainer.height()/* - $this.height() - 1000*/) {
                $loaderBlock.length ? $loaderBlock.show() : null

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        //$loaderBlock.length ? $loaderBlock.show() : null
                    },
                    success: function (result) {
                        $contentContainer.append(result.html)
                        // console.log(result.nextPageUrl)
                        if (result.nextPageUrl) {
                            $scrollContainer.data('next-page-url', result.nextPageUrl)
                        } else {
                            $scrollContainer.data('next-page-url', null)
                        }
                    },
                    complete: function () {
                        $loaderBlock.length ? $loaderBlock.hide() : null
                    }
                })
            }
        }, 200)
    }
})

/**
 * by fomvasss
 * Upd: 08.02.2019
 * AJAX pagination "Show more" (on click)
 */
$(document).on('click', '.show-more-btn', function(e) {
    e.preventDefault()
    var $this = $(this),
        url = $this.data('next-page-url'),
        $contentContainer = $($this.data('content-container'))
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        beforeSend: function () {
            // loader show
        },
        success: function(result) {
            $contentContainer.append(result.html)
            console.log(result.nextPageUrl)
            if (result.nextPageUrl) {
                $this.data('next-page-url', result.nextPageUrl)
            } else {
                $this.remove()
            }

            // custom
            if (result.paginationLinks) {
                $('.pagination-links').html(result.paginationLinks)
            }
        },
        complete: function () {
            // loader hide
        }
    })
})


// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

// устанавливает cookie с именем name и значением value
// options - объект с свойствами cookie (expires, path, domain, secure)
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

// удаляет cookie с именем name
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}

// проверяет наличие cookie
function issetCookie(name) {
    if (getCookie(name) === undefined) {
        return false;
    }

    return true;
}

// получает и удаляет cookie с именем name - flash-cookie
function pullCookie(name) {
    var result = getCookie(name);
    deleteCookie(name)

    return result;
}