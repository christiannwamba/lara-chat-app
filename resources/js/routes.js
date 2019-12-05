import Vue from 'vue';
import VueRouter from "vue-router";
import Login from './views/Login';
import Register from "./views/Register";
import Chat from "./views/Chat";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'homepage',
            redirect: 'login'
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/chat',
            name: 'chat',
            component: Chat,
        },
        {
            path: '*',
            name: 'Not found',
            redirect: 'login'
        }
    ]
})

