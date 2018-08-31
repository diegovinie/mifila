
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('ControlPanel', require('./components/ControlPanel.vue'));
// Vue.component('Charts', require('./components/Charts'));

// import Echo from './ws'
require('./ws')
// Echo.channel('ticket')
//     .listen('UpdateGlobals', (e) => {
//         console.log(e.globals)
//     })

const app = new Vue({
    store,
    el: '#app'
});
