/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from './components/App.vue';
import store from "../js/store";

import "../css/nucleo-icons.css";
import "../css/nucleo-svg.css";
import ArgonDashboard from "../argon-dashboard";

/* websanova */
import {createAuth}          from '@websanova/vue-auth';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';



/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const router = createRouter({
    history: createWebHistory(import.meta.env.APP_URL), 
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        // ...
        return savedPosition || new Promise((resolve, reject) => {
            setTimeout(()=> resolve({top:0, behavior:'smooth'}),300);
        });
    }
})

// const app = createApp({
//     App,
//     data() {
//         return {
//             user: window.__user__,
//         }
//     },
// }).use(router);
const app = createApp(App, {user: window.__user__,}).use(store).use(router).use(ArgonDashboard);
app.use(auth);
// app.component('example-component', ExampleComponent);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
var auth = createAuth({
    plugins: {
        http: axios,
        router: router,
    },
    drivers: {
        http: driverHttpAxios,
        auth: driverAuthBearer,
        router: driverRouterVueRouter,
        // oauth2: {
        //     google: driverOAuth2Google,
        //     facebook: driverOAuth2Facebook,
        // }
    },
    options: {
        rolesKey: 'type',
        notFoundRedirect: {name: 'home'},
        loginData: {url: "api/auth/login", method: 'POST', redirect: '/', fetchUser: true},
        fetchData: {url: "api/auth/user", method: 'GET', enabled: true},
        registerData: {url: "api/auth/register", method: 'POST', redirect: '/login'},
        logoutData: {url: "api/auth/logout", method: 'POST', redirect: '/', makeRequest: true},
        refreshData: {url: "api/auth/refresh", method: 'POST', enabled: true, interval: 30}
    }
});

app.mount('#app');



