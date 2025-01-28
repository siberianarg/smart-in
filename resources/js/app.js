import { createApp } from "vue";

import appComponent from "./components/appComponent.vue";
import postComponent from "./components/postComponent.vue";

import vuetify from "./plugins/vuetify";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./bootstrap";

// Создаем экземпляр Vue и подключаем роутер

function createVue(name, containerId, component) {
    name = createApp(component);
    name.use(vuetify);
    name.mount(containerId);
}

createVue(app, "#app", appComponent);
createVue(appSecond, "#appSecond", postComponent);
// createVue(appThird, "#appThird", thirdComponent);
// createVue(appCreate, "#appCreate", createComponent);
