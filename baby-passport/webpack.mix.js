const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


//Copy img
mix.copyDirectory('resources/img', 'public/img');

//Fonts
mix.copy('resources/fonts/Roboto-Regular.ttf', 'public/fonts/Roboto-Regular.ttf');
mix.copy('resources/fonts/Roboto-Bold.ttf', 'public/fonts/Roboto-Bold.ttf');
mix.copy('resources/fonts/Campton-Light.ttf', 'public/fonts/Campton-Light.ttf');
mix.copy('resources/fonts/Campton-SemiBold.otf', 'public/fonts/Campton-SemiBold.otf');


//Web Scripts
mix.js("resources/js/web/app.js", "public/js/web/web.js").sass(
    "resources/sass/web/app.scss",
    "public/css/web/web.css"
)
    .options({
        processCssUrls: false
    });

mix.js('resources/js/web/index.js', 'public/js/web/index.js');
mix.js('resources/js/web/about-us.js', 'public/js/web/about-us.js');
mix.js('resources/js/web/atention-center.js', 'public/js/web/atention-center.js');
mix.js('resources/js/web/subscription.js', 'public/js/web/subscription.js');
mix.js('resources/js/web/register.js', 'public/js/web/register.js');
mix.js('resources/js/web/city.js', 'public/js/web/city.js');
mix.js('resources/js/web/im.mom.js', 'public/js/web/im.mom.js');
mix.js('resources/js/web/hospital.profile.js', 'public/js/web/hospital.profile.js');


//Mom Profile Scripts
mix.js("resources/js/mom_panel/app.js", "public/js/mom_panel/mom_panel.js").sass(
    "resources/sass/mom_panel/app.scss",
    "public/css/mom_panel/mom_panel.css"
)
    .options({
        processCssUrls: false
    });


mix.js('resources/js/mom_panel/mom.profile.js', 'public/js/mom_panel/mom.profile.js');
mix.js('resources/js/mom_panel/openpay.errors.js', 'public/js/mom_panel/openpay.errors.js');
mix.js('resources/js/mom_panel/payment.js', 'public/js/mom_panel/payment.js');

mix.sass('resources/sass/reports/payment.scss', 'public/css/reports/payment.css');


//Admin Panel Scripts
mix.js("resources/js/panel/app.js", "public/js/panel/panel.js").sass(
    "resources/sass/panel/app.scss",
    "public/css/panel/panel.css"
)
    .options({
        processCssUrls: false
    });

mix.js('resources/js/panel/user.js', 'public/js/panel/user.js');
mix.js('resources/js/panel/tag.js', 'public/js/panel/tag.js');
mix.js('resources/js/panel/category.js', 'public/js/panel/category.js');
mix.js('resources/js/panel/city.js', 'public/js/panel/city.js');
mix.js('resources/js/panel/ratings.js', 'public/js/panel/ratings.js');
mix.js('resources/js/panel/blog.js', 'public/js/panel/blog.js');
mix.js('resources/js/panel/ads.js', 'public/js/panel/ads.js');
mix.js(['resources/js/panel/row_product.js', 'resources/js/panel/product.js'], 'public/js/panel/product.js');


if (mix.inProduction()) {
    mix.version();
}
