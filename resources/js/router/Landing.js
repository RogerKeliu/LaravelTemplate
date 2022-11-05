import { createWebHistory, createRouter } from "vue-router";
import LandingLayout from "../Layouts/Landing/index.vue";
import AppLayout from "../Layouts/App/index.vue";

const routes = [{
    path: "/",
    name: "Welcome",
    component: LandingLayout,
}, ];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;