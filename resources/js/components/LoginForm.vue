<template>
    <div class="login-form">
        <h2>Login Petugas</h2>
        <form @submit.prevent="handleLogin">
            <div>
                <input
                    v-model="email"
                    type="email"
                    placeholder="Email"
                    required
                />
            </div>
            <div>
                <input
                    v-model="password"
                    type="password"
                    placeholder="Password"
                    required
                />
            </div>
            <button type="submit">Login</button>

            <div v-if="error" style="color: red">{{ error }}</div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const email = ref("");
const password = ref("");
const error = ref("");

const handleLogin = async () => {
    error.value = "";
    try {
        const response = await axios.post("/api/login", {
            email: email.value,
            password: password.value,
        });

        // Simpan token ke localStorage
        localStorage.setItem("token", response.data.token);

        alert("Login berhasil!");

        // Redirect atau tampilkan dashboard
        // window.location.href = '/dashboard' // nanti jika ada halaman dashboard
    } catch (e) {
        error.value = "Email atau password salah";
    }
};
</script>
