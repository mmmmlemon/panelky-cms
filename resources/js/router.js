import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomePage from './components/HomePage.vue';
import About from './components/About.vue';

const routes = [
    {   //home page
        path:'/',
        component: HomePage,
    },
    {
        //about
        path: '/about',
        component: About,
    },
];

export default new VueRouter({ mode: 'history', routes: routes });