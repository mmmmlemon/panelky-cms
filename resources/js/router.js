import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import About from './components/About.vue';
import RequestProject from './components/RequestProject.vue';

import AppAdmin from './components/AppAdmin.vue';
import SiteOwnerSettings from './components/Admin/SiteOwnerSettings.vue';
import SiteOwnerInfo from './components/Admin/SiteOwner/SiteOwnerInfo.vue';
import SiteOwnerAbout from './components/Admin/SiteOwner/SiteOwnerAbout.vue';
import Projects from './components/Admin/Projects.vue';
import Links from './components/Admin/Links.vue';
import Settings from './components/Admin/Settings.vue';
import EditProject from './components/Admin/Projects/EditProject.vue';
import HomeProjects from './components/Admin/Projects/HomeProjects.vue';
import AllProjects from './components/Admin/Projects/AllProjects.vue';
import AddNewProject from './components/Admin/Projects/AddNewProject.vue';
import EditLinks from './components/Admin/Links/EditLinks.vue';
import EditContacts from './components/Admin/Links/EditContacts';
import BasicSettings from './components/Admin/Settings/BasicSettings.vue';
import HomeSettings from './components/Admin/Settings/HomeSettings.vue';
import DesignSettings from './components/Admin/Settings/DesignSettings.vue';
import CookiesSettings from './components/Admin/Settings/CookiesSettings.vue';

import test from './components/test.vue';

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
            },
            {
                path: '/requestProject',
                component: RequestProject
            }
        ]
    },
    {
        path:'/test',
        component: test,
    },
    //admin side
    {
        path:'/admin',
        component: AppAdmin,
        children: [
            {
                //admin home
                path: '/admin/siteOwner',
                component: SiteOwnerSettings,
                children: [
                    {
                        path: '/admin/siteOwner',
                        component: SiteOwnerInfo,
                    },
                    {
                        path: '/admin/siteOwner/about',
                        component: SiteOwnerAbout,
                    }
                ]
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
                children: [
                    {
                        //edit links
                        path: '/admin/links',
                        component: EditLinks,
                    },
                    {
                        //edit contacts
                        path: '/admin/links/contacts',
                        component: EditContacts,
                    }
                ]
            },
            {
                //settings
                path: '/admin',
                component: Settings,
                children: [
                    {
                        path: '/admin',
                        component: BasicSettings,
                    },
                    {
                        path: '/admin/settings/home',
                        component: HomeSettings,
                    },
                    {
                        path: '/admin/settings/design',
                        component: DesignSettings,
                    },
                    {
                        path: '/admin/settings/cookies',
                        component: CookiesSettings,
                    }
                ]
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