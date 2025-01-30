import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/tasks",
        component: () => import("./components/Task/index"),
        name: "task.index",
    },
    {
        path: "/tasks/create",
        component: () => import("./components/Task/create"),
        name: "task.create",
    },
    {
        path: "/tasks/:id/edit", //динамичный параметр для роутра
        component: () => import("./components/Task/edit"),
        name: "task.edit",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
