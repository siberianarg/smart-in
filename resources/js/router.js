import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/tasks",
        component: () => import("./components/Task/taskDetailsComponent.vue"),
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
            import("./components/Product/productDetailsComponent.vue"), //productComponent.vue
        children: [
            {
                path: "",
                name: "product.index",
                component: () =>
                    import("./components/Product/indexProductComponent.vue"),
            },
            {
                path: "add",
                name: "product.add",
                component: () =>
                    import("./components/Product/addProductComponent.vue"),
            },
            {
                path: "edit/:id",
                name: "product.edit",
                component: () =>
                    import("./components/Product/editProductComponent.vue"),
            },
            {
                path: ":id",
                component: () =>
                    import("./components/Product/showProductComponent.vue"),
                name: "product.show",
                props: true
            },
        ],
    },
    {
        path: "/orders",
        component: () => import("./components/Order/orderDetailsComponent.vue"),
        children: [
            {
                path: "",
                name: "order.index",
                component: () =>
                    import("./components/Order/indexOrderComponent.vue"),
            },
            {
                path: ":id",
                component: () => import("./components/Order/showOrderComponent.vue"),
                name: "order.show",
                props: true
                
            },
            {
                path: "edit/:id",
                component: () => import("./components/Order/editOrderComponent.vue"),
                name: "order.edit",
                props: true
            },
            {
                path: "add",
                component: () => import("./components/Order/addOrderComponent.vue"),
                name: "order.add",
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
