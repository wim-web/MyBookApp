import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    isLogin: false,
    user: {},
    toggleMenu: false,
  },

  mutations: {
    login(state) {
      state.isLogin = true;
    },
    logout(state) {
      state.isLogin = false;
    },
    showMenu(state) {
      state.toggleMenu = true;
    },
    hiddenMenu(state) {
      state.toggleMenu = false;
    }
  },

  actions: {
    async checkIsLogin({ commit }) {
      const response = await Axios.get('/user').catch(err => err.response);
      if (response.status !== 200) return alert('error');

      const userInfo = response.data;
      if (userInfo) {
        commit('login');
      } else {
        commit('logout');
      }
    }
  },
});

export default store;