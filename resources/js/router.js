import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import About from './components/About.vue';

import AppAdmin from './components/AppAdmin.vue';
import SiteOwnerInfo from './components/Admin/SiteOwnerInfo.vue';

import PageNotFound from './components/Misc/PageNotFound.vue';


const routes = [
    //user side
    {   
        path:'/',
        component: App,

        children: [
            {   
                //home page
                path: '/',
                component: HomePage
            },
            {
                path: '/about',
                component: About
            }
        ]
    },
    //admin side
    {
        path:'/admin',
        component: AppAdmin,
        children: [
            {
                //admin home
                path: '/admin',
                component: SiteOwnerInfo,

            },
        ]
    },
    // 404
    {
        path: '/404',
        component: PageNotFound
    },
    {
        path: '*',
        redirect: '/404'
    }
];

export default new VueRouter({ mode: 'history', routes: routes });