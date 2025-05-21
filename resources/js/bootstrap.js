import axios from "axios";
window.axios = axios;

axios.defaults.baseURL = "https://magang.partnership.co.id/";
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
