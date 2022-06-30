import Vue from "vue";
import store from '../vuex/index'
// console.log(Object.keys(store.getters.user).length > 1)


const authMiddleware = (to, from, next) => {
    if ( !Vue.prototype.$cookies.get("token") && (to.name !== 'login' || to.name !== 'register')) {
        next({
            path: 'login',
            replace: true
        })
    } else {
        next()
    }
}

const notAuthMiddleware = (to, from, next) => {
    if ( Object.keys(store.getters.user).length > 1) {
        next({
            path: '/',
            replace: true
        })
    } else {
        next()
    }
}

export const routes =  {
    mode:'history',
    routes: [
        {
            path: '/',
            component: () => import('../pages/index'),
            beforeEnter: authMiddleware
        }
        , {
            path: '/login',
            component: () => import('../pages/Login'),
            beforeEnter : notAuthMiddleware,

        },
        {
            path: '/register',
            component: () => import('../pages/Register'),
            beforeEnter : notAuthMiddleware,
        },
        {
            path: '/store',
            component: () => import('../pages/Create'),
            beforeEnter: authMiddleware
        },
        {
            path: '/show',
            component: () => import('../pages/Show'),
            beforeEnter: authMiddleware
        }
    ]
}
