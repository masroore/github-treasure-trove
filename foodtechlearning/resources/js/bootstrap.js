import Alpine from 'alpinejs';
import flatpickr from "flatpickr";
import  'flatpickr/dist/themes/material_green.css'
import Swal from 'sweetalert2'
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';


FilePond.setOptions({
    credits: false,
});
window.FilePond = FilePond;
window.Alpine = Alpine;
window.Swal = Swal;
Alpine.start();
// window.flatpickr = flatpickr;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
