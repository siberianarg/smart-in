import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: '/people', component: () => import('./components/Person/index'),
        name: 'people.index' 
    },
    {
        path: '/people/create', component: () => import('./components/Person/create'),
        name: 'people.create' 
    },
];

const router = createRouter({ 
    history: createWebHistory(),
    routes,
});

export default router;
