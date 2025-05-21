import { createRouter, createWebHistory } from "vue-router";
import LoginForm from "../views/LoginForm.vue";
import Dashboard from "../views/Home.vue";
import BookList from "../components/BookList.vue";
import UserList from "../components/UserList.vue";
import LoanList from "../components/LoanList.vue";

const routes = [
    { path: "/login", name: "login", component: LoginForm },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    {
        path: "/BookList",
        name: "BookList",
        component: BookList,
        meta: { requiresAuth: true },
    },
    {
        path: "/UserList",
        name: "UserList",
        component: UserList,
        meta: { requiresAuth: true },
    },
    {
        path: "/LoanList",
        name: "LoanList",
        component: LoanList,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.meta.requiresAuth && !token) {
        next("/login");
    } else if (to.path === "/login" && token) {
        next("/dashboard");
    } else {
        next();
    }
});

export default router;
