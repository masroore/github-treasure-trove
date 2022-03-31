const mix = require('laravel-mix');

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

mix
    /* BACK */
    /**/
    /* CSS */
    /*.sass('resources/sass/back/main.scss', 'public/css/core.css')
    .sass('resources/sass/back/codebase/themes/flat.scss', 'public/css/core.theme.css')*/
    /*
    .sass('resources/sass/back/codebase/themes/black.scss', 'public/css/themes/')
    .sass('resources/sass/back/codebase/themes/corporate.scss', 'public/css/themes/')
    .sass('resources/sass/back/codebase/themes/earth.scss', 'public/css/themes/')
    .sass('resources/sass/back/codebase/themes/elegance.scss', 'public/css/themes/')
    .sass('resources/sass/back/codebase/themes/flat.scss', 'public/css/themes/')
    .sass('resources/sass/back/codebase/themes/pulse.scss', 'public/css/themes/')
    */

    /* JS */
    /*.js('resources/js/back/laravel/app.js', 'public/js/lara.js')
    .js('resources/js/back/codebase/app.js', 'public/js/core.js')*/

    /* Product Edit Dependencies */
    /* */
    /*.styles([
        'resources/js/back/plugins/sweetalert2/sweetalert2.min.css',
    ], 'public/css/sweetalert2.css')
    .scripts([
        'resources/js/back/plugins/sweetalert2/sweetalert2.min.js',
    ], 'public/js/sweetalert2.js')*/
    /*.styles([
        'resources/js/back/plugins/jquery-auto-complete/jquery.auto-complete.min.css',
    ], 'public/css/jquery.auto-complete.css')
    .scripts([
        'resources/js/back/plugins/jquery-auto-complete/jquery.auto-complete.min.js',
    ], 'public/js/jquery.auto-complete.js')*/
    /*.styles([
        'resources/js/back/plugins/summernote/summernote-bs4.css',
        'resources/js/back/plugins/select2/css/select2.min.css',
        'resources/js/back/plugins/dropzonejs/dist/dropzone.css',
        'resources/js/back/plugins/jquery-tags-input/jquery.tagsinput.min.css'
    ], 'public/css/core.edit.css')
    .scripts([
        'resources/js/back/plugins/summernote/summernote-bs4.min.js',
        'resources/js/back/plugins/select2/js/select2.full.min.js',
        'resources/js/back/plugins/dropzonejs/dropzone.min.js',
        'resources/js/back/plugins/jquery-ui/jquery-ui.min.js',
        'resources/js/back/plugins/jquery-ui/jquery.ui.touch-punch.min.js',
        'resources/js/back/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js',
        'resources/js/back/plugins/jquery-tags-input/jquery.tagsinput.min.js'
    ], 'public/js/core.edit.js')*/
    /*.scripts([
        'resources/js/back/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js',
    ], 'public/js/bootstrap.wizard.js')*/

    /*.scripts([
        'resources/js/back/plugins/jquery-slimscroll/jquery.slimscroll.js',
    ], 'public/js/jquery.slimscroll.js')*/

    /*.scripts([
        'resources/js/back/plugins/cropperjs/cropper.min.js',
    ], 'public/js/cropper.min.js')
    .styles([
        'resources/js/back/plugins/cropperjs/cropper.css',
    ], 'public/css/cropper.min.css')*/

    /* Vue Components */
    //.js('resources/js/back/ag-slider-images.js', 'public/js/ag-slider-images.js')
    //.js('resources/js/back/ag-autocomplete.js', 'public/js/components/ag-autocomplete.js')
    //.js('resources/js/back/ag-order-products.js', 'public/js/components/ag-order-products.js')
    //.js('resources/js/back/ag-autosuggestion.js', 'public/js/components/ag-autosuggestion.js')
    //.js('resources/js/back/ag-bar-chart.js', 'public/js/components/ag-bar-chart.js')
    //.js('resources/js/back/ag-horizontal-bar-chart.js', 'public/js/components/ag-bar-horizontal-chart.js')
    //.js('resources/js/back/ag-pie-chart.js', 'public/js/components/ag-pie-chart.js')
    //.js('resources/js/back/ag-stats-total.js', 'public/js/components/ag-stats-total.js')
    //.js('resources/js/back/ag-doc-block.js', 'public/js/components/ag-doc-block.js')
    .js('resources/js/back/ag-block.js', 'public/js/components/ag-block.js')





    /* FRONT
    * */
    /* CSS
    * */
    //.sass('resources/front/template/sass/ag_style.scss', 'public/css/front/agfront_style.css')
    /*.styles([
        'resources/front/template/css/bootstrap.css',
        'resources/front/template/style.css',
        'resources/front/template/css/swiper.css',
        'resources/front/template/demos/mrav/mrav.css',
        'resources/front/template/css/dark.css',
        'resources/front/template/css/font-icons.css',
        'resources/front/template/css/animate.css',
        'resources/front/template/css/responsive.css',
    ], 'public/front/css/base.css')*/
    /*.styles([
        'resources/front/css/plugins/slick/slick.css',
        'resources/front/css/plugins/zoomit/zoomit.css',
    ], 'public/css/slick.zoomit.css')*/

    /* JS */
    //
    /*.scripts([
        'resources/front/template/js/jquery.js',
        'resources/front/template/js/plugins.js',
        'resources/front/template/js/functions.js'
    ], 'public/front/js/base.js')*/

    /*.scripts([
        'resources/front/template/js/jquery.js',
    ], 'public/front/js/jquery.js')
    .scripts([
        'resources/front/template/js/plugins.js',
    ], 'public/front/js/plugins.js')
    .scripts([
        'resources/front/template/js/functions.js'
    ], 'public/front/js/functions.js')
    .scripts([
        'public/front/js/jquery.ihavecookies.js'
    ], 'public/front/js/cookies.js')*/




    /* Tools */
    /*.browserSync('http://ag-base.agm')*/
    /*.disableNotifications()*/

    /* Options */
    /*.options({
        processCssUrls: false
    })*/;
