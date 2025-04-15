import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save

const routes = [
    {
        path : '/dashboard',
        component: ()=>import('../components/Dashboard/index.vue')
    },
    {
        path : '/benefit-plans',
        component: ()=>import('../components/BenefitPlans/index.vue')
    },
    {
        path : '/personals',
        component: ()=>import('../components/Personals/index.vue')
    },
    {
        path : '/job-history',
        component: ()=>import('../components/JobHistory/index.vue')
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router