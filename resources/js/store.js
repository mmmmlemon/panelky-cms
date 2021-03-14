  
import Vuex from 'vuex';
import Vue from 'vue';
import { over } from 'lodash';

Vue.use(Vuex);


//глобальные стейты
const GlobalStates = {
    state: {
        //стиль бокового меню
        navMenuStyle: {'right':'-500px', 'opacity':'0'},
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
    }
}


export default new Vuex.Store({
    modules: {
        GlobalStates: GlobalStates,
    }
  });