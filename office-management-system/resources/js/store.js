import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
import createPersistedState from 'vuex-persistedstate'

const store = new Vuex.Store({
    state: {
        sections: [],
        config: {},
        left_open: true,
        right_open: false,
        preloader: true,
    },
    mutations: {
        left_menu(state, option) {
            if (option == "open") {
                state.left_open = true
            } else if (option == "close") {
                state.left_open = false
            } else if (option == "toggle") {
                state.left_open = !state.left_open
            }
            if (state.left_open) {
                document.getElementsByTagName("body")[0].classList.remove("left-hidden")
            } else {
                document.getElementsByTagName("body")[0].classList.add("left-hidden")
            }
        },
        rightside_bar(state, option) {
            if (option == "open") {
                state.right_open = true
            } else if (option == "close") {
                state.right_open = false
            } else if (option == "toggle") {
                state.right_open = !state.right_open
            }
            if (state.right_open) {
                document.getElementsByTagName("body")[0].classList.add("sidebar-right-opened")
            } else {
                document.getElementsByTagName("body")[0].classList.remove("sidebar-right-opened")
            }
        },
        routeChange(state, loader) {
            if (loader == "start") {
                state.preloader = true
            } else if (loader == "end") {
                state.preloader = false
            }
        },
        setAuthUserDetail (state, auth) {
            for (let key of Object.keys(auth)) {
                state.auth[key] = auth[key] !== null ? auth[key] : '';
            }
            if ('avatar' in auth)
                state.auth.avatar = auth.avatar !== null ? auth.avatar : '';
            state.auth.status = true;
            state.auth.roles = auth.roles;
            state.auth.permissions = auth.permissions;
            state.auth.last_activity = moment().format();
        },
        resetAuthUserDetail (state) {
            for (let key of Object.keys(state.auth)) {
                state.auth[key] = '';
            }
            state.auth.status = false;
            state.auth.roles = [];
            state.auth.permissions = [];
            state.auth.last_activity = null;
            Vue.cookie.delete('auth_token');
            axios.defaults.headers.common['Authorization'] = null;
        },
        setConfig (state, config) {
            for (let key of Object.keys(config)) {
                state.config[key] = config[key];
            }
        },
        resetConfig (state) {
            for (let key of Object.keys(state.config)) {
                delete state.config[key];
            }
        },
        resetTwoFactorCode (state) {
            state.auth.two_factor_code = '';
        },
        setLastActivity(state) {
            state.auth.last_activity = moment().format();
        },
        setSections(state, sections){
            state.sections = sections; 
        },
        resetSections(state){
            state.sections = []
        }
    },
    actions: {
        setAuthUserDetail ({ commit }, auth) {
            commit('setAuthUserDetail',auth);
        },
        resetAuthUserDetail ({commit}){
            commit('resetAuthUserDetail');
        },
        setConfig ({ commit }, data) {
            commit('setConfig',data);
        },
        resetConfig({ commit }) {
            commit('resetConfig');
        },
        resetTwoFactorCode({ commit }) {
            commit('resetTwoFactorCode');
        },
        setLastActivity({ commit }) {
            commit('setLastActivity');
        },
        setSections ({ commit }, data) {
            commit('setSections',data);
        },
        resetSections({ commit }) {
            commit('resetSections');
        }
    },
    getters: {
        
        getConfig: (state) => (name, default_val=null) => {
            return state.config[name] ?? default_val;
        },
        hasPermission: (state) => (name) => {
            return (state.auth.permissions.indexOf(name) > -1) ? true : false;
        }
    },
    plugins: [
        createPersistedState({
            key: 'Ecom',
        })
    ]
});

export default store;
