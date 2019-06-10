import Vue from 'vue';
import VueRouter from 'vue-router';

import Top from './pages/Top';
import Mypage from './pages/Mypage';
import Search from './pages/Search';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Top,
    },
    {
        path: '/mypage',
        component: Mypage,
    },
    {
        path: '/search',
        component: Search,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;