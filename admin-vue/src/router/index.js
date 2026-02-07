import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../view/Dashboard.vue";
import Login from "../view/Login.vue";
import ResetPassword from "../view/ResetPassword.vue";
import RequestPassword from "../view/RequestPassword.vue";
import store from "../store";
import NotFound from "../view/NotFound.vue";
import Products from "../view/products/Products.vue";
import AppLayout from "../ui/AppLayout.vue";

const routes = [
    {
        path: "/app",
        name: "app",
        component: AppLayout,
        children: [
            {
                path: "dashboard",
                name: "app.dashboard",
                component: Dashboard,
                meta: {
                    requiresAuth: true,
                },
            },

            {
                path: "products",
                name: "app.products",
                component: Products,
            },
        ],
    },

    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            requiresGuest: true,
        },
    },
    {
        path: "/reset-password/:token",
        name: "resetPassword",
        component: ResetPassword,
        meta: {
            requiresGuest: true,
        },
    },
    {
        path: "/request-password/",
        name: "requestPassword",
        component: RequestPassword,
        meta: {
            requiresGuest: true,
        },
    },
    {
        path: "/:pathMatch(.*)",
        name: "notFound",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "login" });
    } else if (to.meta.requiresGuest && store.state.user.token) {
        next({ name: "app.dashboard" });
    } else {
        next();
    }
});

export default router;
