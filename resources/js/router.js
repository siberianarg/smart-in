import { createRouter, createWebHistory } from "vue-router";

import peopleIndex from "./components/indexComponent.vue";
import peopleCreate from "./components/createComponent.vue";
import peopleEdit from "./components/editComponent.vue";
import notFound from "./components/editComponent.vue";

const routes = [
    {
        path: "/people",
        name: "people.index",
        component: peopleIndex,
    },
    {
        path: "/people/add",
        name: "people.add",
        component: peopleCreate,
    },
    {
        path: "/people/edit/:id",
        name: "people.edit",
        component: peopleEdit,
        props: true,
    },
    {
        path: "/:pathMatch(.*)*",
        name: "notfound",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
