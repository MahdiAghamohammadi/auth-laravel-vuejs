import Home from "./components/Home";
import About from "./components/About";
import Register from "./components/Register";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
import NotFound from "./components/NotFound";
import axios from "axios";
export default {
    mode: "history",
    linkActiveClass: "font-semibold",
    routes: [
        {
            path: "*",
            component: NotFound,
        },
        {
            path: "/",
            component: Home,
            name: "Home",
        },
        {
            path: "/about",
            component: About,
        },
        {
            path: "/register",
            component: Register,
        },
        {
            path: "/login",
            component: Login,
            name: "Login",
        },
        {
            path: "/dashboard",
            component: Dashboard,
            name: "Dashboard",
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticate")
                    .then(() => {
                        next();
                    })
                    .catch(() => {
                        return next({ name: "Login" });
                    });
            },
        },
    ],
};
