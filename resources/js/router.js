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
        component: () => import("./components/Product/productComponent.vue"),
        children: [
            // {
            //     path: "",
            //     name: "product.index",
            //     component: () => import("./components/Product/indexComponent.vue"),
            // },
            {
                path: "add",
                name: "product.add",
                component: () => import("./components/Product/addProductComponent.vue"),
            },
            // {
            //     path: "edit/:id",
            //     name: "product.edit",
            //     component: () => import("./components/Product/editComponent.vue"),
            // },
        ],
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
