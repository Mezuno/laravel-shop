import {createRouter, createWebHistory} from 'vue-router'

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
            name: 'profile', // route level code-splitting
            component: () => import('../views/personal/Profile.vue')
        },
        {
            path: '/user/login',
            name: 'user.login', // route level code-splitting
            component: () => import('../views/auth/Login.vue')
        },
        {
            path: '/user/registration',
            name: 'user.registration', // route level code-splitting
            component: () => import('../views/auth/Registration.vue')
        },
        {
            path: '/wishlist',
            name: 'wishlist', // route level code-splitting
            component: () => import('../views/wishlist/wishlist.vue')
        },
        {
            path: '/orders',
            name: 'orders', // route level code-splitting
            component: () => import('../views/orders/orders.vue')
        },
        {
            path: '/purchases',
            name: 'purchases', // route level code-splitting
            component: () => import('../views/purchases/purchases.vue')
        },
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')
    if (!token) {
        if (to.name === 'profile') {
            return next({
                name: 'user.login'
            })
        } else {
            return next()
        }
    }

    if (to.name === 'user.login' || to.name === 'user.registration' && token) {
        return next({
            name: 'profile'
        })
    }
    // explicitly return false to cancel the navigation
    return next()
})

export default router
