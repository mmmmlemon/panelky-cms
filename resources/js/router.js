import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import About from './components/About.vue';

import AppAdmin from './components/AppAdmin.vue';
import AdminControlPanel from './components/AdminControlPanel.vue';

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
                component: AdminControlPanel,
            }
        ]
    }
];

export default new VueRouter({ mode: 'history', routes: routes });