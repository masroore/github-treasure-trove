const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

var plugin = 'resources/plugins/';
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const CompressionPlugin = require("compression-webpack-plugin");



mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss','public/css')
    .vue()
    .combine([
        plugin+ 'slimscroll.js',
        plugin+ 'bootstrap-tagsinput.js',
        plugin+ 'nice-select.js',
        'resources/js/custom.js',
    ],'public/js/plugin.js')
    // .browserSync('project.test')               // this is the alias/virtual host which will be called to load http://localhost:8000
    .webpackConfig({
        // devtool: "cheap-module-source-map",     // "eval-source-map" or "inline-source-map" or "cheap-module-source-map" or "eval"
        plugins: [
            // new BundleAnalyzerPlugin(),      // load this package to see which plugins with its size detail
            new CompressionPlugin({             // very import to compress the assets
                filename: "[path][base].gz",
                algorithm: "gzip",
                test: /\.js$|\.css$|\.html$|\.svg$/,
                threshold: 10240,
                minRatio: 0.8
            }),
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
        ],
        resolve: {
            extensions: ['.js', '.json', '.vue'],
            alias: {
                '@css': path.resolve(__dirname, 'resources', 'css'),
                '@js': path.resolve(__dirname, 'resources', 'js'),
                '@var': path.resolve(__dirname, 'resources', 'var'),
                '@components': path.resolve(__dirname, 'resources', 'js', 'components'),
                '@layouts': path.resolve(__dirname, 'resources', 'js', 'layouts'),
                '@routers': path.resolve(__dirname, 'resources', 'js', 'routers'),
                '@services': path.resolve(__dirname, 'resources', 'js', 'services'),
                '@views': path.resolve(__dirname, 'resources', 'js', 'views'),
                '@widgets': path.resolve(__dirname, 'resources', 'js', 'widgets'),
                '@backend': path.resolve(__dirname, 'resources', 'backend')
            }
        }
    });

if (mix.inProduction()) {                       // In production environtment use versioning
    mix.version();
}

