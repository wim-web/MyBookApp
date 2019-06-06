import Vue from 'vue';
import VueRouter from 'vue-router';

import Search from './pages/Search';

Vue.use(VueRouter);

const routes = [
    // {
    //     path: '/',
    //     component:
    // },
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