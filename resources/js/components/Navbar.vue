<template>
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="logo">Admin Dashboard</h1>
        </div>
        <ul class="navbar-menu">
            <li>
                <router-link
                    to="/dashboard"
                    active-class="active-link"
                    class="activeClass"
                    >Dashboard</router-link
                >
            </li>
            <li>
                <router-link
                    to="/BookList"
                    active-class="active-link"
                    class="activeClass"
                    >Manage Books</router-link
                >
            </li>
            <li>
                <router-link
                    to="/UserList"
                    active-class="active-link"
                    class="activeClass"
                    >Manage User</router-link
                >
            </li>
            <li>
                <router-link
                    to="/LoanList"
                    active-class="active-link"
                    class="activeClass"
                    >Manage Loans</router-link
                >
            </li>
            <!-- Tambahkan router-link sesuai kebutuhan -->
        </ul>
        <div class="navbar-right">
            <button @click="logout" class="logout-button">Logout</button>
        </div>
    </nav>
</template>

<style>
h1 {
    margin-left: 40px;
    font-family: Arial, Helvetica, sans-serif;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #332d56;
    border-radius: 12px;
    padding: 1rem;
    color: #fffffe;
}

.navbar-menu {
    list-style: none;
    display: flex;
    gap: 3rem;
    margin: 0;
    padding: 0;
}
.navbar-menu a {
    color: black;
    text-decoration: none;
}

.logout-button {
    background-color: #f25042;
    border-radius: 20px;
    border: none;
    padding: 0.5rem 1rem;
    color: white;
    cursor: pointer;
}

li {
    background-color: white;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    color: black;
    cursor: pointer;
    display: inline;
    margin-top: 5px;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    transition: 0.5s;
    font-family: Arial, Helvetica, sans-serif;
}
li:hover {
    background-color: #eae4d5;
}

.active-link {
    color: #2c3e50;
    font-weight: bold;
    padding: 0;
    margin: 0;
}
.activeClass {
    padding: 10px 30px;
}
</style>

<script>
import axios from "axios";

export default {
    methods: {
        async logout() {
            try {
                const token = localStorage.getItem("token");

                await axios.post(
                    "https://magang.partnership.co.id//api/logout",
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );

                localStorage.removeItem("token");
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout gagal:", error);
            }
        },
    },
};
</script>
