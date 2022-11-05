/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp } from 'vue';
import { AppRouter } from "./router/AppRouter.js"
import i18n from './vuei18n'
let app = createApp({})
app.component('app-layout', require('./Layouts/App/Index.vue').default);
app.use(AppRouter)
app.use(i18n)
app.mount("#app")
