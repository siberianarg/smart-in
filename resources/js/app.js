import { createApp } from 'vue';

import AppComponent from './components/AppComponent.vue';

import vuetify from './plugins/vuetify';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './bootstrap';

// Создаем экземпляр Vue и подключаем роутер
const app = createApp(AppComponent);

app.use(vuetify);
app.mount('#app');