let mix = require('laravel-mix');

// mix.copyDirectory('./its-client/test/css/', './public/its-client/css/');
// mix.copyDirectory('./its-client/test/js/', './public/its-client/js/');
// mix.copyDirectory('./its-client/test/fonts/', './public/its-client/fonts/');
// mix.copyDirectory('./its-client/test/img/', './public/its-client/img/');

mix.js('resources/js/front-common.js', './public/its-client/js/common.js')

mix.disableNotifications();
