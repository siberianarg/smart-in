import { createRouter, createWebHistory } from "vue-router";

// import peopleIndex from "./components/indexComponent.vue";
import peopleCreate from "./components/createComponent.vue";
import peopleEdit from "./components/editComponent.vue";


const routes = [
    {
        path: "/people",
        component: () => import("./components/indexComponent.vue"),
        name: "people.index",
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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
