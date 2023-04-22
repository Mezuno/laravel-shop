import './bootstrap'
import { createApp } from 'vue'
import App from './App.vue'
import router from '@/router'
import store from '@/store'
import '../css/app.css'
import "../css/client/scss/booooootstrap-up.scss"
import 'vue3-carousel/dist/carousel.css'
import '../css/client/assets/carousel.scss'
import '../css/client/assets/awesome-scrollbar.scss'

const app = createApp(App)

// COMPONENTS
import productCardInCatalog from "./components/productCardInCatalog.vue";
app.component('product-card-in-catalog', productCardInCatalog)
import wishHeart from "./components/UI/wishHeart.vue";
app.component('wish-heart', wishHeart)
import modalWindow from "./components/UI/modalWindow.vue";
app.component('modal-window', modalWindow)


app.use(router)
app.use(store)
// app.config.globalProperties.axios = axios
app.mount('#app')
