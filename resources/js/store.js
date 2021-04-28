  
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
                if(response.data != false)
                { context.commit('setState', {state: 'siteOwnerInfo', value: response.data}); }
                else
                { context.commit('setState', {state: 'siteOwnerInfo', value: false}); }
            })
        }
    }
}

const AdminStates = {
    state: {
        //текущая открытая вкладка на панели администратора
        currentTab: -1,
        projectsList: [],
    },

    mutations: {
        //установить стейт
        setState(state, payload){
            state[payload.state] = payload.value;
        }
    },

    actions: {
        //setCurrentTab
        //установить текущую вкладку
        setCurrentTab(context, value){
            context.commit('setState', {state: 'currentTab', value});
        },

        //getProjectsList
        //получить список проектов из БД
        getProjectsList(context){
            axios.get('/api/getProjectsList').then(response => {
                if(response.data != false)
                { context.commit('setState', {state: 'projectsList', value: response.data}); }
                else
                { context.commit('setState', {state: 'siteOwnerInfo', value: false}); }
            })
        }


    },
}

export default new Vuex.Store({
    modules: {
        GlobalStates: GlobalStates,
        AdminStates: AdminStates,
    }
  });