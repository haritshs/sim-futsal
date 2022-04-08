
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
//const { default: Axios } = require('axios');
//const { data } = require('jquery');
//const { default: Echo } = require('laravel-echo');


window.Vue = require('vue');
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('notification', require('./components/Notification.vue'));

const app = new Vue({
    el: '#app',
    data: {
        jabatans: '',
        //bookings: '',
    },
    // created(){
    //     if(window.Laravel.adminId){
    //         axios.get('/admin').then(response => {
    //             this.bookings = response.data;
    //             console.log(response.data)
    //         });

    //         Echo.private('App.Admin'+ window.Laravel.adminId).notification((response) =>{
    //             data = {"data":response};
    //             this.bookings.push(data);
    //             console.log(response);
    //         })
    //     }
    // }
    created(){
        if(window.Laravel.adminId){
            axios.post('create/notification/jabatan/notification').then(response => {
                this.jabatans = response.data;
                console.log(response.data)
            });

            Echo.private('App.Admin'+ window.Laravel.adminId).notification((response) =>{
                data = {"data":response};
                this.jabatans.push(data);
                console.log(response);
            })
        }
    }
});
