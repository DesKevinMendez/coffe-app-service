import { createRouter, createWebHashHistory, RouteRecordRaw } from "vue-router";
import LayoutAuthenticatedVue from "@/layouts/LayoutAuthenticated.vue";

const routes: RouteRecordRaw[] = [
  {
    path: "/",
    component: LayoutAuthenticatedVue,
    children: [
      {
        meta: {
          title: "Dashboard",
        },
        path: "/",
        name: "home",
        component: import("@/views/HomeView.vue"),
      },
      {
        meta: {
          title: "Ordenes",
        },
        path: "/orders",
        name: "orders",
        component: () => import("@/views/OrderView.vue"),
      },

      {
        meta: {
          title: "Ventas",
        },
        path: "/sales",
        name: "sales",
        component: () => import("@/views/SalesView.vue"),
      },
      {
        meta: {
          title: "Usuarios",
        },
        path: "/users",
        name: "users",
        component: () => import("@/views/UsersView.vue"),
      },
      {
        meta: {
          title: "Profile",
        },
        path: "/profile",
        name: "profile",
        component: () => import("@/views/ProfileView.vue"),
      },
      {
        name: "permanents",
        meta: {
          title: "Permanentes",
        },
        path: "/products",
        component: () => import("@/views/ProductsView.vue"),
      },
    ],
  },
  {
    meta: {
      title: "Login",
    },
    path: "/login",
    name: "login",
    component: () => import("@/views/LoginView.vue"),
  },
  {
    meta: {
      title: "Error",
    },
    path: "/error",
    name: "error",
    component: () => import("@/views/ErrorView.vue"),
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
