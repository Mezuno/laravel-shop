import {createRouter, createWebHistory} from 'vue-router'
import store from '@/store'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL), routes: [
        {
            path: '/', name: 'index', // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import('../views/main/index.vue')
        },
        {
            path: '/products',
            name: 'products.index',
            component: () => import('../views/products/index.vue')
        },
        {
            path: '/products/:id',
            name: 'products.show',
            component: () => import('../views/products/show.vue')
        },
        {
            path: '/cart',
            name: 'cart',
            component: () => import('../views/cart/index.vue')
        },
        {
            path: '/profile',
            meta: {
                middleware: "auth"
            },
            name: 'profile', // route level code-splitting
            component: () => import('../views/personal/Profile.vue')
        },
        {
            path: '/user/login',
            name: 'user.login', // route level code-splitting
            meta: {
                middleware: "guest"
            },
            component: () => import('../views/auth/Login.vue')
        },
        {
            path: '/user/registration',
            name: 'user.registration', // route level code-splitting
            meta: {
                middleware: "guest"
            },
            component: () => import('../views/auth/Registration.vue')
        },
        {
            path: '/wishlist',
            meta: {
                middleware: "auth"
            },
            name: 'wishlist', // route level code-splitting
            component: () => import('../views/wishlist/index.vue')
        },
        {
            path: '/orders',
            meta: {
                middleware: "auth"
            },
            name: 'orders', // route level code-splitting
            component: () => import('../views/orders/index.vue')
        },
        {
            path: '/purchases',
            meta: {
                middleware: "auth"
            },
            name: 'purchases', // route level code-splitting
            component: () => import('../views/purchases/index.vue')
        },
    ]
})

router.beforeEach((to, from, next) => {

    document.title = to.meta.title

    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "profile" })
        }
        next()
    } else if (to.meta.middleware == "auth") {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    } else {
        next()
    }
})

export default router
