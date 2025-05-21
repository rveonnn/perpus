// src/services/axios.js
import axios from "axios";

const instance = axios.create({
    baseURL: "/api", // otomatis /api/login
    headers: {
        "Content-Type": "application/json",
    },
});

export default instance;
