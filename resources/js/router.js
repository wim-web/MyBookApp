import Vue from 'vue';
import VueRouter from 'vue-router';

import store from './vuex/store';

import Top from './pages/Top';
import Mypage from './pages/Mypage';
import Search from './pages/Search';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Top,
        beforeEnter: (to, from, next) => {
            if (store.state.isLogin) {
                next('/mypage');
            } else {
                next();
            }
        }
    },
    {
        path: '/mypage',
        component: Mypage,
        beforeEnter: (to, from, next) => {
            if (store.state.isLogin) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/search',
        component: Search,
        beforeEnter: (to, from, next) => {
            if (store.state.isLogin) {
                next();
            } else {
                next('/');
            }
        },
    }
];

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;