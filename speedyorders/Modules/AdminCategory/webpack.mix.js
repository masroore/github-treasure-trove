const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/admincategory.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/admincategory.css');

if (mix.inProduction()) {
    mix.version();
}