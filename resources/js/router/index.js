import {createRouter, createWebHistory} from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL), routes: [{
        path: '/', name: 'index', // route level code-splitting
        // this generates a separate chunk (About.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import('../views/main/index.vue')
    }, {
        path: '/products', name: 'products.index', component: () => import('../views/products/index.vue')
    }, {
        path: '/products/:id', name: 'products.show', component: () => import('../views/products/show.vue')
    }, {
        path: '/cart', name: 'cart', component: () => import('../views/cart/index.vue')
    },]
})

export default router
