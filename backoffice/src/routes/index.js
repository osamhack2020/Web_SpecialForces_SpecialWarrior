import Vue from 'vue';
import VueRouter from 'vue-router';
import { store } from '../store';
import axios from 'axios';

import loginpage from '../view/loginpage.vue';
import mainpage from '../view/mainpage.vue';
import notfound from '../view/notfound.vue';

import soldiermanagement from '../view/children/soldiermanagement.vue';
import soldierdetail from '../view/children/soldierdetail.vue';

import collection from '../view/children/collection.vue';
import collection_month from '../view/children/collection_month.vue';
import collection_day from '../view/children/collection_day.vue';

import warriorstatus from '../view/children/warriorstatus.vue';

import faq from '../view/children/faq.vue';
import faq_write from '../view/faq_write.vue';

import notice from '../view/children/notice.vue';
import notice_write from '../view/notice_write.vue';

import opensource from '../view/children/opensource.vue';
Vue.use(VueRouter);

const requireAuth = () => (to, from, next) => { 
    if(store.state.tokenData && store.state.userData){
        // store.commit("OnLoginSuccess"); //called only once if Header is not set (On refreshing page)
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
            component: mainpage,
            beforeEnter:requireAuth(),
            children: [
                { 
                    path: "/",
                    redirect: 'management'
                },
                { 
                    path: "management", component: soldiermanagement,

                    children:[
                        { path: ':user_id', component: soldierdetail},
                    ]

                },
                { 
                    path: "collection",
                    component: collection,
                    children:[
                        { path:'/', redirect:'month'},
                        { path:'month', components:{month:collection_month} },
                        { path:'day', components:{day:collection_day}, props:true }
                    ]
                },
                { path: "warriorstatus", component: warriorstatus },
                { 
                    path: "faq",
                    component: faq,
                    children:[
                        { path:"write", component: faq_write }
                    ],
                },
                { 
                    path: "notice", 
                    component: notice,
                    children:[
                        { path:"write", component: notice_write }
                    ],
                },
                {
                    path: '/opensource',
                    name: 'opensource',
                    component: opensource,
                },
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