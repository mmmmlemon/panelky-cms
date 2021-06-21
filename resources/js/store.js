import Vuex from 'vuex';
import Vue from 'vue';
import { over } from 'lodash';
import axios from 'axios';

Vue.use(Vuex);

//глобальные стейты
const GlobalStates = {
    state: {
        //стиль бокового меню
        navMenuStyle: {'right':'-500px', 'opacity':'0'},
        //информация о владельце сайта
        siteOwnerInfo: -1,
        //полный список проектов для главной страницы
        fullProjectList: -1,
        //ссылки
        links: -1,
        //email
        email: -1,
        //animatedBackground
        animatedBackground: -1,
        //aboutSiteText
        aboutSiteText: -1,
    },

    mutations: {
        //установить стейт
        setState(state, payload){
            state[payload.state] = payload.value;
        }
    },

    actions: {
        //setNavMenuStyle
        //изменить стили бокового меню (чтобы оно показалось или скрылось)
        setNavMenuStyle(context, values){
            context.commit('setState', {state:'navMenuStyle', value: values});
        },

        //getSiteOwnerInfo
        //получить информацию о владельце сайта
        getSiteOwnerInfo(context){
            axios.get('/api/getSiteOwnerInfo').then(response => {
                if(response.data !== false)
                { context.commit('setState', {state: 'siteOwnerInfo', value: response.data}); }
                else
                { context.commit('setState', {state: 'siteOwnerInfo', value: false}); }
            })
        },

        //getFullProjectList
        //получить полный список проектов для главной страницы
        getFullProjectList(context){
            axios.get('/api/getFullProjectList').then(response => {
                if(response.data !== false)
                { context.commit('setState', {state: 'fullProjectList', value: response.data}); }
                else
                { context.commit('setState', {state: 'fullProjectList', value: false}); }
            });
        },

        //getLinks
        //получить ссылки
        getLinks(context){
            axios.get('/api/getLinks').then(response => {
                if(response.data !== false)
                { context.commit('setState', { state: 'links', value: response.data}); }
                else
                { context.commit('setState', { state: 'links', value: false}); }
            });
        },

        //getEmail
        //получить email
        getEmail(context){
            axios.get('/api/getEmail').then(response => {
                var splitString = response.data.email.split(""); 
                var reverseArray = splitString.reverse(); 
                var email = reverseArray.join(""); 
                if(response.data !== false)
                { context.commit('setState', { state: 'email', value: {email: email, emailVisible: false}}); }
                else
                { context.commit('setState', { state: 'email', value: false}); }
            });
        },


        //getAnimatedBackground
        getAnimatedBackground(context){
            axios.get('/api/getBgColors').then(response => {
                if(response.data !== false)
                {   
                    let bg_first_color = response.data.bg_first_color;
                    let bg_second_color =response.data.bg_second_color;
                    let style = {
                        background: `linear-gradient(to right top, ${bg_first_color}, ${bg_second_color})`,
                        backgroundSize: '100%',
                        backgroundRepeat: 'no-repeat',
                        backgroundAttachment: 'fixed',
                    };
                    context.commit('setState', { state: 'animatedBackground', value: style}); 
                }
                else
                { context.commit('setState', { state: 'animatedBackground', value: false}); }
            })
        },

        //getAboutSiteText
        getAboutSiteText(context){
            axios.get('/api/getAboutSiteText').then(response => {
                if(response.data !== false){
                    context.commit('setState', { state: 'aboutSiteText', value: response.data});
                }
                else
                { context.commit('setState', { state: 'aboutSiteText', value: false}) }
            })
        }
    }
}

const AdminStates = {
    state: {
        //текущая открытая вкладка на панели администратора
        currentTab: -1,
        //список проектов для HomeProjects.vue
        projectsList: -1,
        //slug текущего выбранного проекта в HomeProjects.vue
        currentProjectSlug: -1, 
        //текущий выбранный проект (HomeProject.vue, EditProject.vue)
        currentProject: -1,
        //плейсхолдеры для картинок в проекте (AddNewProject.vue)
        stockImages: -1,
        //список всех проектов (AllProjects.vue)
        allProjects: -1,
        //инф-ция для модального окна удаления проеткта
        deleteModalInfo: -1,
        //ошибки для AppAdmin
        errors: -1,
    },

    mutations: {
        //установить стейт
        setState(state, payload){
            state[payload.state] = payload.value;
        }
    },

    getters: {
        currentProject: state => {
            return state.currentProject;
        },
    },

    actions: {
        //setCurrentTab
        //установить текущую вкладку (Админка)
        setCurrentTab(context, value){
            context.commit('setState', {state: 'currentTab', value});
        },

        //getProjectsList
        //получить список проектов из БД (Админка)
        getProjectsList(context){
            axios.get('/api/getProjectsList').then(response => {
                if(response.data !== false)
                { context.commit('setState', {state: 'projectsList', value: response.data}); }
                else
                { context.commit('setState', {state: 'projectsList', value: false}); }
            });
        },

        //setCurrentProjectSlug
        //установить текукщий выбранный проект в списке проектов (Админка)
        setCurrentProjectSlug(context, value){            
            context.commit('setState', {state: 'currentProjectSlug', value});
        },

        //setFirstProjectSlug
        //уставновить первый slug проекта в currentProjectSlug
        setFirstProjectSlug(context, state){
            axios.get('/api/getFirstProjectSlug').then(response => {
                if(response.data !== false)
                {
                    axios.get(`/api/getProject/${response.data}/mini`).then(response => {
                        if(response.data !== false)
                        { context.commit('setState', { state: 'currentProject', value: response.data}) }
                        else
                        { context.commit('setState', { state: 'currentProject', value: false}) }
                    });
                }
                else
                { 
                    { context.commit('setState', { state: 'currentProject', value: false}) }
                }
            });
        },

        //getProject
        //получить проект для превью проекта
        getProject(context, payload)
        {
            axios.get(`/api/getProject/${payload.value}/${payload.type}`).then(response => {
                if(response.data !== false)
                { context.commit('setState', { state: 'currentProject', value: response.data}) }
                else
                { context.commit('setState', { state: 'currentProject', value: false}) }
            });
        },

        //getStockImages
        //получить стоковые иконку и скриншот
        getStockImages(context){
            axios.get(`/api/getStockImages`).then(response => {
                { context.commit('setState', {state: 'stockImages', value: response.data})};
            });
        },

        //getAllProjects
        //получить все проекты
        getAllProjects(context){
            axios.get('/api/getAllProjects').then(response => {
                { context.commit('setState', {state: 'allProjects', value: response.data})};
            })
        },

        //setDeleteModalInfo
        //записать инф-цию об удалении в модальное окно удаления проекта
        setDeleteModalInfo(context, payload){
            context.commit('setState', {state: 'deleteModalInfo', value: payload});
        },

        //setErrors
        //записать ошибки
        setErrors(context, errors){
            context.commit('setState', {state: 'errors', value: errors});
        },
    }
}

export default new Vuex.Store({
    modules: {
        GlobalStates: GlobalStates,
        AdminStates: AdminStates,
    }
  });