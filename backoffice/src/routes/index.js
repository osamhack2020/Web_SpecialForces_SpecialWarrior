import Vue from 'vue';
import VueRouter from 'vue-router';
import { store } from '../store';
import loginpage from '../components/loginpage.vue';
import mainpage from '../components/mainpage.vue';

Vue.use(VueRouter);

const requireAuth = () => (to, from, next) => { 
    if(store.state.tokenData ){
        return next();
    }
    next('/login');
}

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: mainpage,
            beforeEnter:requireAuth(),
        },
        {
            path: '/login',
            name: 'login',
            component: loginpage
        },
    ]
});

export default router;