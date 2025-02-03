import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/tasks",
        component: () => import("./components/Task/indexComponent.vue"),
        name: "task.index",
    },
    {
        path: "/tasks/add",
        component: () => import("./components/Task/addComponent.vue"),
        name: "task.add",
    },
    {
        path: "/tasks/edit/:id",
        component: () => import("./components/Task/editComponent.vue"),
        name: "task.edit",
    },
    {
        path: "/tasks/:id", 
        component: () => import("./components/Task/showComponent"),
        name: "task.show",
    }
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
