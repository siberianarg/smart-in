import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: '/people', component: function() { return import('./components/Person/index.vue')},
        name: 'people.index' 
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
