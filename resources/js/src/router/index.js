import { createRouter, createWebHashHistory } from "vue-router";
import { defineAsyncComponent } from "vue";
import LoadingC from '@/components/Reusable/LoadingC.vue'

const routes = [
  {
    // Document title tag
    // We combine it with defaultDocumentTitle set in `src/main.js` on router.afterEach hook
    meta: {
      title: "Dashboard",
    },
    path: "/",
    name: "dashboard",
    component: defineAsyncComponent({
      loader: () => import("../views/HomeView.vue"),
      loadingComponent: LoadingC
    }),
  },
  {
    meta: {
      title: "Login",
    },
    path: "/login",
    name: "login",
    component: defineAsyncComponent({
      loader: () => import("../views/LoginView.vue"),
    }),
  },
  {
    meta: {
      title: "Ordenes",
    },
    path: "/orders",
    name: "orders",
    component: defineAsyncComponent({
      loader: () => import("../views/OrderView.vue"),
    }),
  },
  {
    meta: {
      title: "Ventas",
    },
    path: "/sales",
    name: "sales",
    component: defineAsyncComponent({
      loader: () => import("../views/SalesView.vue"),
    }),
  },
  {
    meta: {
      title: "Usuarios",
    },
    path: "/users",
    name: "users",
    component: defineAsyncComponent({
      loader: () => import("../views/UsersView.vue"),
    }),
  },
  {
    meta: {
      title: "Profile",
    },
    path: "/profile",
    name: "profile",
    component: defineAsyncComponent({
      loader: () => import("../views/ProfileView.vue"),
    }),
    // component: () => import("../views/ProfileView.vue"),
  },
  {
    meta: {
      title: "Error",
    },
    path: "/error",
    name: "error",
    component: defineAsyncComponent({
      loader: () => import("../views/ErrorView.vue"),
    }),
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
