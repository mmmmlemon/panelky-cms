import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import About from './components/About.vue';

import AppAdmin from './components/AppAdmin.vue';
import SiteOwnerInfo from './components/Admin/SiteOwnerInfo.vue';
import Projects from './components/Admin/Projects.vue';
import Links from './components/Admin/Links.vue';
import EditProject from './components/Admin/Projects/EditProject.vue';
import HomeProjects from './components/Admin/Projects/HomeProjects.vue';
import AllProjects from './components/Admin/Projects/AllProjects.vue';
import AddNewProject from './components/Admin/Projects/AddNewProject.vue';

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
            {
                //projects
                path: '/admin/projects',
                component: Projects,
                children: [
                    {
                        //homeProjects
                        path:'/admin/projects',
                        component: HomeProjects,
                    },
                    {
                        //allProjects
                        path:'/admin/projects/all',
                        component: AllProjects,
                    },
                    {
                        //add new project
                        path: '/admin/projects/add',
                        component: AddNewProject,
                    }
                ]
            },
            {
                //links
                path: '/admin/links',
                component: Links,
            },
            {
                //edit project
                path:'/admin/edit/:slug',
                component: EditProject,
            }
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