import { createRouter, createWebHashHistory } from "vue-router";
import Home from "../views/HomeView.vue";
import Login from "../views/LoginView.vue";
import Profile from "../views/ProfileView.vue";
import ErrorView from "../views/ErrorView.vue";
import OrderView from "../views/OrderView.vue";

const routes = [
    {
        // Document title tag
        // We combine it with defaultDocumentTitle set in `src/main.js` on router.afterEach hook
        meta: {
            title: "Dashboard",
        },
        path: "/",
        name: "dashboard",
        component: Home,
    },
    {
        meta: {
            title: "Login",
        },
        path: "/login",
        name: "login",
        component: Login,
        // component: () => import("../views/LoginView.vue"),
    },
    {
        meta: {
            title: "Ordenes",
        },
        path: "/orders",
        name: "orders",
        component: OrderView,
        // component: () => import("../views/LoginView.vue"),
    },
    {
        meta: {
            title: "Profile",
        },
        path: "/profile",
        name: "profile",
        component: Profile,
        // component: () => import("../views/ProfileView.vue"),
    },
    {
      meta: {
        title: 'Error',
      },
      path: '/error',
      name: 'error',
      component: ErrorView
      // component: () => import('@/views/ErrorView.vue')
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || { top: 0 };
    },
});

export default router;
