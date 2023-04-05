import './bootstrap'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import '../css/client/assets/cart.css'
import '../css/client/assets/hover-prdouct-card.css'
import '../css/client/assets/scroll-barr.css'
import '../css/client/assets/homePage.css'
import '../css/client/assets/cart-card.css'

const app = createApp(App)

app.use(router)
// app.config.globalProperties.axios = axios
app.mount('#app')
