import Vue from 'vue';
import VueRouter from 'vue-router';
import { store } from '../store';
import axios from 'axios';

import loginpage from '../view/loginpage.vue';
import mainpage from '../view/mainpage.vue';
import notfound from '../view/notfound.vue';
import soldiermanagement from '../view/children/soldiermanagement.vue';
import faq from '../view/children/faq.vue';
import notice from '../view/children/notice.vue';
Vue.use(VueRouter);

const requireAuth = () => (to, from, next) => { 
    if(store.state.tokenData && store.state.userData){
        if(!axios.defaults.headers.common['Authorization']){
            store.commit("OnLoginSuccess"); //called only once if Header is not set (On refreshing page)
            store.commit("AfterLoginSuccess");
        }
        return next();
    }
    next('/login');
}

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            name: 'notfound',
            component: notfound,
        },
        {
            path: '/',
            name: 'home',
            component: mainpage,
            beforeEnter:requireAuth(),
            children: [
                { path: "", component: soldiermanagement },
                { path: "/management", component: soldiermanagement },
                { path: "/faq", component: faq },
                { path: "/notice", component: notice },
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: loginpage,
        },
    ]
});

export default router;