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
        }
    }
}

const AdminStates = {
    state: {
        //текущая открытая вкладка на панели администратора
        currentTab: -1,
        projectsList: -1,
        currentProjectSlug: -1, 
        currentProject: -1,
        stockImages: -1,
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
        stockImages: state => {
            return state.stockImages;
        }
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

                axios.get(`/api/getProject/${response.data}/mini`).then(response => {
                    if(response.data !== false)
                    { context.commit('setState', { state: 'currentProject', value: response.data}) }
                    else
                    { context.commit('setState', { state: 'currentProject', value: false}) }
                });

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
        }
    }
}

export default new Vuex.Store({
    modules: {
        GlobalStates: GlobalStates,
        AdminStates: AdminStates,
    }
  });