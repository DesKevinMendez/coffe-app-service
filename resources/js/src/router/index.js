import { createRouter, createWebHashHistory } from "vue-router";
import { defineAsyncComponent } from "vue";

const routes = [
  {
    // Document title tag
    // We combine it with defaultDocumentTitle set in `src/main.js` on router.afterEach hook
    meta: {
      title: "Dashboard",
    },
    path: "/",
    name: "dashboard",
    component: defineAsyncComponent(() => import("../views/HomeView.vue")),
  },
  {
    meta: {
      title: "Login",
    },
    path: "/login",
    name: "login",
    component: defineAsyncComponent(() => import("../views/LoginView.vue")),
    // component: () => import("../views/LoginView.vue"),
  },
  {
    meta: {
      title: "Ordenes",
    },
    path: "/orders",
    name: "orders",
    component: defineAsyncComponent(() => import("../views/OrderView.vue")),
    // component: () => import("../views/LoginView.vue"),
  },
  {
    meta: {
      title: "Usuarios",
    },
    path: "/users",
    name: "users",
    component: defineAsyncComponent(() => import("../views/UsersView.vue")),
    // component: () => import("../views/LoginView.vue"),
  },
  {
    meta: {
      title: "Profile",
    },
    path: "/profile",
    name: "profile",
    component: defineAsyncComponent(() => import("../views/ProfileView.vue")),
    // component: () => import("../views/ProfileView.vue"),
  },
  {
    meta: {
      title: "Error",
    },
    path: "/error",
    name: "error",
    component: defineAsyncComponent(() => import("../views/ErrorView.vue")),
    // component: () => import('@/views/ErrorView.vue')
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { top: 0 };
  },
});

export default router;
