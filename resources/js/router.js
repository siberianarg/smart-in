import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/tasks",
        component: () => import("./components/Task/taskDetailsComponent.vue"),
        // name: "taskDetails.index",
        children: [
            {
                path: "",
                component: () => import("./components/Task/indexComponent.vue"),
                name: "task.index",
            },
            {
                path: "add",
                component: () => import("./components/Task/addComponent.vue"),
                name: "task.add",
            },
            {
                path: "edit/:id",
                component: () => import("./components/Task/editComponent.vue"),
                name: "task.edit",
            },
            {
                path: ":id",
                component: () => import("./components/Task/showComponent.vue"),
                name: "task.show",
            },
        ],
    },
    {
        path: "/products",
        component: () =>
            import("./components/Product/productDetailsComponent.vue"),
        name: "productDetails.index",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
