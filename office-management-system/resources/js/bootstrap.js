try {

    window.$ = window.jQuery = require('jquery');
    require('popper.js');
    require('bootstrap');
    require('metismenu')
} catch (e) {}

import Vue from 'vue'
import VueMeta from 'vue-meta'
import store from './store'
import Form from './services/form'
import axios from 'axios'
import helper from './services/helper'
import showError from './components/show-error'
import projectSecitons from './components/project/sections/ProjectSections'
import projectBoardSecitons from './components/project/sections/board/ProjectSections'
import projectFilesSecitons from './components/project/sections/files/ProjectSections'
import projectHeader from './components/project/header/projectHeader'
import taskDetails from './components/project/sections/task/TaskDetails'
import parsley from 'parsleyjs/src/parsley'
import VTooltip from 'v-tooltip'
import VuejsDialog from "vuejs-dialog"
import fileUploadInput from './components/file-upload-input'
import htmlEditor from './components/html-editor'
import VuePictureSwipe from 'vue-picture-swipe';
import projectConversationSecitons from './components/project/sections/conversation/ProjectSections'





window.toastr = require('toastr')
window.moment = require('moment')
window._get = require('lodash/get');
window._eachRight = require('lodash/eachRight');
window._replace = require('lodash/replace');
window._has = require('lodash/has');
window._size = require('lodash/size');


Vue.prototype.trans = (string, args) => {
    let value = _get(window.i18n, string);

    _eachRight(args, (paramVal, paramKey) => {
        value = _replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};
Vue.prototype.$last = function (item, list) {
    return item === list[list.length - 1]
};
Vue.prototype.$first = function (item, list) {
    return item === list[0]
};

window.Vue = Vue;
window.axios = axios;
window.Form = Form;
window.helper = helper;
window.parsley = parsley;

Vue.use(VuejsDialog);
Vue.use(VTooltip);
Vue.use(VueMeta);
Vue.component('file-upload-input',fileUploadInput);
Vue.component('html-editor',htmlEditor);
Vue.component('show-error',showError);
Vue.component('project-sections',projectSecitons);
Vue.component('project-header',projectHeader);
Vue.component('task-details',taskDetails);
Vue.component('project-board-sections',projectBoardSecitons);
Vue.component('project-files-sections',projectFilesSecitons);
Vue.component('project-conversation-sections',projectConversationSecitons);

Vue.component('vue-picture-swipe', VuePictureSwipe);


let baseURL = document.head.querySelector('meta[name="url"]');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.PROJECT_URL= baseURL ? baseURL.content : 'http://project.test';
window.axios.defaults.baseURL = baseURL ? baseURL.content : 'http://project.test';
window.axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

axios.interceptors.response.use(response => {
    return response.data
});

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

