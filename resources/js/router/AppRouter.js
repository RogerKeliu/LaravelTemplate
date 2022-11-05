import UsersIndex from "../components/App/Users/Index.vue"
import Index from "../components/App/MainPage/Index.vue"
import Config from "../components/App/Config/Index.vue"
import Product from "../components/App/Products/Index.vue"
import AdminProduct from "../components/App/Admin/Index.vue"
import Albarans from "../components/App/Albarans/Index.vue"
import AlbaransScan from "../components/App/Albarans/Scanner.vue"
import NotAllowed from "../components/App/Pages/NotAllowed"
import { createRouter, createWebHistory } from 'vue-router'

const routes = [{
    path: "/app/",
    name: "/",
    component: Index,
},
{
    path: "/app/users",
    name: "users",
    component: UsersIndex,
},
{
    path: "/app/config",
    name: "config",
    component: Config,
},
{
    path: "/app/config",
    name: "config",
    component: Config,
},
{
    path: "/app/products",
    name: "products",
    component: Product,
},
{
    path: "/app/not-allowed",
    name: "notAllowed",
    component: NotAllowed,
},

{
    path: "/app/admin-products",
    name: "admin-products",
    component: AdminProduct,
    async beforeEnter(to, from, next) {
        if (await hasPermission(to)) {
            next();
        } else {
            next('/app/not-allowed');
        }
    }
},

{
    path: "/app/client-albarans",
    name: "client-albarans",
    component: Albarans,
    async beforeEnter(to, from, next) {
        if (await hasPermission(to)) {
            next();
        } else {
            next('/app/not-allowed');
        }
    }
},

{
    path: "/app/scan-albarans",
    name: "scan-albarans",
    component: AlbaransScan,
    async beforeEnter(to, from, next) {
        if (await hasPermission(to)) {
            next();
        } else {
            next('/app/not-allowed');
        }
    }
}
];

function hasPermission(to) {
    console.log(to);
    return axios
        .post("/api/canView", {
            'route': to
        })
        .then((response) => {
            if (response.data === true) {
                return true;
            } else {
                return false;
            }
        })
        .catch((error) => {
            return false;
        });
}

export const AppRouter = createRouter({
    history: createWebHistory(),
    routes: routes,
})
