import { createApp } from "vue"

import index from "./components/index.vue"
import router from './router'

import vuetify from "./plugins/vuetify"
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.bundle.min.js"
import "./bootstrap"

// Создаем экземпляр Vue и подключаем роутер
const app = createApp(index)

app.use(vuetify)
app.use(router)
app.mount('#app')
