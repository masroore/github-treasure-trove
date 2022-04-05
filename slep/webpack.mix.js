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

//mix.js('resources/js/app.js', 'public/js')
//mix.sass('resources/sass/app.scss', 'public/css');

//**************** CSS ******************** 
//css
//mix.copy('resources/vendors/pace-progress/css/pace.min.css', 'public/css'); 
mix.copy('node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css', 'public/css');
mix.copy('node_modules/ladda/dist/ladda-themeless.min.css', 'public/css'); 
mix.copy('node_modules/codemirror/lib/codemirror.css', 'public/css'); 
mix.copy('resources/sass/vendors/quill/quill.coreui.css', 'public/css');

mix.copy('resources/sass/vendors/bootstrap-daterangepicker/css/daterangepicker.min.css', 'public/css'); 
mix.copy('node_modules/select2/dist/css/select2.min.css', 'public/css'); 
mix.copy('resources/sass/vendors/select2/select2-coreui.css', 'public/css');
mix.copy('resources/sass/vendors/toastr/css/toastr.min.css', 'public/css');
//mix.copy('node_modules/fullcalendar/dist/fullcalendar.min.css', 'public/css'); 
mix.copy('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css', 'public/css'); 
mix.copy('node_modules/cropperjs/dist/cropper.css', 'public/css');
//mix.copy('resources/vendors/@fullcalendar/css/main.css', 'public/css/fullcalendar/css');
mix.copy('node_modules/@fullcalendar/daygrid/main.css', 'public/css/fullcalendar/daygrid');



//main css
mix.sass('resources/sass/style.scss', 'public/css');
//mix.sass('resources/sass/vendors/@fullcalendar/core/main.scss', 'public/css/fullcalendar');

//************** SCRIPTS ****************** 
// general scripts
mix.copy('node_modules/@coreui/utils/dist/coreui-utils.js', 'public/js'); 
mix.copy('node_modules/axios/dist/axios.min.js', 'public/js'); 
//mix.copy('node_modules/pace-progress/pace.min.js', 'public/js');  
mix.copy('node_modules/@coreui/coreui-pro/dist/js/coreui.bundle.min.js', 'public/js'); 
// views scripts
mix.copy('node_modules/@fullcalendar/core/main.js', 'public/js/fullcalendar/core'); 
mix.copy('node_modules/@fullcalendar/daygrid/main.js', 'public/js/fullcalendar/daygrid'); 

mix.copy('node_modules/chart.js/dist/Chart.min.js', 'public/js'); 
mix.copy('node_modules/@coreui/chartjs/dist/js/coreui-chartjs.js', 'public/js'); 
mix.copy('node_modules/ladda/dist/spin.min.js', 'public/js');  
mix.copy('node_modules/ladda/dist/ladda.min.js', 'public/js');  
mix.copy('node_modules/codemirror/lib/codemirror.js', 'public/js');  
mix.copy('node_modules/codemirror/mode/xml/xml.js', 'public/js');  
mix.copy('node_modules/codemirror/mode/markdown/markdown.js', 'public/js');
mix.copy('node_modules/quill/dist/quill.min.js', 'public/js'); 
mix.copy('node_modules/jquery/dist/jquery.slim.min.js', 'public/js'); 
mix.copy('node_modules/jquery.maskedinput/src/jquery.maskedinput.js', 'public/js'); 
mix.copy('node_modules/moment/min/moment.min.js', 'public/js'); 
mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/js'); 
mix.copy('node_modules/bootstrap-daterangepicker/daterangepicker.js', 'public/js'); 
mix.copy('node_modules/jquery-validation/dist/jquery.validate.js', 'public/js'); 
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js');  
mix.copy('node_modules/toastr/toastr.js', 'public/js');  
//mix.copy('node_modules/fullcalendar/dist/fullcalendar.min.js', 'public/js'); 
//mix.copy('node_modules/fullcalendar/dist/gcal.js', 'public/js'); 
mix.copy('node_modules/jquery-ui-dist/jquery-ui.min.js', 'public/js');
mix.copy('node_modules/datatables.net/js/jquery.dataTables.js', 'public/js');  
mix.copy('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js', 'public/js');  
mix.copy('node_modules/cropperjs/dist/cropper.js', 'public/js');

// details scripts
mix.js('resources/js/coreui/main.js', 'public/js');
mix.js('resources/js/coreui/colors.js', 'public/js');
mix.js('resources/js/coreui/charts.js', 'public/js');
mix.js('resources/js/coreui/widgets.js', 'public/js');
mix.js('resources/js/coreui/popovers.js', 'public/js');
mix.js('resources/js/coreui/tooltips.js', 'public/js');
// details scripts v-pro
mix.js('resources/js/coreui/loading-buttons.js', 'public/js');
mix.js('resources/js/coreui/code-editor.js', 'public/js');
mix.js('resources/js/coreui/markdown-editor.js', 'public/js');
mix.js('resources/js/coreui/text-editor.js', 'public/js');
mix.js('resources/js/coreui/advanced-forms.js', 'public/js');
mix.js('resources/js/coreui/validation.js', 'public/js');
mix.js('resources/js/coreui/google-maps.js', 'public/js');
mix.js('resources/js/coreui/toastrs.js', 'public/js');
mix.js('resources/js/coreui/calendar.js', 'public/js');
mix.js('resources/js/coreui/draggable-cards.js', 'public/js');
mix.js('resources/js/coreui/datatables.js', 'public/js');
// details scripts admin-panel
mix.js('resources/js/coreui/menu-create.js', 'public/js');
mix.js('resources/js/coreui/menu-edit.js', 'public/js');
mix.js('resources/js/coreui/media.js', 'public/js');
mix.js('resources/js/coreui/media-cropp.js', 'public/js');

//*************** OTHER ****************** 
//fonts
//mix.copy('node_modules/@fortawesome/fontawesome-free/css/', 'public/css');
mix.copy('node_modules/@coreui/icons/fonts', 'public/fonts');
//mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
//icons
mix.copy('node_modules/@coreui/icons/css/free.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/brand.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/flag.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/svg/flag', 'public/svg/flag');

mix.copy('node_modules/@coreui/icons/sprites/', 'public/icons/sprites');

//mix.copy('node_modules/flag-icon-css/css/flag-icon.min.css', 'public/css');
//flags
//mix.copy('node_modules/flag-icon-css/flags', 'public/flags');
//images
mix.copy('resources/assets', 'public/assets');

