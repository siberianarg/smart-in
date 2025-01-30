import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/people",
        component: () => import("./components/Person/index"),
        name: "person.index",
    },
    {
        path: "/people/create",
        component: () => import("./components/Person/create"),
        name: "person.create",
    },
    {
        path: "/people/:id/edit", //динамичный параметр для роутра
        component: () => import("./components/Person/edit"),
        name: "person.edit",
    },
    {
        path: "/people/show", 
        component: () => import("./components/Person/show"),
        name: "person.show",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
