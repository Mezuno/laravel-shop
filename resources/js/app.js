import './bootstrap'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import '../css/app.css'
import "../css/client/scss/booooootstrap-up.scss"

const app = createApp(App)

// COMPONENTS
import productCardInCatalog from "./components/productCardInCatalog.vue";
app.component('product-card-in-catalog', productCardInCatalog)
import wishHeart from "./components/UI/wishHeart.vue";
app.component('wish-heart', wishHeart)
import modalWindow from "./components/UI/modalWindow.vue";
app.component('modal-window', modalWindow)

app.use(router)
// app.config.globalProperties.axios = axios
app.mount('#app')


