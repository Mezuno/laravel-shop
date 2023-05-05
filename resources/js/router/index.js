import {createRouter, createWebHistory} from 'vue-router'
import store from '@/store'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL), routes: [
        {
            path: '/', name: 'index', // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            meta: {
                title: "Store | Главная",
            },
            component: () => import('../views/main/index.vue')
        },
        {
            path: '/products',
            name: 'products.index',
            meta: {
                title: "Store | Каталог",
            },
            component: () => import('../views/products/index.vue')
        },
        {
            path: '/products/:id',
            name: 'products.show',
            meta: {
                title: "Store | Товар",
            },
            component: () => import('../views/products/show.vue')
        },
        {
            path: '/cart',
            name: 'cart',
            meta: {
                title: "Store | Корзина",
            },
            component: () => import('../views/cart/index.vue')
        },
        {
            path: '/profile',
            meta: {
                title: "Store | Профиль",
                middleware: "auth"
            },
            name: 'profile', // route level code-splitting
            component: () => import('../views/personal/Profile.vue')
        },
        {
            path: '/user/login',
            name: 'user.login', // route level code-splitting
            meta: {
                title: "Store | Вход",
                middleware: "guest"
            },
            component: () => import('../views/auth/Login.vue')
        },
        {
            path: '/user/registration',
            name: 'user.registration', // route level code-splitting
            meta: {
                title: "Store | Регистрация",
                middleware: "guest"
            },
            component: () => import('../views/auth/Registration.vue')
        },
        {
            path: '/wishlist',
            meta: {
                title: "Store | Избранное",
                middleware: "auth"
            },
            name: 'wishlist', // route level code-splitting
            component: () => import('../views/personal/wishlist/index.vue')
        },
        {
            path: '/orders',
            meta: {
                title: "Store | Заказы",
                middleware: "auth"
            },
            name: 'orders', // route level code-splitting
            component: () => import('../views/personal/orders/index.vue')
        },
        {
            path: '/purchases',
            meta: {
                title: "Store | Покупки",
                middleware: "auth"
            },
            name: 'purchases', // route level code-splitting
            component: () => import('../views/personal/purchases/index.vue')
        },
        {
            path: '/404',
            meta: {
                title: "Store | 404",
            },
            props: { errorMessage: null },
            name: '404', // route level code-splitting
            component: () => import('../views/404.vue')
        },
        {
            meta: {
                title: "Store | 404",
            },
            path: "/:pathMatch(.*)*",
            component: () => import('../views/404.vue')
        }
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
