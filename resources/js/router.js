import Vue from 'vue';
import VueRouter from 'vue-router';

import store from './vuex/store';

import Top from './pages/Top';
import Mypage from './pages/Mypage';
import Search from './pages/Search';
import Register from './pages/Register';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Top,
    beforeEnter: (to, from, next) => {
      redirectMypageOrNext(next);
    }
  },
  {
    path: '/mypage',
    component: Mypage,
    beforeEnter: (to, from, next) => {
      redirectTopOrNext(next);
    }
  },
  {
    path: '/search',
    component: Search,
    beforeEnter: (to, from, next) => {
      redirectTopOrNext(next);
    },
  },
  {
    path: '/register',
    component: Register,
    beforeEnter: (to, from, next) => {
      redirectMypageOrNext(next);
    }
  }
];

function redirectTopOrNext(next) {
  if (store.state.isLogin) {
    next();
  } else {
    next('/');
  }
}

function redirectMypageOrNext(next) {
  if (store.state.isLogin) {
    next('/mypage');
  } else {
    next();
  }
}

const router = new VueRouter({
  mode: 'history',
  routes,
});

export default router;