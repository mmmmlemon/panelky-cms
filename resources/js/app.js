/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import router from './router';
import draggable from 'vuedraggable';
import store from './store';
Vue.component('draggable', draggable);

//иморты плагинов
//isMobile
import { isMobile } from 'mobile-device-detect';
Vue.prototype.$isMobile = isMobile;
//vue2-touch-events
import Vue2TouchEvents from 'vue2-touch-events'
Vue.use(Vue2TouchEvents, {swipeTolerance: 100,});


//иморты компонентов
//./
import HeaderCard from './components/HomePage/HeaderCard.vue';
Vue.component('HeaderCard', HeaderCard);

import ProjectCard from './components/HomePage/ProjectCard.vue';
Vue.component('ProjectCard', ProjectCard);

import FooterCard from './components/HomePage/FooterCard.vue';
Vue.component('FooterCard', FooterCard);

import OtherProjectsCard from './components/HomePage/OtherProjectsCard.vue';
Vue.component('OtherProjectsCard', OtherProjectsCard);


//Admin
import PreviewOwner from './components/Admin/Misc/PreviewOwner.vue';
Vue.component('PreviewOwner', PreviewOwner);

import ListOfProjects from './components/Admin/Misc/ListOfProjects.vue';
Vue.component('ListOfProjects', ListOfProjects);

import ProjectListItem from './components/Admin/Misc/ProjectListItem.vue';
Vue.component('ProjectListItem', ProjectListItem);

import PreviewProject from './components/Admin/Misc/PreviewProject.vue';
Vue.component('PreviewProject', PreviewProject);

import DeleteModal from './components/Admin/Misc/DeleteModal.vue';
Vue.component('DeleteModal', DeleteModal);


//Misc
import Error from './components/Misc/Error.vue';
Vue.component('Error', Error);

//Navigation 
import Nav from './components/Navigation/Nav.vue';
Vue.component('Nav', Nav);

import NavButton from './components/Navigation/NavButton';
Vue.component('NavButton', NavButton);

import NavScroll from './components/Navigation/NavScroll';
Vue.component('NavScroll', NavScroll);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router,
});
