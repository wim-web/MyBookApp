import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        isLogin: false,
        user: {},
    },
    
    getters: {

    },
    
    mutations: {
        login(state) {
            state.isLogin = true;
        },
        logout(state) {
            state.isLogin = false;
        },
    },
    
    actions: {
        async checkIsLogin({ commit }) {
            const response = await Axios.get('/user');
            if (response.data) {
                commit('login');
            } else {
                commit('logout');
            }
        }
    },
});

export default store;