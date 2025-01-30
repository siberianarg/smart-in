import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/tasks",
        component: () => import("./components/Task/index.vue"),
        name: "task.index",
    },
    {
        path: "/tasks/add",
        component: () => import("./components/Task/add.vue"),
        name: "task.add",
    },
    {
        path: "/tasks/edit/:id",
        component: () => import("./components/Task/edit.vue"),
        name: "task.edit",
    },
    {
        path: "/tasks/:id", 
        component: () => import("./components/Task/show"),
        name: "task.show",
    }
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
