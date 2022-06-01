require("./bootstrap");

window.Vue = require("vue").default;
import VueRouter from "vue-router";
import routes from "./routes";
Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    router: new VueRouter(routes),
    data() {
        return {
            isLogin: "",
        };
    },
    beforeUpdate() {
        axios.get("/api/authenticate").then((res) => {
            if (res.data.length == 1) {
                this.isLogin = true;
            } else {
                this.isLogin = false;
            }
        });
    },
});
