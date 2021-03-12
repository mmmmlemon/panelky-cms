  
import Vuex from 'vuex';
import Vue from 'vue';
import { over } from 'lodash';

Vue.use(Vuex);


//глобальные стейты
const GlobalStates = {
    state: {

    },

    mutations: {
        //установить стейт
        setState(state, payload){
            state[payload.state] = payload.value;
        }
    },

    actions: {

    }
}


export default new Vuex.Store({
    modules: {
        GlobalStates: GlobalStates,
    }
  });