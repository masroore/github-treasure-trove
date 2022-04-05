
<!-- Scripts application -->
<script src="{{ asset('its-client/js/plugins.js') }}"></script>
<script src="{{ asset('its-client/js/script.js') }}"></script>
<script src="{{ asset('its-client/js/custom.js') }}"></script>

{!! variable('front_code_seo_actions', '') !!}

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('its-client/js/common.js') }}"></script>

@stack('scripts')

{!! variable('front_code_end_body', "
<!-- SEO -->
<script>
    function seoActionHandle(seoAction, seoLabel) {
        console.log(seoAction, seoLabel)
        if (typeof dataLayer != 'undefined' && seoAction) {
            switch (seoAction) {
                case 'click_bue_product_page': //Коли клікнули на кнопку в карточці товару Купить
                    dataLayer.push({'event': 'order_button_click', 'position': 'product_page'});
                    break;
                case 'order_success_cart_page': //Коли заказ успішний при оформленні з корзини
                    dataLayer.push({'event': 'order_success_submited', 'position': 'chekout_page'});
                    break;
                case 'quick_order_button_click': //Коли клікнули на кнопку в карточці товару Быстрый заказ
                    dataLayer.push({'event': 'quick_order_button_click', 'position': 'product_page'});
                    break;
                case 'quick_order_success': //Коли заказ успішний на кнопку в карточці товару Быстрый заказ
                    dataLayer.push({'event': 'quick_success_submited', 'position': 'product_page'});
                    break;
                case 'wholesale_click_footer': //Клик в футере на оптовым клиентам
                    dataLayer.push({'event': 'wholesale_client_link_click', 'position': 'footer'});
                    break;
                case 'corporation_click_footer': //Клик в футере на корпоративным клиентам
                    dataLayer.push({'event': 'business_client_link_click', 'position': 'footer'});
                    break;
                }
        } else {
            console.log('ERROR: Object dataLayer  is undefined')
        }
    }
</script>
") !!}
</body>
</html>