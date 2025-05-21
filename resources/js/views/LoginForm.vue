<template>
    <div class="form-wrapper">
        <form @submit.prevent="handleLogin">
            <h1>Login Petugas</h1>
            <input v-model="email" type="email" placeholder="Gmail" required />
            <input
                v-model="password"
                type="password"
                placeholder="Password"
                required
            />
            <button type="submit">Login</button>
            <p v-if="error">{{ error }}</p>
        </form>
    </div>
</template>

<style scoped>
h1 {
    display: flex;
    margin-right: 35px;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.form-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f2f2f2; /*bg main */
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    width: 350px;
    padding: 20px;
    background-color: #b6b09f;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
}

input {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 10rem;
    padding: 12px 16px;
    border: 1px solid white;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    border-radius: 100px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
    background-color: white;
}

input:hover {
    width: 16rem;
    padding: 12px 16px;
}

input:focus {
    background-color: #eae4d5;
    border: none;
    width: 16rem;
    padding: 12px 16px;
}

button {
    background-color: white;
    border-radius: 12px;
    width: 10rem;
    margin-bottom: 20px;
    padding: 12px 16px;
    border: none;
    outline: none;
}

button:hover {
    background-color: #eae4d5;
    transition: 0.3s;
}

p {
    color: #e74c3c;
    /* opacity: 0.5; */
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;
}
</style>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const error = ref("");

axios.defaults.baseURL = "https://magang.partnership.co.id/";
axios.defaults.withCredentials = true;

async function handleLogin() {
    error.value = "";
    try {
        const response = await axios.post(
            "https://magang.partnership.co.id/api/login",
            {
                email: email.value,
                password: password.value,
            }
        );

        localStorage.setItem("token", response.data.token);
        // alert("Login berhasil!");
        // window.location.href = "/dashboard";

        router.push("/dashboard");
    } catch (e) {
        console.error("Login error:", e);
        if (e.response) {
            // tampilkan error asli dari Laravel jika ada
            error.value =
                e.response.data.message || "Email atau password salah";
        } else {
            error.value = "Gagal menghubungi server.";
        }
    }
}
</script>
