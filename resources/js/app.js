import { createApp } from "vue";

import AppComponent from "./components/AppComponent.vue";
import PostComponent from "./components/PostComponent.vue";
import ThirdComponent from "./components/ThirdComponent.vue";

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

createVue(app, "#app", AppComponent);
createVue(appThird, "#appThird", PostComponent);
createVue(appSecond, "#appSecond", ThirdComponent);
