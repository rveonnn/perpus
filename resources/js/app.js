import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import axios from "axios";
import router from "./router";

axios.defaults.baseURL = "/api";

const app = createApp(App);
app.use(router).mount("#app");
